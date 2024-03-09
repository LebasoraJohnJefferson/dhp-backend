<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResidentRequest;
use App\Http\Resources\ResidentResource;
use App\Models\BaranggayModel;
use App\Models\ResidentModel;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    use HttpResponses;
    public function index(){
        
    }

    public function update(Request $request, string $id){

    }

    public function show(string $brgy_id)
    {
        $residents = ResidentModel::where('brgy_id',$brgy_id)
        ->latest()
        ->get();

        $brgyDetails = BaranggayModel::find($brgy_id);

        return $this->success([
            'residents'=>$residents,
            'brgyDetails'=>$brgyDetails
        ],null,200);
    }

    public function store(ResidentRequest $residentRequest)
    {
        $validatedResident = $residentRequest->validated();

        $brgy = BaranggayModel::find($residentRequest->brgy_id);

        if(!$brgy){
            return $this->error('','Baranggay Not Found',404);
        }

        ResidentModel::create($validatedResident);


        return $this->success('','Resident successfully created',201);
    }


    public function destroy(string $residentId){
        ResidentModel::find($residentId)->delete();
    }
}
