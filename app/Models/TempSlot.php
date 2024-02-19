<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempSlot extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'tutor_id', 'date','slot'];
    
}
