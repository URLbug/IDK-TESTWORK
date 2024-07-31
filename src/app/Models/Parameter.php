<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'id',
        'title',
        'type',
    ];

    protected $casts = [
        'title' => 'array'
    ];
}
