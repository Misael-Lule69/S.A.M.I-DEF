<?php

// app/Models/Schedule.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['user_id', 'day', 'active', 'blocks'];
    
    protected $casts = [
        'active' => 'boolean',
        'blocks' => 'array'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}