<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    use HasFactory;

    protected $fillable = ['event','start_date','end_date'];

    // En tu modelo Event.php
protected $table = 'events'; // Asegúrate que coincida
}
