<?php

namespace App\Http\Controllers;

use App\Models\BaranggayModel;
use App\Models\FamilyProfileModel;
use App\Models\ResidentModel;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class PupolationBracketController extends Controller
{

    use HttpResponses;

    public function PopulationBracket(){

        $expected_age_range=[
            ['under',0],
            [12,23],
            [0,6],
            [6,10],
            [0,12],
            [13,23],
            [0,59],
            [12,48],
            [60,108],
            [60,132],
            [120,168],
            [120,228],
            [180,228],
            ['above',60],
            [144,708],
            [240,708],
            ['above',240],
            ['above',720],
        ];



        $brgys = BaranggayModel::distinct()->pluck('baranggay');
        $data=[];

        foreach ($brgys as $brgy) {
            // total population in every city;
            $citizens = ResidentModel::with('resident_member')
            ->whereHas('brgys', function ($query) use ($brgy) {
                $query->where('baranggay', $brgy);
            })
            ->get();
            

            $temp[$brgy] = new CityAgeRange($brgy);
            if($citizens != null){
                foreach($citizens as $citizen){
                    $mother_month=now()->diffInMonths($citizen->birthday);
    
                    foreach ($expected_age_range as $index => $expect) {
                        if ($expect[0] == 'under') {
                            if ($mother_month <= $expect[1]) {
                                $temp[$brgy]->addGenderCount($index, 'female');
                            }
                        }
                        if ($expect[0] == 'above') {
                            if ($mother_month >= $expect[1]) {
                                $temp[$brgy]->addGenderCount($index, 'female');
                            }
                        }
                        if ($expect[0] != 'above' && $expect != 'under'){
                            if ($mother_month >= $expect[0] && $mother_month <= $expect[1]) {
                                $temp[$brgy]->addGenderCount($index, 'female');
                            }
                        }
    
    
    
                    }
    
    
                    if($citizen->resident){
                        foreach ($citizen->resident->resident_member as $member) {
                            $monthsDifference = now()->diffInMonths($member->birthDay);
                            $gender = $member->gender;
                            foreach ($expected_age_range as $index => $expect) {
                                if ($expect[0] == 'under') {
                                    if ($monthsDifference <= $expect[1]) {
                                        $temp[$brgy]->addGenderCount($index, $gender);
                                    }
                                }
                                if ($expect[0] == 'above') {
                                    if ($monthsDifference >= $expect[1]) {
                                        $temp[$brgy]->addGenderCount($index, $gender);
                                    }
                                }
                                if ($expect[0] != 'above' && $expect != 'under'){
                                    if ($monthsDifference >= $expect[0] && $monthsDifference <= $expect[1]) {
                                        $temp[$brgy]->addGenderCount($index, $gender);
                                    }
                                }
                            }
                        }
                    }
                }
            }




            $data[] = $temp[$brgy]->returnData();
        }



        return $this->success($data);
    }
}


class BrgyAgeRange{

}



class CityAgeRange{
    public $brgy;
    public $ageRange;

    function __construct($brgy)
    {
        $this->brgy = $brgy;
        $this->ageRange =[
            ['male'=>0,'female'=>0,],
            ['male'=>0,'female'=>0,],
            ['male'=>0,'female'=>0,],
            ['male'=>0,'female'=>0,],
            ['male'=>0,'female'=>0,],
            ['male'=>0,'female'=>0,],
            ['male'=>0,'female'=>0,],
            ['male'=>0,'female'=>0,],
            ['male'=>0,'female'=>0,],
            ['male'=>0,'female'=>0,],
            ['male'=>0,'female'=>0,],
            ['male'=>0,'female'=>0,],
            ['male'=>0,'female'=>0,],
            ['male'=>0,'female'=>0,],
            ['male'=>0,'female'=>0,],
            ['male'=>0,'female'=>0,],
            ['male'=>0,'female'=>0,],
            ['male'=>0,'female'=>0,],
        ];
    }

    function addGenderCount($index,$gender){
        $this->ageRange[$index][$gender]+=1;
    }




    function returnData(){
        return [
            'brgy'=>$this->brgy,
            'genderPopulation'=>$this->ageRange,
        ];
    }


}
