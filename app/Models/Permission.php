<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    /*
     Tables Relationships
    */
    public function roleHasPermissin(){
        return $this->belongsTo(RoleHasPermission::class);
    }
}
