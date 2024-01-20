<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    protected $table='session';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'is_current',
        'status',
        'created_by',
        'updated_by'
    ];
}
