<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
   /*
     Tables Relationships
    */
    public function roleHasPermission(){
        return $this->hasone(roleHasPermission::class);
    }
    public function users(){
        return $this->belongsTo(User::class);
    }
}
