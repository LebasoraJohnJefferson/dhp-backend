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
            'first_name'=>$this->FPM->first_name,
            'last_name'=>$this->FPM->last_name,
            'middle_name'=>$this->FPM->middle_name,
            'suffix'=>$this->FPM->suffix,
            'resident_id'=>$this->FPM->resident_id,
            'ageInMonths'=>$ageInMonths,
            'weight'=>$this->weight,
            'height'=>$this->height,
            'period_of_measurement'=>$this->period_of_measurement,
        ];
    }
}
