<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class EventModel extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable=[
        'image',
        'title',
        'description',
        'date',
        'venue',
    ];

    protected $table = 'event';

    protected $hidden = [

    ];

}
