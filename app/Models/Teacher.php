<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use App\Models\User;
use App\Models\City;

class Teacher extends Model
{
    use HasFactory;
    protected $table='teacher';
    protected $primaryKey = 'id';
    protected $fillable = [
        'department_id',
        'user_id',
        'emp_code',
        'name_prefix',
        'name',
        'email',
        'mobile1',
        'mobile2',
        'addr1',
        'addr2',
        'city_id',
        'status',
        'created_by',
        'updated_by'
    ];

    public function department(){
        return $this->belongsTo(Department::class,'department_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function city(){
        return $this->belongsTo(City::class,'city_id','city_id')->join('state as s','s.state_id','=','city.state_id')
                                                                ->join('district as d','d.district_id','=','city.district_id');
    }
}
