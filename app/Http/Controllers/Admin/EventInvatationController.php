<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BaranggayModel;
use App\Models\EventInvitationModel;
use App\Models\FamilyProfileModel;
use App\Traits\HttpResponses;
use App\Traits\SmsSender;
use Illuminate\Http\Request;

class EventInvatationController extends Controller
{

    use HttpResponses;
    use SmsSender;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated_request = $request->validate([
            'event_id' => 'required|integer',
            'brgy_id'=>'required|integer'
        ]);


        $already_exist = EventInvitationModel::where(
            'brgy_id', $validated_request['brgy_id']
        )->where(
            'event_id', $validated_request['event_id']
        )->first();

        if(!$already_exist){
            EventInvitationModel::create([
                'event_id'=>$request->event_id,
                'brgy_id'=>$request->brgy_id
            ]);
        }

        $event = EventInvitationModel::where('event_id',$request->event_id)->first();

        $contact_every_person = FamilyProfileModel::all();
        $msg = 'Title: ' . $event->event->title
        . ' When: ' . date('F j, Y', strtotime($event->event->date))
        . ' Where: ' . $event->event->venue
        . ' What: ' . $event->event->description;



        foreach($contact_every_person as $person){
            if($person->brgys){
                if ($person->brgys->id == $request->brgy_id){
                    $contactNumber = $person->contact_number;
                    if (substr($contactNumber, 0, 2) === "09") {
                        $contactNumber = "639" . substr($contactNumber, 2);
                    }
                    $this->sendSms($msg,$contactNumber);
    
                }
            }
        }


        $this->success('','Successfully Invited');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $eventId)
    {
        $eventId = (int)$eventId;
        $provinces = BaranggayModel::whereNotIn('id', function ($query) use ($eventId) {
            $query->select('brgy_id')
                  ->from('event_invitation')
                  ->where('event_id', $eventId);
        })->get();


        return $this->success([
            'provinces'=>$provinces
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventInvitationModel $event_invitation)
    {
        $event_invitation->delete();
        $this->success('','Successfully Deleted',204);
    }


    public function invited_province(string $event_id){
        $invited_provinces = EventInvitationModel::with('brgy')
        ->where('event_id', $event_id)
        ->latest()
        ->get();

        if ($invited_provinces->isEmpty()) {
            return $this->success([]);
        }

        return $this->success($invited_provinces);
    }
}
