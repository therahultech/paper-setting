<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $table='subject';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'code',
        'is_credit_based',
        'status',
        'created_by',
        'updated_by'
    ];

}
