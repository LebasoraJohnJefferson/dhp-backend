<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResidentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $numericPart = str_pad($this->id, 6, '0', STR_PAD_LEFT);
        $year  = $this->created_at->format('Y');
        // Format the AI key
        $aiKey = $year.'-' . $numericPart;
        $father_suffix = $this->father_suffix ? $this->father_suffix : '';
        error_log(json_encode($this->familyProfile));
        return [
        'id'=>$this->id,
        'attributes'=>[
            'no_household_member'=>$this->resident_member->count() + 2,
            'brgy_id'=>$this->brgy_id,
            'household_no'=>$aiKey,
            "father"=>$this->father_first_name.' '. $this->father_middle_name[0]. ' ,'. $this->father_last_name.' '. $father_suffix,
            "mother"=>$this->mother_first_name.' '. $this->mother_first_name[0]. ' ,'. $this->mother_first_name,
            'mother_birthday'=>$this->mother_birthday,
            'father_birthday'=>$this->father_birthday,
            'mother_educ_attain' => $this->mother_educ_attain,
            'father_educ_attain' => $this->father_educ_attain,
            
            'contact_number'=>$this->familyProfile ? $this->familyProfile->contact_number : null, 
            "toilet_type"=>$this->familyProfile ? $this->familyProfile->toilet_type : null,
            "food_prod_act"=>$this->familyProfile ? $this->familyProfile->food_prod_act : null,
            "water_source"=>$this->familyProfile ? $this->familyProfile->water_source : null,
            "using_iodized_salt"=>$this->familyProfile ? $this->familyProfile->using_iodized_salt : null,
            "using_IFR"=>$this->familyProfile ? $this->familyProfile->using_IFR : null,
            "familty_planning"=>$this->familyProfile ? $this->familyProfile->familty_planning : null,
            "mother_pregnant"=>$this->familyProfile ? $this->familyProfile->mother_pregnant : null,
            "mother_occupation"=>$this->familyProfile ? $this->familyProfile->mother_occupation : null,
            "father_occupation"=>$this->familyProfile ? $this->familyProfile->father_occupation : null,
            ]
        ];
    }
}
