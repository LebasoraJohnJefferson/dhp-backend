<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyProfileModel extends Model
{
    use HasFactory;

    protected $table = 'family_profile';
    protected $primaryKey = 'id';

    protected $fillable=[
        'brgy_id',
        'contact_number',
        'mother_first_name',
        'mother_middle_name',
        'mother_last_name',
        'mother_suffix',

        'father_first_name',
        'father_middle_name',
        'father_last_name',
        'father_suffix',
        
        'household_no',
        'no_household_member',
        'housthould_head',
        'food_prod_act',
        'toilet_type',
        'water_source',
        'using_iodized_salt',
        'using_IFR',
        'familty_planning',
        'mother_pregnant',
        'mother_occupation',
        'father_occupation' ,
        'mother_educ_attain' ,
        'father_educ_attain' ,
        'mother_birthday' ,
        'father_birthday' ,
    ];


    protected $hidden = [

    ];

    public function brgys(){
        return $this->belongsTo(BaranggayModel::class,'brgy_id');
    }

    public function FP_members(){
        return $this->hasMany(FamilyProfileMemberModel::class, 'FP_id');
    }




}

