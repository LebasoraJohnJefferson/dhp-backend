<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CityModel extends Model
{
    use HasFactory;
    
    protected $table = 'city';

    protected $fillable=[
        'province_id',
        'user_id',
        'city',
    ];


    protected $hidden = [

    ];

    public function province(){
        return $this->belongsTo(ProvinceModel::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function baranggay()
    {
        return $this->hasMany(BaranggayModel::class, 'city_id');
    }
}
