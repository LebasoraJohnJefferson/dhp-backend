<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrgyPreschoolRequest;
use App\Models\BaranggayPreschoolRecordModel;
use App\Models\FamilyProfileMemberModel;
use App\Traits\HttpResponses;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PreschoolController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $children = FamilyProfileMemberModel::where(function ($query) {
            $query->whereRaw('DATEDIFF(CURDATE(), birthDay) >= 3 * 365'); 
            $query->whereRaw('DATEDIFF(CURDATE(), birthDay) <= 5 * 365'); 
        })->latest()->get();
        
        return $this->success($children);

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
    public function store(BrgyPreschoolRequest $brgyPreschool)
    {
        $brgyPreschool->validated($brgyPreschool->all());
        BaranggayPreschoolRecordModel::create([
            'member_id' => $brgyPreschool->member_id,
            'address' => $brgyPreschool->address,
            'indigenous_preschool_child' => $brgyPreschool->indigenous_preschool_child,
            'weight' => $brgyPreschool->weight,
            'height' => $brgyPreschool->height
        ]);

        return $this->success('','Successfully Added',201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $preschoolder = BaranggayPreschoolRecordModel::with('fam_profile_member')->latest()
        ->get();
        $data=[];
        foreach($preschoolder as $pres){
            $birthDate = Carbon::parse($pres->fam_profile_member->birthDay);
            $createdAt = Carbon::parse($pres->created_at);
            $age_in_year = $birthDate->diffInYears($createdAt);
            $data[]=[
                'age'=>$age_in_year,
                'preDetails'=>$pres,
                'name'=>$pres->fam_profile_member->name,
                'FP_id'=>$pres->fam_profile_member->FP_id,
            ];
        }

        return $this->success($data);
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
        $is_brgy_preschooler_exist = BaranggayPreschoolRecordModel::find($id);
        if(!$is_brgy_preschooler_exist) return $this->error(null,'Infant record not found',404);
        $is_brgy_preschooler_exist->delete();
        return $this->success(null,'Successfully deleted',204);
    }
}
