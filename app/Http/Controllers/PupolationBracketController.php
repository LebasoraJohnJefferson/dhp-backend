<?php

namespace App\Http\Controllers;

use App\Models\BaranggayModel;
use App\Models\FamilyProfileModel;
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
            $citizens = FamilyProfileModel::with('FP_members')->whereHas('brgys', function ($query) use ($brgy) {
                $query->where('baranggay', $brgy);
            })->get();


            $temp[$brgy] = new CityAgeRange($brgy);
            foreach($citizens as $citizen){
                error_log(json_encode($citizen));
                $mother_month=now()->diffInMonths($citizen->mother_birthday);
                $father_month=now()->diffInMonths($citizen->father_birthday);


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

                    if ($expect[0] == 'under') {
                        if ($father_month <= $expect[1]) {
                            $temp[$brgy]->addGenderCount($index, 'male');
                        }
                    }
                    if ($expect[0] == 'above') {
                        if ($father_month >= $expect[1]) {
                            $temp[$brgy]->addGenderCount($index, 'male');
                        }
                    }
                    if ($expect[0] != 'above' && $expect != 'under'){
                        if ($father_month >= $expect[0] && $father_month <= $expect[1]) {
                            $temp[$brgy]->addGenderCount($index, 'male');
                        }
                    }


                }



                foreach ($citizen->FP_members as $member) {
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
