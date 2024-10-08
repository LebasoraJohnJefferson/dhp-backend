<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EventRequest;
use App\Http\Resources\EventResource;
use App\Traits\HttpResponses;
use App\Traits\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\EventModel;

class EventController extends Controller
{
    use HttpResponses;
    use UploadImage;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = EventModel::all()->sortByDesc('created_at');
        return EventResource::collection($events);
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $event)
    {
        $image =null;
        $validatedData  = $event->validated();
        if (array_key_exists('image', $validatedData)) {
            $image = $this->UploadImage($event->image);
        }

        EventModel::create([
            'image'=>$image,
            'title'=>$event->title,
            'description'=>$event->description,
            'date'=>$event->date,
            'venue'=>$event->venue,
            'created_at'=>$event->created_at
        ]);

        return $this->success([
            "message"=>"Event created successfully!"
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = EventModel::find($id);

        if (!$event) {
            return $this->error('', 'Event not found', 404);
        }

        return new EventResource($event);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventRequest $eventRequest, string $id)
    {
        $event = EventModel::find($id);

        if (!$event) {
            return $this->error('', 'Event not Found', 404);
        }

        $validatedData = $eventRequest->validated();

        $image = null;
        if (array_key_exists('image', $validatedData)) {
            $image = $this->UploadImage($validatedData['image']);
        }

        $eventRequest['image'] = $image ? $image : $event->image;

        $event->update($eventRequest->all());

        return $this->success([
            "message"=>"Event updated successfully!"
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EventModel $event)
    {
        $event->delete();
        return $this->success('','Event successfully deleted!',204);
    }
}
