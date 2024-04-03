<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BaranggayModel;
use App\Models\EventModel;
use App\Models\FamilyProfileMemberModel;
use App\Models\FamilyProfileModel;
use App\Models\fileModel;
use App\Models\ResidentModel;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardContoller extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $active_count = User::where('is_active', true)
            ->where('roles','personnel')
            ->count();

        $inactive_count = User::where('is_active', false)
            ->where('roles','personnel')
            ->count();

        $event_count = EventModel::count();

        $baranggay_count = BaranggayModel::count();
        
        $document_count = Auth::user()->roles == 'admin' ? fileModel::where('is_deleted',false)->count() : fileModel::where('user_id',Auth::user()->id)
        ->where('is_deleted',false)
        ->count();

        $total_members = ResidentModel::count();

        $families = FamilyProfileModel::count();

        return $this->success([
            'active_count'=>$active_count,
            'inactive_count'=>$inactive_count,
            'event_count'=>$event_count,
            'baranggay_count'=>$baranggay_count,
            'document_count'=>$document_count,
            'population'=>$total_members,
            'families'=>$families
        ],'',200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
