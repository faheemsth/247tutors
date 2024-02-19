<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    /*
     Tables Relationships
    */
    protected $fillable=[
        'user_id',
        'balance',
        'net_income',
        'spent',
        'withdrawn',
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }
}
