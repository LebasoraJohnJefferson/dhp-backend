<?php

namespace Database\Factories;

use App\Models\BaranggayModel;
use App\Models\FamilyProfileModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FamilyProfileModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = FamilyProfileModel::class;

    public function definition(): array
    {
        $randomDigits = $this->faker->randomNumber(9);
        $extensions = ['','Jr','Sr','II','III','IV','V','VI','VII','VIII','IX','X'];
        $motherBirthday = $this->faker->dateTimeBetween('-40 years', '-24 years')->format('Y-m-d');
        $fatherBirthday = $this->faker->dateTimeBetween('-40 years', '-24 years')->format('Y-m-d');
        $foodProdActs=['VG','P/L','FP'];
        $toiletTypes = ['WS','OP','O','N'];
        $typeOfWater=['P','W','S'];
        $occupations = ['employed','unemployed','self-employed'];
        $educAttans = ['Advance Learning System','College','College Student','College undergrad','Elem Student','Elem Undegrad','Elem Education','High Scool Education','HS Student','HS undegrad','No Formal Education','Not Applicable','Postgraduate Program','Pre-School','Senior HS','Vacational',];
        return [
            'brgy_id'=>BaranggayModel::all()->random()->id,
            'contact_number'=>'09' . $randomDigits,
            'mother_first_name' => $this->faker->name('female'),
            'mother_middle_name' => $this->faker->firstName,
            'mother_last_name' => $this->faker->lastName,
            'mother_suffix' => null,

            'father_first_name' => $this->faker->name('male'),
            'father_middle_name' => $this->faker->firstName,
            'father_last_name' => $this->faker->lastName,
            'father_suffix' =>$this->faker->randomElement($extensions),
            'mother_birthday'=>$motherBirthday,
            'father_birthday'=>$fatherBirthday,
            'food_prod_act'=>$this->faker->randomElement($foodProdActs),
            'toilet_type'=>$this->faker->randomElement($toiletTypes),
            'water_source'=>$this->faker->randomElement($typeOfWater),
            'using_iodized_salt'=> $this->faker->boolean,
            'using_IFR'=>$this->faker->boolean,
            'familty_planning'=>$this->faker->boolean,
            'mother_pregnant'=>$this->faker->boolean,
            'mother_occupation' => $this->faker->randomElement($occupations),
            'father_occupation' =>$this->faker->randomElement($occupations),
            'mother_educ_attain' => $this->faker->randomElement($educAttans),
            'father_educ_attain' => $this->faker->randomElement($educAttans),
        ];
    }
}
