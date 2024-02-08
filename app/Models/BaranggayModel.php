<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaranggayModel extends Model
{
    use HasFactory;

    protected $table = 'baranggay';
    protected $primaryKey = 'id';
    protected $fillable=[
        'city',
        'province',
        'purok',
        'baranggay'
    ];


    protected $hidden = [

    ];

    public function fam_profile(){
        return $this->hasOne(FamilyProfileModel::class,'brgy_id');
    }


}
