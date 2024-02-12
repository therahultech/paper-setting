<?php

namespace App\Http\Controllers;

use App\Models\Paper_Allocation;
use App\Http\Requests\StorePaper_AllocationRequest;
use App\Http\Requests\UpdatePaper_AllocationRequest;
use App\Models\Paper;
use App\Models\Teacher;
use App\Http\Controller\PhpMailController;

class PaperAllocationController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:paper_Allocation-list|paper_Allocation-create|paper_Allocation-edit|paper_Allocation-delete', ['only' => ['index','store']]);
         $this->middleware('permission:paper_Allocation-create', ['only' => ['create','store']]);
         $this->middleware('permission:paper_Allocation-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:paper_Allocation-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $paper_Allocations = Paper_Allocation::with('teacher','teacher.department','paper','paper.course','paper.session','paper.event','paper.semester','paper.year','paper.subject','paper_upload')->get();
        // echo '<pre>';
        // echo $paper_Allocationxs;
        return view('paper_Allocation.index',compact('paper_Allocations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $papers = Paper::with('subject')->where('status','=','1')->get();
        $teachers = Teacher::with('department')->where('status','=','1')->get();
        return view('paper_Allocation.create',compact('papers','teachers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePaper_AllocationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaper_AllocationRequest $request)
    {
        //

        $phpMailController = app()->make('App\Http\Controllers\PhpMailController');

        $validated = $request->validate([
            'paper_id'=>'required',
            'teacher_id'=>'required',
     
        ]);

        // $paper_Allocation = new Paper_Allocation;
        // $paper_Allocation->paper_id = $request->input('paper_id');
        // $paper_Allocation->teacher_id = $request->input('teacher_id');
        // $paper_Allocation->status = $request->input('status');
        // $paper_Allocation->created_by = $request->user()->id;
        // $paper_Allocation->save();

        // return $paper_Allocation;
        $teacher = Teacher::find($request->input('teacher_id'));
        $paper = Paper::with('course','session','event','subject')->where('paper.id','=',$request->input('paper_id'))->first();

        // var_dump($teacher);
        // dd($paper);

        $email_to = $teacher->email;
        $email_subject = 'Paper Setting : '.$paper->subject->code.'-'.$paper->subject->name.' ('.$paper->exam_paper_id.') has been alloted.';
        $data_for_email['teacher']=$teacher->name_prefix.' '.$teacher->name;
        $data_for_email['course']=$paper->course->code.'-'.$paper->course->name;
        $data_for_email['session']=$paper->session->name;
        $data_for_email['event']=$paper->event->name;
        $data_for_email['semYear']=$paper->semester_id?$paper->semester_id:$paper->year_id;
        $data_for_email['paper']=$paper->subject->code.'-'.$paper->subject->name.' ('.$paper->exam_paper_id.')';

        echo '<br>email_to:'.$email_to;
        echo '<br>email_sub:'.$email_subject;
        echo '<br><pre>:';
        // dd($data_for_email);

        // $email_response = PhpMailController::send_paper_allot_email($email_to,$email_subject,$data_for_email);
        $email_response = $phpMailController->send_paper_allot_email($email_to,$email_subject,$data_for_email);

        print_r($email_response);


        return redirect('paper_Allocation')->with('status','Paper Allocated Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paper_Allocation_Allocation  $paper_Allocation
     * @return \Illuminate\Http\Response
     */
    public function show(Paper_Allocation $paper_Allocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paper_Allocation_Allocation  $paper_Allocation
     * @return \Illuminate\Http\Response
     */
    public function edit(Paper_Allocation $paper_Allocation)
    {
        //
        $papers = Paper::with('subject')->where('status','=','1')->get();
        $teachers = Teacher::with('department')->where('status','=','1')->get();

        return view('paper_Allocation.edit',compact('paper_Allocation','papers','teachers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaper_AllocationRequest  $request
     * @param  \App\Models\Paper_Allocation  $paper_Allocation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaper_AllocationRequest $request, Paper_Allocation $paper_Allocation)
    {
        //
        $validated = $request->validate([
            'paper_id'=>'required',
            'teacher_id'=>'required',
     
        ]);

        $paper_Allocation->paper_id = $request->input('paper_id');
        $paper_Allocation->teacher_id = $request->input('teacher_id');
        $paper_Allocation->status = $request->input('status');
        $paper_Allocation->updated_by = $request->user()->id;
        $paper_Allocation->update();

        return redirect('paper_Allocation')->with('status','Paper Allocation Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paper_Allocation  $paper_Allocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paper_Allocation $paper_Allocation)
    {
        //
        $paper_Allocation->delete();
        return redirect('paper_Allocation')->with('status','Paper Allocation Deleted Successfully');
    }
}
