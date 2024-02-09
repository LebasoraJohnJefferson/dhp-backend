<?php

namespace App\Http\Controllers;

use App\Http\Requests\InfantRequest;
use App\Models\FamilyProfileMemberModel;
use App\Models\InfantModel;
use App\Traits\HttpResponses;
use Carbon\Carbon;
use Illuminate\Http\Request;

use function App\Providers\weightStatus;

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
        })->latest()->get();
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
            $status = weightStatus($ageInMonths,$weight);
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


