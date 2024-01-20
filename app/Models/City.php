<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\District;
use App\Models\State;

class City extends Model
{
    use HasFactory;
    protected $table='city';
    protected $primaryKey = 'city_id';
    protected $fillable = [
        'city_id',
        'city_name',
        'district_id',
        'state_id',
        'city_description',
        'status'
    ];

    public function district(){
        return $this->belongsTo(District::class,'district_id','district_id');
    }
    public function state(){
        return $this->belongsTo(State::class,'state_id','state_id');
    }
}
