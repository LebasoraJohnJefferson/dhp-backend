<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonnelMoreInfo extends Model
{
    use HasFactory;

    protected $table = 'personnel_more_info';
    protected $primaryKey = 'id';

    protected $fillable=[
        'user_id',
        'address',
        'birthday',
        'gender',
        'contact_number',
        'emergency_contact_relationship',
        'emergency_contact_number',
        'image',
    ];


    protected $hidden = [

    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
