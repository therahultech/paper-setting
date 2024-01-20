<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paper_Allocation;

class Paper_Upload extends Model
{
    use HasFactory;
    protected $table='paper_upload';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'paper_allocation_id',
        'set1_uploaded',
        'set1_file',
        'set2_uploaded',
        'set2_file',
        'final_submit',
        'status',
        'created_by',
        'updated_by'
    ];

    public function paper_allocation(){
        return $this->belongsTo(Paper_Allocation::class,'paper_allocation_id','id');
    }

}
