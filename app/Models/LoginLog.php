<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'client_ip_address',
        'user_agent',
        'device',
        'browser',
        'os',
        'location',
        'login_time',
        'status',
    ];
}
