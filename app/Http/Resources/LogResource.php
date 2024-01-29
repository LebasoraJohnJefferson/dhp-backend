<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'User'=>[
                'name'=>$this->user->last_name. ', '. $this->user->first_name. ' '. $this->user->last_name[0],
                'role'=>$this->user->roles
            ],
            'description'=>$this->description,
            'createdAt'=>$this->created_at
        ];
    }
}
