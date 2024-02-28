<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use App\Models\FamilyProfileMemberModel;
use App\Http\Requests\Personnel\FamiltyProfileMemberRequest;
use App\Http\Resources\FamilyProfileMembersResource;
use App\Models\FamilyProfileModel;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FamilyProfileMemberController extends Controller
{
    use HttpResponses;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FamiltyProfileMemberRequest $family_prof_child)
    {
        $family_prof_child->validated($family_prof_child->all());
        FamilyProfileMemberModel::create([
            'FP_id'=>$family_prof_child->FP_id,
            'first_name'=>$family_prof_child->first_name,
            'middle_name'=>$family_prof_child->middle_name,
            'last_name'=>$family_prof_child->last_name,
            'suffix'=>$family_prof_child->suffix ? $family_prof_child->suffix : null,
            'birthDay'=>$family_prof_child->birthDay,
            'gender'=>$family_prof_child->gender,
            'occupation'=>$family_prof_child->occupation,
            'relationship'=>$family_prof_child->relationship,
            'nursing_type'=>$family_prof_child->nursing_type
        ]);
        return $this->success('','Successfully added!',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $FP_id)
    {
        $fam_member =  FamilyProfileMemberModel::where('FP_id',$FP_id)
        ->latest()
        ->get();
        return FamilyProfileMembersResource::collection($fam_member);

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
    public function update(string $id ,FamiltyProfileMemberRequest $fpc_updated_details)
    {
        $fpc_updated_details->validated($fpc_updated_details->all());
        $FP = FamilyProfileMemberModel::find($id);
        if(!$FP){
            return $this->error('','Profile family member not found',404);
        }
        $FP->update($fpc_updated_details->all());
        return $this->success('','Successfully updated',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $FPCid)
    {
        $FP = FamilyProfileMemberModel::find($FPCid);
        if(!$FP){
            return $this->error('','Profile family not found',404);
        }
        $FP->delete();
        return $this->success('', 'Successfully deleted', 204);
    }


    public function saveImportedFCM(Request $data,string $FP_id){
        $FPM = FamilyProfileModel::find($FP_id);
        if(!$FPM){
            return $this->error('','Profile family not found',404);
        }

        foreach($data->familiesMemberData as $info){
            $validator = Validator::make($info, [
                'first_name'=>['required','string'],
                'middle_name'=>['required','string'],
                'last_name'=>['required','string'],
                'suffix'=>['string','nullable'],
                'birthDay'=>['required','date'],
                'nursing_type'=>['string','nullable'],
                'relationship'=>['string'],
                'occupation'=>['string'],
                'gender'=>['string']
            ]);

            $suffix = isset($info['suffix']) ? $info['suffix'] : null;

            error_log(isset($info['suffix']) ? $info['suffix'] : null);

            $FP_member_exist = FamilyProfileMemberModel::where('first_name',$info['first_name'])
            ->where('middle_name',$info['middle_name'])
            ->where('last_name',$info['last_name'])
            ->where('suffix',$suffix)
            ->where('FP_id',$FP_id)
            ->first();

            if (!$validator->fails() && !$FP_member_exist) {
                FamilyProfileMemberModel::create([
                    'FP_id'=>$FP_id,
                    'first_name'=>$info['first_name'],
                    'middle_name'=>$info['middle_name'],
                    'last_name'=>$info['last_name'],
                    'suffix'=>isset($info['suffix']) ? $info['suffix'] : null,
                    'birthDay'=>$info['birthDay'],
                    'gender'=>$info['gender'],
                    'occupation'=>$info['occupation'],
                    'relationship'=>$info['relationship'],
                    'nursing_type'=>$info['nursing_type']
                ]);
            }else{
                error_log($validator->errors());
            }
        }
        return $this->success('','Successfully added!',201);
    }
}
