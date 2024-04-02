<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreschoolWithNutritionalStatusRequest;
use App\Models\PreschoolWithNutrionalStatusModel;
use App\Traits\HttpResponses;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PreschoolWithNutrionalStatus extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $preschoolder = PreschoolWithNutrionalStatusModel::with('FPM')->latest()
        ->get();
        $data=[];
        foreach($preschoolder as $pres){
            $birthDate = Carbon::parse($pres->FPM->birthDay);
            $createdAt = Carbon::parse($pres->created_at);
            $age_in_year = $birthDate->diffInYears($createdAt);
            $BMI = calculateBMI($pres->weight,$pres->height);
            $sex = $pres->FPM->gender == 'male' ? 1 : 2;
            $percentile = calculateBMIPercentile($pres->weight,$pres->height, $age_in_year, $sex);
            $status = interpretNutritionalStatus($percentile);
            $data[]=[
                'brgy_id'=>$pres->FPM->brgys->id,
                'age'=>$age_in_year,
                'status'=>$status,
                'percentile'=>$percentile.'%',
                'preDetails'=>$pres,
                'BMI'=>$BMI,
                'first_name'=>$pres->FPM->first_name,
                'middle_name'=>$pres->FPM->middle_name,
                'last_name'=>$pres->FPM->last_name,
                'suffix'=>$pres->FPM->suffix,
                'resident_id'=>$pres->FPM->resident_id,
                'created_at'=>$pres->created_at
            ];
        }

        return $this->success($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PreschoolWithNutritionalStatusRequest $preschoolDetails)
    {
        $preschoolDetails->validated($preschoolDetails->all());

        PreschoolWithNutrionalStatusModel::create([
            'member_id' => $preschoolDetails->member_id,
            'date_opt' => $preschoolDetails->date_opt,
            'weight' => $preschoolDetails->weight,
            'height' => $preschoolDetails->height
        ]);


        return $this->success('','Successfully Added',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        error_log($id);
        $record = PreschoolWithNutrionalStatusModel::find($id);
        if(!$record) return $this->error(null,'Infant record not found',404);
        $record->delete();
        return $this->success(null,'Successfully deleted',204);
    }
}
