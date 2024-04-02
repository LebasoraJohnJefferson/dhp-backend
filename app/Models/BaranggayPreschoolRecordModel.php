<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaranggayPreschoolRecordModel extends Model
{
    use HasFactory;
    protected $table = 'brgyPreschool';
    protected $primaryKey = 'id';

    
    protected $fillable=[
        'member_id',
        'address',
        'indigenous_preschool_child',
        'weight',
        'height',
    ];


    protected $hidden = [

    ];

    public function fam_profile_member(){
        return $this->belongsTo(ResidentModel::class,'member_id');
    }

    
}
