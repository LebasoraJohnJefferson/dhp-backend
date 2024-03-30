<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidentModel extends Model
{
    use HasFactory;
    protected $table = 'resident';
    protected $primaryKey = 'id';

    protected $fillable=[
        'brgy_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'birthday',
        'civil_status',
        'sex',
        'occupation',
    ];

    



    protected $hidden = [

    ];


    public function resident_member(){
        return $this->hasMany(FamilyProfileMemberModel::class, 'resident_id');
    }
    
    public function brgys(){
        return $this->belongsTo(BaranggayModel::class,'brgy_id');
    }

    public function father_familyProfile(){
        return $this->hasOne(FamilyProfileModel::class,'father_id');
    }

    public function mother_familyProfile(){
        return $this->hasOne(FamilyProfileModel::class,'mother_id');
    }

    public function familyProfile(){
        return $this->hasOne(FamilyProfileModel::class,'resident_id');
    }


}
