<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personnel\FamiltyProfileRequest;
use App\Http\Resources\FamilyProfileResource;
use App\Models\FamilyProfileAdressModel;
use App\Models\FamilyProfileModel;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class FamiltyProfileController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FamilyProfileResource::collection(FamilyProfileModel::all()); 
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
    public function store(FamiltyProfileRequest $familty_profile)
    {
        $familty_profile->validated($familty_profile->all());
        $address_already_exist = FamilyProfileAdressModel::where('bray_id',$familty_profile->brgy_id)
            ->first();
        if($address_already_exist){
            $address_already_exist->delete();
        }

        $FP = FamilyProfileModel::create([
            'contact_number'=>$familty_profile->contact_number,
            'household_no'=>$familty_profile->household_no,
            'no_household_member'=>$familty_profile->no_household_member,
            'housthould_head'=>$familty_profile->housthould_head,
            'occupation'=>$familty_profile->occupation,
            'educ_attain'=>$familty_profile->educ_attain,
            'food_prod_act'=>$familty_profile->food_prod_act,
            'toilet_type'=>$familty_profile->toilet_type,
            'water_source'=>$familty_profile->water_source,
            'using_iodized_salt'=>$familty_profile->using_iodized_salt,
            'using_IFR'=>$familty_profile->using_IFR,
            'familty_planning'=>$familty_profile->familty_planning,
            'mother_pregnant'=>$familty_profile->mother_pregnant,
        ]);
        
        FamilyProfileAdressModel::create([
            'bray_id'=>$familty_profile->brgy_id,
            'FP_id'=>$FP->id
        ]);
        return $this->success('','Successfully added!',201);

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
    public function destroy(string $FPid)
    {   
        $FP = FamilyProfileModel::find($FPid);
        if(!$FP){
            return $this->error('','Profile family not found',404);
        }
        $FP->delete();
        return $this->success('', 'Successfully deleted', 204);
    }
}
