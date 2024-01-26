<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyProfileAdressModel extends Model
{
    use HasFactory;

    protected $table = 'family_profile_address';

    protected $fillable=[
        'bray_id',
        'FP_id'
    ];

    protected $hidden = [

    ];


    public function brgys()
    {
        return $this->belongsTo(BaranggayModel::class, 'bray_id');
    }

    public function profile_families()
    {
        return $this->belongsTo(FamilyProfileModel::class, 'FP_id');
    }



}
