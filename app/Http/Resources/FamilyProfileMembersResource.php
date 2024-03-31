<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FamilyProfileMembersResource extends JsonResource
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
            'occupation'=>$this->resident_profile->occupation,
            'gender'=>$this->resident_profile->sex,
            'birthDay'=>$this->resident_profile->birthday,
            'nursing_type'=>$this->nursing_type,
            'relationship'=>$this->relationship,
            'first_name'=>$this->resident_profile->first_name,
            'middle_name'=>$this->resident_profile->middle_name,
            'last_name'=>$this->resident_profile->last_name,
            'suffix'=>$this->resident_profile->suffix,
        ];
    }
}
