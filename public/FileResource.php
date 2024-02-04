<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=>$this->id,
            "User"=>[
                'name'=> $this->user->last_name.', '. $this->user->first_name . ' ' .$this->user->middle_name[0],
            ],
            "created_at"=>$this->created_at,
            "file_name"=>$this->file_name,
            "name"=>$this->name
        ];
    }
}
