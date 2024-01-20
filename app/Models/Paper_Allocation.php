<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paper;
use App\Models\Teacher;
use App\Models\Paper_Upload;

class Paper_Allocation extends Model
{
    use HasFactory;
    protected $table='paper_allocation';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'paper_id',
        'teacher_id',
        'status',
        'created_by',
        'updated_by'
    ];

    public function paper(){
        return $this->belongsTo(Paper::class,'paper_id','id');
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class,'teacher_id','id');
    }

    public function paper_upload(){
        return $this->belongsTo(Paper_Upload::class,'id','paper_allocation_id')->withDefault();
    }

}
