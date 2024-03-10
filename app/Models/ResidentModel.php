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
        'mother_first_name',
        'mother_middle_name',
        'mother_last_name',
        'father_first_name',
        'father_middle_name',
        'father_last_name',
        'father_suffix',
        'father_birthday',
        'mother_birthday',
        'mother_citizenship',
        'father_citizenship',
        'mother_place_birth',
        'father_place_birth',
    ];



    protected $hidden = [

    ];

    
    public function brgys(){
        return $this->belongsTo(BaranggayModel::class,'brgy_id');
    }


}
