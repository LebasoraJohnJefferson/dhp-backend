<?php

namespace App\Http\Controllers;

use App\Http\Requests\InfantRequest;
use App\Models\FamilyProfileMemberModel;
use App\Models\InfantModel;
use App\Traits\HttpResponses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Throwable;

class InfantController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $infants = FamilyProfileMemberModel::where(function($query) {
        $query->whereRaw('DATEDIFF(CURDATE(), birthDay) >= 0'); 
        $query->whereRaw('DATEDIFF(CURDATE(), birthDay) <= 23 * 30'); 
        })->get();
        return $this->success(
            $infants
        );
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
    public function store(InfantRequest $infant)
    {
        $infant->validated($infant->all());
        InfantModel::create([
            'member_id'=>$infant->member_id,
            'weight'=>$infant->weight
        ]);

        return $this->success('','Successfully Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $startDate = Carbon::now()->subMonths(23);

        $infantInfo = InfantModel::whereHas('FPM', function ($query) use ($startDate) {
            $query->where('birthDay', '>=', $startDate);
        })
        ->latest()
        ->get();

        $infants = [];
        foreach($infantInfo as $info){
            $birthDate = Carbon::parse($info->FPM->birthDay);
            $createdAt = Carbon::parse($info->created_at);
            $now = Carbon::now();
            $ageInMonths = $birthDate->diffInMonths($now);
            $weight = $info->weight;
            $status = getWeightStatus($ageInMonths,$weight);
            $data = [
                'info'=>$info,
                'status'=>$status,
                'ageInMoth'=>$birthDate->diffInMonths($createdAt)
            ];
            $infants[] = $data;
        }

        return $this->success($infants);

        
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
        $infant = InfantModel::find($id);
        if(!$infant) return $this->error(null,'Infant record not found',404);
        $infant->delete();
        return $this->success(null,'Successfully deleted',204);
    }



    
}



function getWeightStatus($age,$weight)
{
    $weightStatus = [
        "0"=>['severelyUnderweight'=>2.1,'underWeight'=>[2.2,2.4],'normalWeight'=>[2.5,4.4],'overWeight'=>4.5],
        "1"=>['severelyUnderweight'=>2.9,'underWeight'=>[3.0,3.3],'normalWeight'=>[3.4,5.8],'overWeight'=>5.9],
        "2"=>['severelyUnderweight'=>3.8,'underWeight'=>[3.9,4.2],'normalWeight'=>[4.3,7.1],'overWeight'=>7.2],
        "3"=>['severelyUnderweight'=>4.4,'underWeight'=>[4.5,4.9],'normalWeight'=>[5.0,8.0],'overWeight'=>8.1],
        "4"=>['severelyUnderweight'=>4.9,'underWeight'=>[5.0,5.5],'normalWeight'=>[5.6,8.7],'overWeight'=>8.8],
        "5"=>['severelyUnderweight'=>5.3,'underWeight'=>[5.4,5.9],'normalWeight'=>[6.0,9.3],'overWeight'=>9.4],
        "6"=>['severelyUnderweight'=>5.7,'underWeight'=>[5.8,6.3],'normalWeight'=>[6.4,9.8],'overWeight'=>9.9],
        "7"=>['severelyUnderweight'=>5.9,'underWeight'=>[6.0,6.6],'normalWeight'=>[6.7,10.3],'overWeight'=>10.4],
        "8"=>['severelyUnderweight'=>6.2,'underWeight'=>[6.3,6.8],'normalWeight'=>[6.9,10.7],'overWeight'=>10.8],
        "9"=>['severelyUnderweight'=>6.4,'underWeight'=>[6.5,7.0],'normalWeight'=>[7.1,11.0],'overWeight'=>11.1],
        "10"=>['severelyUnderweight'=>6.6,'underWeight'=>[6.7,7.3],'normalWeight'=>[7.4,11.4],'overWeight'=>11.5],
        "11"=>['severelyUnderweight'=>6.8,'underWeight'=>[6.9,7.5],'normalWeight'=>[7.6,11.7],'overWeight'=>11.8],
        "12"=>['severelyUnderweight'=>6.9,'underWeight'=>[7.0,7.6],'normalWeight'=>[7.7,12.0],'overWeight'=>12.1],
        "13"=>['severelyUnderweight'=>7.1,'underWeight'=>[7.2,7.8],'normalWeight'=>[7.9,12.3],'overWeight'=>12.4],
        "14"=>['severelyUnderweight'=>7.2,'underWeight'=>[7.3,8.0],'normalWeight'=>[8.1,12.6],'overWeight'=>12.7],
        "15"=>['severelyUnderweight'=>7.4,'underWeight'=>[7.5,8.2],'normalWeight'=>[8.3,12.8],'overWeight'=>12.9],
        "16"=>['severelyUnderweight'=>7.5,'underWeight'=>[7.6,8.3],'normalWeight'=>[8.4,13.1],'overWeight'=>13.2],
        "17"=>['severelyUnderweight'=>7.7,'underWeight'=>[7.8,8.5],'normalWeight'=>[8.6,13.4],'overWeight'=>13.5],
        "18"=>['severelyUnderweight'=>7.8,'underWeight'=>[7.9,8.7],'normalWeight'=>[8.8,13.7],'overWeight'=>13.8],
        "19"=>['severelyUnderweight'=>8.0,'underWeight'=>[8.1,8.8],'normalWeight'=>[8.9,13.9],'overWeight'=>14.0],
        "20"=>['severelyUnderweight'=>8.1,'underWeight'=>[8.2,9.0],'normalWeight'=>[9.1,14.2],'overWeight'=>14.3],
        "21"=>['severelyUnderweight'=>8.2,'underWeight'=>[8.3,9.1],'normalWeight'=>[9.2,14.5],'overWeight'=>14.6],
        "22"=>['severelyUnderweight'=>8.4,'underWeight'=>[8.5,9.3],'normalWeight'=>[9.4,14.7],'overWeight'=>14.8],
        "23"=>['severelyUnderweight'=>8.5,'underWeight'=>[8.6,9.4],'normalWeight'=>[9.5,15.0],'overWeight'=>15.1],
    ];
    try {
        if($weightStatus[$age]['severelyUnderweight']>=$weight) return 'Severely underweight';
        if($weightStatus[$age]['underWeight'][0]<=$weight && $weightStatus[$age]['underWeight'][1]>=$weight) return 'underweight';
        if($weightStatus[$age]['normalWeight'][0]<=$weight && $weightStatus[$age]['normalWeight'][1]>=$weight) return 'Normal Weigth';
        if($weightStatus[$age]['overWeight']<=$weight) return 'Over weight';
        else return null;
    } catch (Throwable $e) {
        return null;
    }
}
