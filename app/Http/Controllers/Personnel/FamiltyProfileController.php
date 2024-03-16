<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Personnel\FamiltyProfileRequest;
use App\Http\Resources\FamilyProfileResource;
use App\Http\Resources\ResidentResource;
use App\Models\BaranggayModel;
use App\Models\FamilyProfileModel;
use App\Models\ResidentModel;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class FamiltyProfileController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fam = FamilyProfileModel::latest()->get();
        return FamilyProfileResource::collection($fam);
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
        
        $FP = FamilyProfileModel::create([
            'resident_id'=>$familty_profile->resident_id,
            'contact_number'=>$familty_profile->contact_number,
            'food_prod_act'=>$familty_profile->food_prod_act,
            'toilet_type'=>$familty_profile->toilet_type,
            'water_source'=>$familty_profile->water_source,
            'using_iodized_salt'=>$familty_profile->using_iodized_salt,
            'using_IFR'=>$familty_profile->using_IFR,
            'familty_planning'=>$familty_profile->familty_planning,
            'mother_pregnant'=>$familty_profile->mother_pregnant,
            'mother_occupation' => $familty_profile->mother_occupation,
            'father_occupation' => $familty_profile->father_occupation,
            'mother_educ_attain' => $familty_profile->mother_educ_attain,
            'father_educ_attain' => $familty_profile->father_educ_attain,
        ]);

        return $this->success('','Successfully added!',201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $details = ResidentModel::with('familyProfile')->find($id);
        if(!$details){
            return $this->error('','Profile not found',404);
        }
        return new ResidentResource($details);
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
    public function update(FamiltyProfileRequest $famity_profile, string $id)
    {
        $famity_profile->validated($famity_profile->all());
        $famity_profile_exist = FamilyProfileModel::find($id);
        if (!$famity_profile_exist) {
            return $this->error('', 'Family profile not found', 404);
        }

        $famity_profile_exist->update($famity_profile->all());
        return $this->success('','Successfully updated',200);
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


    public function saveImportedFamilyProfile(Request $familty_profile){


        foreach($familty_profile->familiesData as $fp){
            $fp['mother_pregnant'] = strtolower($fp['mother_pregnant']) == 'no' ? false : true;
            $fp['using_iodized_salt'] = strtolower($fp['using_iodized_salt']) == 'no' ? false : true;
            $fp['using_IFR'] = strtolower($fp['using_IFR']) == 'no' ? false : true;
            $fp['familty_planning'] = strtolower($fp['familty_planning']) == 'no' ? false : true;
            
            $validator = Validator::make($fp, [
                'contact_number' => ['required', 'string'],
                'mother_first_name' => ['required', 'string'],
                'mother_middle_name' => ['required', 'string'],
                'mother_last_name' => ['required', 'string'],
                'mother_suffix' => ['string','nullable'],
                'father_first_name' => ['required', 'string'],
                'father_middle_name' => ['required', 'string'],
                'father_last_name' => ['required', 'string'],
                'father_suffix' =>['string','nullable'],
                'food_prod_act' => ['required', 'string'],
                'toilet_type' => ['required', 'string'],
                'water_source' => ['required', 'string'],
                'using_iodized_salt' => ['required', 'boolean'],
                'using_IFR' => ['required', 'boolean'],
                'familty_planning' => ['required', 'boolean'],
                'mother_pregnant' => ['required', 'boolean'],
                'mother_occupation' => ['required', 'string'],
                'father_occupation' => ['required', 'string'],
                'mother_educ_attain' => ['required', 'string'],
                'father_educ_attain' => ['required', 'string'],
                'mother_birthday' => ['required', 'date_format:Y-m-d'],
                'father_birthday' => ['required', 'date_format:Y-m-d']
            ]);


            // Check if validation success
            if (!$validator->fails()) {
                $father_suffix = isset($fp['father_suffix']) ? $fp['father_suffix'] : null;
                $mother_suffix = isset($fp['mother_suffix']) ? $fp['mother_suffix'] : null;
                $fp_exist = FamilyProfileModel::where('mother_first_name',$fp['mother_first_name'])
                ->where('mother_middle_name',$fp['mother_middle_name'])
                ->where('mother_last_name',$fp['mother_last_name'])
                ->where('father_first_name',$fp['father_first_name'])
                ->where('father_middle_name',$fp['father_middle_name'])
                ->where('father_last_name',$fp['father_last_name'])
                ->where('mother_suffix', $mother_suffix)
                ->where('father_suffix', $father_suffix)
                ->first();
                if(!$fp_exist){
                    $is_brgy_exist = BaranggayModel::find($fp['brgy_id']);
                    error_log(json_encode($fp['father_suffix']));
                    $FP = FamilyProfileModel::create([
                        'brgy_id'=>$is_brgy_exist ? $fp['brgy_id'] : null,
                        'contact_number'=>$fp['contact_number'],
                        
                        'mother_first_name' => $fp['mother_first_name'],
                        'mother_middle_name' => $fp['mother_middle_name'],
                        'mother_last_name' => $fp['mother_last_name'],
                        'mother_suffix' => $mother_suffix,

                        'father_first_name' => $fp['father_first_name'],
                        'father_middle_name' => $fp['father_middle_name'],
                        'father_last_name' => $fp['father_last_name'],
                        'father_suffix' =>$father_suffix,

                        'mother_birthday'=>$fp['mother_birthday'],
                        'father_birthday'=>$fp['father_birthday'],
                        'food_prod_act'=>$fp['food_prod_act'],
                        'toilet_type'=>$fp['toilet_type'],
                        'water_source'=>$fp['water_source'],
                        'using_iodized_salt'=>$fp['using_iodized_salt'],
                        'using_IFR'=>$fp['using_IFR'],
                        'familty_planning'=>$fp['familty_planning'],
                        'mother_pregnant'=>$fp['mother_pregnant'],
                        'mother_occupation' => $fp['mother_occupation'],
                        'father_occupation' => $fp['father_occupation'],
                        'mother_educ_attain' => $fp['mother_educ_attain'],
                        'father_educ_attain' => $fp['father_educ_attain'],
                    ]);
                }
            }else{
                error_log($validator->errors());
            }



        }
        return $this->success('','Successfully added!',201);
    }


}
