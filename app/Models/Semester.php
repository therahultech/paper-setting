<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    protected $table='semester';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'status',
        'created_by',
        'updated_by'
    ];
}
