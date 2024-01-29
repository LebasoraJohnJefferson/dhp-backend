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
        'city_id',
        'user_id',
        'purok',
        'baranggay'
    ];


    protected $hidden = [

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function city()
    {
        return $this->belongsTo(CityModel::class, 'city_id');
    }

    public function family_address()
    {
        return $this->belongsTo(FamilyProfileAdressModel::class, 'FP_id');
    }
}
