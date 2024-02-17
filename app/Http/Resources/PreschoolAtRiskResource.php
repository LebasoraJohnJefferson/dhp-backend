<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PreschoolAtRiskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $birthDate = Carbon::parse($this->FPM->birthDay);
        $createdAt = Carbon::parse($this->created_at);
        $ageInMonths = $birthDate->diffInMonths($createdAt);
        return [
            'id'=>$this->id,
            'created_at'=>$this->created_at,
            'name'=>$this->FPM->name,
            'FP_id'=>$this->FPM->fam_profile->id,
            'ageInMonths'=>$ageInMonths,
            'weight'=>$this->weight,
            'height'=>$this->height,
            'period_of_measurement'=>$this->height,
        ];
    }
}
