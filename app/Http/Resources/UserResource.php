<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $image=null;
        if($this->moreInfo && $this->moreInfo->image){
            $image=$this->moreInfo->image;
        }

        return [
            'id'=>$this->id,
            'first_name'=>$this->first_name,
            'middle_name'=>$this->middle_name,
            'last_name'=>$this->last_name,
            'email'=>$this->email,
            'suffix'=>$this->suffix,
            'is_active'=>$this->is_active,
            'updated_at'=>$this->updated_at,
            'created_at'=>$this->created_at,
            'more_info'=>$this->moreInfo,
            'image'=>$image ? asset('storage/' . $image) : null
        ];
    }
}
