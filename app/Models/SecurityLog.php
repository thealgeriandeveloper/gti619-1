<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SecurityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event',
        'details',
        'ip',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}