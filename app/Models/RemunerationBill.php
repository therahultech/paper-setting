<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Paper_Upload;
use App\Models\Paper_Allocation;
use App\Models\Course;
use App\Models\Session;
use App\Models\Event;
use App\Models\Semester;
use App\Models\Year;
use App\Models\Paper;
use App\Models\Subject;
use App\Models\User;
use App\Models\Teacher;


class RemunerationBill extends Model
{
    use HasFactory;


    // Table associated with the model
    protected $table = 'remuneration_bills';

    // Primary key of the table
    protected $primaryKey = 'id';

    // Columns that are mass assignable
    protected $fillable = [
        'paper_upload_id',
        'paper_allocation_id',
        'course_id',
        'session_id',
        'event_id',
        'semester_id',
        'year_id',
        'paper_id',
        'subject_id',
        'exam_paper_id',
        'paper_set_count',
        'user_id',
        'teacher_id',
        'total_rem_amt',
        'rem_deduct',
        'net_pay_amount',
        'acc_holder_name',
        'bank_acc_no',
        'bank_name',
        'bank_branch_name',
        'bank_ifsc',
        'bank_code',
        'submitted_to_secy',
        'submitted_to_secy_datetime',
        'secy_remarks',
        'submitted_to_acc',
        'submitted_to_acc_datetime',
        'acc_remarks',
        'submitted_to_audit',
        'submitted_to_audit_datetime',
        'audit_remarks',
        'bill_paid',
        'bill_paid_date',
        'created_at',
        'update_at',
        'created_by',
        'updated_by',
    ];

    public function paper_upload(){
        return $this->belongsTo(Paper_Upload::class,'paper_upload_id','id');
    }

    public function paper_allocation(){
        return $this->belongsTo(Paper_Allocation::class,'paper_allocation_id','id');
    }

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

    public function paper(){
        return $this->belongsTo(Paper::class,'paper_id','id');
    }

    public function subject(){
        return $this->belongsTo(Subject::class,'subject_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class,'teacher_id','id');
    }

    
}

