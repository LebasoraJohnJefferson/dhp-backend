<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreschoolWithNutrionalStatusModel extends Model
{
    
    use HasFactory;

    protected $table = 'preschoolerWithNutritionalStatus';
    protected $primaryKey = 'id';

    protected $fillable=[
        'height',
        'weight',
        'member_id',
        'date_opt',
    ];


    protected $hidden = [

    ];

    public function FPM(){
        return $this->belongsTo(FamilyProfileMemberModel::class,'member_id');
    }
}
