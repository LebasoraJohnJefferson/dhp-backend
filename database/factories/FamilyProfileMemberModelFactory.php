<?php

namespace Database\Factories;

use App\Models\FamilyProfileModel;
use App\Models\FamilyProfileMemberModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FamilyProfileMemberModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = FamilyProfileMemberModel::class;


    public function definition(): array
    {
        $relationships=['Father','Mother','Grandmother','Grandfather','Brother','Sister','Son','Daughter','Aunt','Uncle','Father-in-law','Mother-in-law','Brother-in-law','Sister-in-law','Son-in-law','Daugter-in-law','Nephew','Niece','Great-Grandfather','Great-Grandmother','Great-Grandson','Great-Granddaughter','Friend'];
        $birthDay = $this->faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d');
        $nursingTypes=['EBF','Mixed feeding','Bottle-fed','Others'];
        $relationships= ['Father','Mother','Grandmother','Grandfather','Brother','Sister','Son','Daughter','Aunt','Uncle','Father-in-law','Mother-in-law','Brother-in-law','Sister-in-law','Son-in-law','Daugter-in-law','Nephew','Niece','Great-Grandfather','Great-Grandmother','Great-Grandson','Great-Granddaughter','Friend'];
        $occupations=['employed','unemployed','self-employed'];
        return [
            'FP_id' => FamilyProfileModel::all()->random()->id,
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->lastName,
            'middle_name' => $this->faker->firstName,
            'suffix' => null,
            'birthDay' => $birthDay,
            'relationship' => $this->faker->randomElement($relationships),
            'occupation' => $this->faker->randomElement($occupations),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'nursing_type' =>$this->faker->randomElement($nursingTypes),
        ];
    }
}
