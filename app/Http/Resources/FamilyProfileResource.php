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
        $count = 0;
        if($this->father) $count+=1;
        if($this->mother) $count+=1;
        
        return [
        'id'=>$this->id,
        'attributes'=>[
            'baranggay'=>$this->brgy_id ?  $this->brgys->province.', '.$this->brgys->city.', '.$this->brgys->baranggay.', '. $this->brgys->purok : 'N/A',
            'no_household_member'=>$this->FP_members->count() + $count,
            'brgy_id'=>$this->brgy_id,
            'household_no'=>$aiKey,
            'contact_number'=>$this->contact_number,
            'father_first_name'=>$this->father_first_name,
            'father_middle_name'=>$this->father_middle_name,
            'father_last_name'=>$this->father_last_name,
            'father_suffix'=>$this->father_suffix,

            'mother_first_name'=>$this->mother_first_name,
            'mother_middle_name'=>$this->mother_middle_name,
            'mother_last_name'=>$this->mother_last_name,
            'mother_suffix'=>$this->mother_suffix,

            'food_prod_act'=>$this->food_prod_act,
            'toilet_type'=>$this->toilet_type,
            'water_source'=>$this->water_source,
            'using_iodized_salt'=>$this->using_iodized_salt,
            'using_IFR'=>$this->using_IFR,
            'familty_planning'=>$this->familty_planning,
            'mother_pregnant'=>$this->mother_pregnant,
            'mother_occupation' => $this->mother_occupation,
            'father_occupation' => $this->father_occupation,
            'mother_educ_attain' => $this->mother_educ_attain,
            'father_educ_attain' => $this->father_educ_attain,
            'mother_birthday' => $this->mother_birthday,
            'father_birthday' => $this->father_birthday
            ]
        ];
    }
}
