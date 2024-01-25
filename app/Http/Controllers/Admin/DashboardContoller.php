<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventModel;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

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
        

        return $this->success([
            'active_count'=>$active_count,
            'inactive_count'=>$inactive_count,
            'event_count'=>$event_count
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
