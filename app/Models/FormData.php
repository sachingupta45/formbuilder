<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormData extends Model
{
 
    protected $fillable=[
        'user_id','name','fields'
    ];



    protected $casts = [
        'fields' => 'json',
    ];

}