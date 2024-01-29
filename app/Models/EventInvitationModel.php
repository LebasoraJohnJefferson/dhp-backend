<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventInvitationModel extends Model
{
    use HasFactory;
    protected $table = 'event_invitation';
    protected $primaryKey = 'id';

    
    protected $fillable=[
        'event_id',
        'province_id',
    ];


    protected $hidden = [

    ];

    public function event()
    {
        return $this->belongsTo(EventModel::class, 'event_id');
    }

    public function province()
    {
        return $this->belongsTo(ProvinceModel::class, 'province_id');
    }


}
