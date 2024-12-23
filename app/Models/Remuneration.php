<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remuneration extends Model
{
    use HasFactory;

    // Specify the table name if it differs from the pluralized version of the model name
    protected $table = 'remuneration';

    // Primary key of the table
    protected $primaryKey = 'id';

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'per_set',
        'twf_deduction',
        'status',
    ];


}
