<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use App\Models\FamilyProfileMemberModel;
use App\Http\Requests\Personnel\FamiltyProfileMemberRequest;
use App\Http\Resources\FamilyProfileMembersResource;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

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
            'name'=>$family_prof_child->name,
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
    public function update(Request $request, string $id)
    {
        //
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
}
