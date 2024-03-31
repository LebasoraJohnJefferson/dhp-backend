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
        'resident_id',
        'fp_id',
        'relationship',
        'nursing_type'
    ];


    protected $hidden = [

    ];

    public function fam_profile(){
        return $this->belongsTo(FamilyProfileModel::class,'fp_id');
    }
    
    public function resident_profile(){
        return $this->belongsTo(ResidentModel::class,'resident_id');
    }

    public function brgy_preschool(){
        return $this->hasOne(BaranggayPreschoolRecordModel::class,'member_id');
    }

    public function preschool_with_status(){
        return $this->hasOne(BaranggayPreschoolRecordModel::class,'member_id');
    }


}
