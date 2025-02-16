<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    protected $fillable = ['form_id','token', 'form_data'];

    protected $casts = [
        'form_data' => 'array',
    ];
}
