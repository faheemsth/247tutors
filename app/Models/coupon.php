<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'price',
        'valid_from',
        'valid_to',
        'from_user',
        'to_user',
        'usage_limit',
        'used_count',
    ];
    public function user(){
        return $this->belongsTo(User::class,'to_user');
    }

}
