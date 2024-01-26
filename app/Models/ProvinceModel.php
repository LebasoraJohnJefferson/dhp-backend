<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvinceModel extends Model
{
    use HasFactory;

    protected $table = 'province';

    protected $fillable=[
        'id',
        'user_id',
        'province',
    ];


    protected $hidden = [

    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function cities()
    {
        return $this->hasMany(CityModel::class, 'province_id');
    }


}
