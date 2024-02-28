<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personnel\BaranggayRequest;
use App\Models\BaranggayModel;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class BaranggayController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $baranggay =  BaranggayModel::latest()->get();
        return $this->success([
            'baranggay' => $baranggay,
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
    public function store(BaranggayRequest $brgy)
    {
        $brgy->validated($brgy->all());
        
        BaranggayModel::create([
            'city'=>$brgy->city,
            'province'=>$brgy->province,
            'purok'=>$brgy->purok,
            'baranggay'=>$brgy->baranggay,
        ]);

        return $this->success('','Successfully added!',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
      
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
    public function destroy(string $brgy)
    {   
        $brgy = BaranggayModel::find($brgy);
        
        
        if(!$brgy){
            return $this->error('','Baranggay not found',404);
        }
        $brgy->delete();
        return $this->success('', 'Successfully deleted', 204);
    }
}
