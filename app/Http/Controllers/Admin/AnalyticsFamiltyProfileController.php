<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BaranggayModel;
use App\Models\FamilyProfileMemberModel;
use App\Models\FamilyProfileModel;
use App\Models\ProvinceModel;
use App\Traits\HttpResponses;
use Carbon\Carbon;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class AnalyticsFamiltyProfileController extends Controller
{
    use HttpResponses;
    public function FPAnalyic(){
        $count_pregnant = FamilyProfileModel::where('mother_pregnant',true)->count();
        $count_prac_fam_plan = FamilyProfileModel::where('familty_planning',true)->count();
        $brgys = BaranggayModel::all(); 
        $baranggays=[];
        $population = [];
        foreach($brgys as $baranggay){
            $householdMemberCount = FamilyProfileMemberModel::with('fam_profile.FP_members')
            ->whereHas('fam_profile.FP_members', function ($query) use ($baranggay) {
                $query->where('brgy_id', $baranggay->id);
            })
            ->get()
            ->count();
            $baranggays[] = $baranggay->baranggay;
            $population[]=$householdMemberCount;
        }

        $using_iodized_salt = FamilyProfileModel::where('using_iodized_salt',true)->count();
        $not_using_iodized_salt = FamilyProfileModel::where('using_iodized_salt',false)->count();
        $using_IFR = FamilyProfileModel::where('using_IFR',true)->count();
        $not_using_IFR = FamilyProfileModel::where('using_IFR',false)->count();

        $no_children = FamilyProfileMemberModel::all();
        $category_age = [0,0,0,0];
        $data_nursing_type = [
            'EBF'=>0,
            'Mixed feeding'=>0,
            'Bottle-fed'=>0,
            'Others'=>0];

            $toiletTypes= [
                'WS'=>0,
                'OP'=>0,
                'O'=>0,
                'N'=>0];
            $typeOfWater=[
                'P'=>0,
                'W'=>0,
                'S'=>0];
            $foodProdActs=[
                'VG'=>0,
                'P/L'=>0,
                'FP'=>0];

        foreach($no_children as $child){
            $birthday = Carbon::parse($child->birthDay);
            $age = $birthday->diffInMonths(Carbon::now());
            $nursing_type = $child->nursing_type;
            
            if ($age < 6) {
                $category_age[0] += 1;
            } elseif ($age >= 6 && $age <= 23) {
                $category_age[1] += 1;
            } elseif ($age >= 24 && $age <= 59) {
                $category_age[2] += 1;
            } else {
                $category_age[3] += 1;
            }
            if($nursing_type){
                $data_nursing_type[$nursing_type]+=1;            
            }

        }

        $familyProfile = FamilyProfileModel::all();

        foreach($familyProfile as $fam){
            $toi = $fam->toilet_type;
            $water = $fam->water_source;
            $food = $fam->food_prod_act;
            
            if($water){
                $typeOfWater[$water]+=1;
            }

            if($toi){
                $toiletTypes[$toi]+=1;
            }

            if($food){
                $foodProdActs[$food]+=1;
            }

        }




        

        return $this->success([
            'count_pregnant'=>$count_pregnant,
            'count_prac_fam_plan'=>$count_prac_fam_plan,
            'baranggays'=>$baranggays,
            'population'=>$population,
            'iodized_salt_data'=>[$using_iodized_salt,$not_using_iodized_salt],
            'using_IFR_data'=>[$using_IFR,$not_using_IFR],
            'no_children'=>$category_age,
            'data_nursing_type'=>array_values($data_nursing_type),
            'toilet_type'=>array_values($toiletTypes),
            'water_soruce'=>array_values($typeOfWater),
            'food_prod_act'=>array_values($foodProdActs),
        ],'Request granted',200);


    }
}
