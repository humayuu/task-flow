<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'title',
        'status',
        'priority',
        'due_date',
        'user_id',
    ];
}
