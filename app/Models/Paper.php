<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;
use App\Models\Session;
use App\Models\Event;
use App\Models\Semester;
use App\Models\Year;
use App\Models\Subject;


class Paper extends Model
{
    use HasFactory;
    protected $table='paper';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'course_id',
        'session_id',
        'event_id',
        'semester_id',
        'year_id',
        'subject_id',
        'exam_paper_id',
        'status',
        'created_by',
        'updated_by'
    ];

    public function course(){
        return $this->belongsTo(Course::class,'course_id','id');
    }

    public function session(){
        return $this->belongsTo(Session::class,'session_id','id');
    }

    public function event(){
        return $this->belongsTo(Event::class,'event_id','id');
    }

    public function semester(){
        return $this->belongsTo(Semester::class,'semester_id','id');
    }

    public function year(){
        return $this->belongsTo(Year::class,'year_id','id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class,'subject_id','id');
    }

}
