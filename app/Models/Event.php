<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Session;

class Event extends Model
{
    use HasFactory;
    protected $table='event';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'session_id',
        'name',
        'alias',
        'is_year_based',
        'status',
        'created_by',
        'updated_by'
    ];

    public function session(){
        return $this->belongsTo(Session::class,'session_id','id');
    }
    
}
