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
        $numericPart = str_pad($this->resident->id, 6, '0', STR_PAD_LEFT);
        $year  = $this->created_at->format('Y');
        // Format the AI key
        $aiKey = $year.'-' . $numericPart;
        $father_suffix = $this->resident->father_suffix ? $this->resident->father_suffix : '';
        return [
            "id"=>$this->id,
            "resident_id" =>$this->resident->id,
            "household_no"=>$aiKey,
            "household_member_no"=>$this->resident->resident_member->count()+2,
            "contact_number"=>$this->contact_number,
            "father"=>$this->resident->father_first_name.' '. $this->resident->father_middle_name[0]. ' ,'. $this->resident->father_last_name.' '. $father_suffix,
            "mother"=>$this->resident->mother_first_name.' '. $this->resident->mother_first_name[0]. ' ,'. $this->resident->mother_first_name,
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
