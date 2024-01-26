<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyProfileModel extends Model
{
    use HasFactory;

    protected $table = 'family_profile';

    protected $fillable=[
        'contact_number',
        'household_no',
        'no_household_member',
        'housthould_head',
        'occupation',
        'educ_attain',
        'food_prod_act',
        'toilet_type',
        'water_source',
        'using_iodized_salt',
        'using_IFR',
        'familty_planning',
        'mother_pregnant',
    ];


    protected $hidden = [

    ];



}

