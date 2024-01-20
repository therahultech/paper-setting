<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;
    protected $table='year';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'name',
        'status',
        'created_by',
        'updated_by'
    ];
}
