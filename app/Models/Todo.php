<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'completed',
        'completed_at',
    ];

    protected $casts = [
        'id' => 'integer',
    ];


}
