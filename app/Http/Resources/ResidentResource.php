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
        $father_suffix = $this->father_details ? $this->father_details->suffix : '';
        return [
        'id'=>$this->id,
        'attributes'=>[
            // 'no_household_member'=>0,
            'household_no'=>$aiKey,
            "father"=>$this->father_details->first_name.' '. $this->father_details->middle_name[0]. ' ,'. $this->father_details->last_name.' '. $father_suffix,
            "mother"=>$this->mother_details->first_name.' '. $this->mother_details->middle_name[0]. ' ,'. $this->mother_details->last_name,
            'mother_birthday'=>$this->mother_details->birthday,
            'father_birthday'=>$this->mother_details->birthday,
            'mother_educ_attain' => $this->mother_educ_attain,
            'father_educ_attain' => $this->father_educ_attain ,
            'contact_number'=>$this->contact_number, 
            "toilet_type"=>$this->toilet_type,
            "food_prod_act"=>$this->food_prod_act,
            "water_source"=>$this->water_source,
            "using_iodized_salt"=>$this->using_iodized_salt,
            "using_IFR"=>$this->using_IFR,
            "familty_planning"=>$this->familty_planning,
            "mother_pregnant"=>$this->mother_pregnant,
            "mother_occupation"=>$this->mother_details ? $this->mother_details->occupation : null,
            "father_occupation"=>$this->father_details ? $this->father_details->occupation : null,
            ]
        ];
    }
}
