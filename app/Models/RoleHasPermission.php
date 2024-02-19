<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleHasPermission extends Model
{
    use HasFactory;
    /*
     Tables Relationships
    */
    public function permission(){
        return $this->hasone(Permission::class);
    }
    public function roles(){
        return $this->belongsTo(Role::class);
    }
}
