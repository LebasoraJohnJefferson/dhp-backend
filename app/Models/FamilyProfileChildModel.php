<?php

namespace App\Models;

use App\Http\Requests\Personnel\FamiltyProfileRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyProfileChildModel extends Model
{
    use HasFactory;
    protected $table = 'family_profile_children';
    protected $primaryKey = 'id';

    protected $fillable=[
        'FP_id',
        'name',
        'birthDay',
        'nursing_type'
    ];


    protected $hidden = [

    ];

    public function fam_profile(){
        return $this->belongsTo(FamiltyProfileRequest::class,'FP_id');
    }


}
