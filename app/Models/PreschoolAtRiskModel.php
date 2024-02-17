<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreschoolAtRiskModel extends Model
{
    use HasFactory;

    protected $table = 'preschoolAtRisk';
    protected $primaryKey = 'id';

    protected $fillable=[
        'height',
        'weight',
        'member_id',
        'period_of_measurement',
    ];


    protected $hidden = [

    ];

    public function FPM(){
        return $this->belongsTo(FamilyProfileMemberModel::class,'member_id');
    }
}
