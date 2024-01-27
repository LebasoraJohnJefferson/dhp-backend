<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FamilyProfileAdressModel;
use App\Models\FamilyProfileModel;
use App\Models\ProvinceModel;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class AnalyticsFamiltyProfileController extends Controller
{
    use HttpResponses;
    public function FPAnalyic(){
        $count_pregnant = FamilyProfileModel::where('mother_pregnant',true)->count();
        $count_prac_fam_plan = FamilyProfileModel::where('familty_planning',true)->count();
        $provinces = ProvinceModel::pluck('province')->toArray(); 
        $population = [];
        foreach($provinces as $province){
            $householdMemberCount = FamilyProfileModel::with('fam_pro_address.brgys.city.province')
            ->whereHas('fam_pro_address.brgys.city.province', function ($query) use ($province) {
                $query->where('province', $province);
            })
            ->get()
            ->sum('no_household_member');
            $population[]=$householdMemberCount;
        }
        return $this->success([
            'count_pregnant'=>$count_pregnant,
            'count_prac_fam_plan'=>$count_prac_fam_plan,
            'provinces'=>$provinces,
            'population'=>$population
        ],'Request granted',200);


    }
}
