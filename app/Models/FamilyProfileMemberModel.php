<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyProfileMemberModel extends Model
{
    use HasFactory;
    protected $table = 'family_profile_members';
    protected $primaryKey = 'id';

    protected $fillable=[
        'FP_id',
        'name',
        'birthDay',
        'relationship',
        'occupation',
        'gender',
        'nursing_type'
    ];


    protected $hidden = [

    ];

    public function fam_profile(){
        return $this->belongsTo(FamilyProfileModel::class,'FP_id');
    }

    public function brgy_preschool(){
        return $this->hasOne(BaranggayPreschoolRecordModel::class,'member_id');
    }

    public function preschool_with_status(){
        return $this->hasOne(BaranggayPreschoolRecordModel::class,'member_id');
    }


}
