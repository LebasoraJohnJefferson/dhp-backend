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
            'occupation'=>$this->occupation,
            'gender'=>$this->gender,
            'birthDay'=>$this->birthDay,
            'nursing_type'=>$this->nursing_type,
            'relationship'=>$this->relationship,
            'first_name'=>$this->first_name,
            'middle_name'=>$this->middle_name,
            'last_name'=>$this->last_name,
            'suffix'=>$this->suffix,
        ];
    }
}
