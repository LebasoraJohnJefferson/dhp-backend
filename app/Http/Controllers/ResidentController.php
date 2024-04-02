<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResidentRequest;
use App\Http\Resources\ResidentResource;
use App\Models\BaranggayModel;
use App\Models\ResidentModel;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResidentController extends Controller
{
    use HttpResponses;
    public function index(){
        // $query->select('resident_id')->from('family_profile');
        $residents = ResidentModel::get();
        return $this->success($residents);
    }

    public function update(ResidentRequest $residentRequest, string $id)
    {
        $resident = ResidentModel::find($id);
    
        if (!$resident) {
            return $this->error('', 'User not found', 404);
        }
    
        $resident->brgy_id = $residentRequest->input('brgy_id');
    
        $validatedResident = $residentRequest->validated();
    
        $resident->update($validatedResident);
    
        return $this->success('', 'Successfully updated', 201);
    }

    public function show(string $brgy_id)
    {
        $residents = ResidentModel::where('brgy_id',$brgy_id)
        ->latest()
        ->get();

        foreach($residents as $resident){
            // error_log(json_encode($resident->mother_familyProfile));
            
            if($resident->mother_familyProfile){
               $household_details = $resident->mother_familyProfile;
            }else if($resident->father_familyProfile){
                $household_details = $resident->father_familyProfile;
            }else if($resident->resident_member){
                $household_details = $resident->resident_member->fam_profile ?  $resident->resident_member->fam_profile : 'N/A';
            }else{
                $household_details = 'N/A';
            }

            if($household_details!='N/A'){
                $numericPart = str_pad($household_details->id, 6, '0', STR_PAD_LEFT);
                $year  = $household_details ? $household_details->created_at->format('Y') : $household_details->created_at->format('Y') ;
                $aiKey = $year.'-' . $numericPart;
                $resident->household_no = $aiKey;
                $resident->household_id = $household_details ? $household_details->id : $household_details->id;
            }
        }

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


    public function handleResidentImport(string $brgy_id,Request $request){

        // validate the array here

        $residents = [];
        if(!$request->resident){
            return $this->error('','No Data Found',404);
        }
        $brgy = BaranggayModel::find($brgy_id);
        if(!$brgy){
            return $this->error('','Baranggay Not Found',404);
        }
        $residents = $request->resident;
            foreach($residents as $resident){
                $resident['brgy_id'] = $brgy_id;

            $residentRequest = new ResidentRequest($resident);
            $validator = Validator::make(
                $residentRequest->all(),
                $residentRequest->rules()
            );

            if (!$validator->fails()) {
                $residentExist = ResidentModel::where('first_name',$resident['first_name'])
                ->where('middle_name',$resident['middle_name'])
                ->where('last_name',$resident['last_name'])
                ->where('suffix',$resident['suffix'])
                ->first();
                if(!$residentExist){
                    ResidentModel::create($validator->validated());
                }else{
                    $residentExist->update($resident);
                }
            } else {
                return $this->error('','Validation Failures: ' . json_encode($validator->errors()->all()),409);
            }
        }
    }


}
