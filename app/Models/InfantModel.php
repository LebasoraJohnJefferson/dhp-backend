<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfantModel extends Model
{
    use HasFactory;
    protected $table = 'infantRecord';
    protected $primaryKey = 'id';

    protected $fillable=[
        'member_id',
        'weight',
    ];


    protected $hidden = [

    ];

    public function FPM(){
        return $this->belongsTo(ResidentModel::class,'member_id');
    }

  
}
