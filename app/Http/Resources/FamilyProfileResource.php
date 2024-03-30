<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FamilyProfileResource extends JsonResource
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

        $father_suffix = $this->father_details->suffix ? $this->father_details->suffix : '';
        return [
            "id"=>$this->id,
            "household_no"=>$aiKey,
            "father_id"=>$this->father_id,
            "mother_id"=>$this->mother_id,
            "household_member_no"=>0,
            "contact_number"=>$this->contact_number,
            "father"=>$this->father_details ? $this->father_details->first_name.' '. $this->father_details->middle_name[0]. ' ,'. $this->father_details->last_name.' '. $father_suffix : null,
            "mother"=>$this->mother_details->first_name.' '. $this->mother_details->middle_name[0]. ' ,'. $this->mother_details->last_name,
            "toilet_type"=>$this->toilet_type,
            "food_prod_act"=>$this->food_prod_act,
            "water_source"=>$this->water_source,
            "using_iodized_salt"=>$this->using_iodized_salt,
            "using_IFR"=>$this->using_IFR,
            "familty_planning"=>$this->familty_planning,
            "mother_pregnant"=>$this->mother_pregnant,
            "mother_occupation"=>$this->mother_occupation,
            "father_occupation"=>$this->father_occupation,
            "mother_educ_attain"=>$this->mother_educ_attain,
            "father_educ_attain"=>$this->father_educ_attain,
        ];
    }
}
