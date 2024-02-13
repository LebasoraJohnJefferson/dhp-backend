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
            'baranggay'=>$this->brgy_id ?  $this->brgys->baranggay.', '. $this->brgys->purok : 'N/A',
            'no_household_member'=>$this->FP_members->count() + $count,
            'household_no'=>$aiKey,
            'contact_number'=>$this->contact_number,
            'father'=>$this->father,
            'mother'=>$this->mother,
            'occupation'=>$this->occupation,
            'educ_attain'=>$this->educ_attain,
            'food_prod_act'=>$this->food_prod_act,
            'toilet_type'=>$this->toilet_type,
            'water_source'=>$this->water_source,
            'using_iodized_salt'=>$this->using_iodized_salt,
            'using_IFR'=>$this->using_IFR,
            'familty_planning'=>$this->familty_planning,
            'mother_pregnant'=>$this->mother_pregnant,
            ]
        ];
    }
}
