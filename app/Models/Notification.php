<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_type',
        'user_id',
        'title',
        'description',
        'is_read',
    ];
    public function Notifier()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
