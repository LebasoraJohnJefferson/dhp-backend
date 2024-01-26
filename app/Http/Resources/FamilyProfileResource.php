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
        return [
        'id'=>$this->id,
        'attributes'=>[
            'contact_number'=>$this->contact_number,
            'household_no'=>$this->household_no,
            'no_household_member'=>$this->no_household_member,
            'housthould_head'=>$this->housthould_head,
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
