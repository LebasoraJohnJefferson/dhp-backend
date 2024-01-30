<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fileModel extends Model
{
    use HasFactory;

    protected $table = 'file';
    protected $primaryKey = 'id';

    protected $fillable=[
        'file_name',
        'name',
        'is_deleted',
        'user_id'
    ];


    protected $hidden = [

    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
