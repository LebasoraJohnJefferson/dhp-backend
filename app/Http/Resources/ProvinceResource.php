<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProvinceResource extends JsonResource
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
            "attributes"=>[
                'province'=>$this->province,
                'created_at'=>$this->created_at,
                'updated_at'=>$this->updated_at
            ],
            'personnel_details'=>[
                'first_name' => $this->user->first_name,
                'middle_name' => $this->user->middle_name,
                'last_name' => $this->user->last_name,
                'email' => $this->user->email,
            ]
        ];
    }
}
