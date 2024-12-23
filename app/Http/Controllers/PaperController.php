<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Http\Requests\StorePaperRequest;
use App\Http\Requests\UpdatePaperRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Session;
use App\Models\Event;
use App\Models\Semester;
use App\Models\Year;
use App\Models\Subject;
use App\Models\RemunerationBill;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PaperController extends Controller
{


    function __construct()
    {
         $this->middleware('permission:paper-list|paper-create|paper-edit|paper-delete', ['only' => ['index','store']]);
         $this->middleware('permission:paper-create', ['only' => ['create','store']]);
         $this->middleware('permission:paper-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:paper-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $papers = Paper::with('course','session','event','semester','year','subject')->get();
        return view('paper.index',compact('papers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $courses = Course::where('status','=','1')->get();
        $sessions = Session::where('status','=','1')->get();
        $events = Event::where('status','=','1')->get();
        $semesters = Semester::where('status','=','1')->get();
        $years = Year::where('status','=','1')->get();
        $subjects = Subject::where('status','=','1')->get();

        return view('paper.create',compact('courses','sessions','events','semesters','years','subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePaperRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaperRequest $request)
    {
        //
        $validated = $request->validate([
            'course_id'=>[
                'required',
                Rule::unique('paper')->where(function ($query) use ($request) {
                    return $query->where('session_id', $request->input('session_id'))
                                 ->where('event_id', $request->input('event_id'))
                                 ->where('semester_id', $request->input('semester_id'))
                                 ->where('year_id', $request->input('year_id'))
                                 ->where('subject_id', $request->input('subject_id'));
                }),
            ],
            'session_id'=>'required',
            'event_id'=>'required',
            'subject_id'=>'required',
            'exam_paper_id'=>'required|max:10',
            
        ],
        [
            'course_id.unique' => 'The combination of course, session, event, semester/year, and subject already exist.',
        ]
    );

        if($request->hasFile('uploaded_file')){
            $file_name_tmp = $request->input('course_id').'_'.$request->input('session_id').'_'.$request->input('event_id').'_'.$request->input('semester_id').'_'.$request->input('year_id').'_'.$request->input('subject_id').'_'.$request->input('exam_paper_id');
            $uploaded_fileName = $this->generateFileName($file_name_tmp,'_', $request->user()->id);
            $uploaded_filePath = $request->file('uploaded_file')->storeAs('public/syllabus', $uploaded_fileName);
            $uploaded_fileUrl = Storage::url($uploaded_filePath);
        }

        $paper = new Paper;
        $paper->course_id = $request->input('course_id');
        $paper->session_id = $request->input('session_id');
        $paper->event_id = $request->input('event_id');
        $paper->semester_id = $request->input('semester_id');
        $paper->year_id = $request->input('year_id');
        $paper->subject_id = $request->input('subject_id');
        $paper->exam_paper_id = $request->input('exam_paper_id');
        if($request->hasFile('uploaded_file') && $uploaded_fileUrl){
            $paper->uploaded_file = $uploaded_fileUrl;
        }
        $paper->status = $request->input('status');
        $paper->created_by = $request->user()->id;
        $paper->save();

        return redirect('paper')->with('status','Paper Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function show(Paper $paper)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function edit(Paper $paper)
    {
        //
        $courses = Course::where('status','=','1')->get();
        $sessions = Session::where('status','=','1')->get();
        $events = Event::where('status','=','1')
                        ->where('session_id','=',$paper->session_id)->get();
        $semesters = Semester::where('status','=','1')->get();
        $years = Year::where('status','=','1')->get();
        $subjects = Subject::where('status','=','1')->get();

        return view('paper.edit',compact('paper','courses','sessions','events','semesters','years','subjects'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaperRequest  $request
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaperRequest $request, Paper $paper)
    {
        //
        $validated = $request->validate([
            'course_id'=>'required',
            'session_id'=>'required',
            'event_id'=>'required',
            'subject_id'=>'required',
            'exam_paper_id'=>'required|max:10',
        ]);

        if($request->hasFile('uploaded_file')){
            $file_name_tmp = $request->input('course_id').'_'.$request->input('session_id').'_'.$request->input('event_id').'_'.$request->input('semester_id').'_'.$request->input('year_id').'_'.$request->input('subject_id').'_'.$request->input('exam_paper_id');
            $uploaded_fileName = $this->generateFileName($file_name_tmp,'_', $request->user()->id);
            $uploaded_filePath = $request->file('uploaded_file')->storeAs('public/syllabus', $uploaded_fileName);
            $uploaded_fileUrl = Storage::url($uploaded_filePath);
        }

        $paper->course_id = $request->input('course_id');
        $paper->session_id = $request->input('session_id');
        $paper->event_id = $request->input('event_id');
        $paper->semester_id = $request->input('semester_id');
        $paper->year_id = $request->input('year_id');
        $paper->subject_id = $request->input('subject_id');
        $paper->exam_paper_id = $request->input('exam_paper_id');
        if($request->hasFile('uploaded_file') && $uploaded_fileUrl){
            $paper->uploaded_file = $uploaded_fileUrl;
        }
        $paper->status = $request->input('status');
        $paper->updated_by = $request->user()->id;
        $paper->update();

        return redirect('paper')->with('status','Paper Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paper $paper)
    {
        //
        $paper->delete();
        return redirect('paper')->with('status','Paper Deleted Successfully');
    }

    private function generateFileName($paper_allocation_id,$set, $userId)
    {
        return "{$paper_allocation_id}_{$set}_user_id_{$userId}_" . time() . '.zip';
    }


    public function viewAllBill()
    {
        $current_user = Auth::user();

        $current_user_id = $current_user->id;
        
        if($current_user->hasRole('Super_Admin')){
            $remunerationBill = RemunerationBill::with('teacher','teacher.department','teacher.user','paper','paper.course','paper.session','paper.event','paper.semester','paper.year','paper.subject','paper_upload','paper_allocation')
            ->where('remuneration_bills.submitted_to_secy','=',1)
            ->where('remuneration_bills.status','=',1)
            ->get();

        }else if($current_user->hasRole('Secrecy')){
            $remunerationBill = RemunerationBill::with('teacher','teacher.department','teacher.user','paper','paper.course','paper.session','paper.event','paper.semester','paper.year','paper.subject','paper_upload','paper_allocation')
            ->where('remuneration_bills.submitted_to_secy','=',1)
            ->where('remuneration_bills.status','=',1)
            ->get();
        }else{
            echo 'Auth Failed for this page.';

        }

        // dd($remunerationBill);
        // dd($remunerationBill->toSql(), $remunerationBill->getBindings());

        return view('paper.view_all_bill',compact('remunerationBill'));
    }



    public function viewBill($id)
    {
        $current_user = Auth::user();
        // dd($current_user);
        $current_user_id = $current_user->id;
        
        if($current_user->hasRole('Super_Admin')){
            $remunerationBill = RemunerationBill::with('teacher','teacher.department','teacher.user','paper','paper.course','paper.session','paper.event','paper.semester','paper.year','paper.subject','paper_upload','paper_allocation')
            ->where('remuneration_bills.submitted_to_secy','=',1)
            ->where('remuneration_bills.status','=',1)
            ->where('remuneration_bills.id','=',$id)
            ->first();

        }else if($current_user->hasRole('Secrecy')){
            $remunerationBill = RemunerationBill::with('teacher','teacher.department','teacher.user','paper','paper.course','paper.session','paper.event','paper.semester','paper.year','paper.subject','paper_upload','paper_allocation')
            ->where('remuneration_bills.submitted_to_secy','=',1)
            ->where('remuneration_bills.status','=',1)
            ->where('remuneration_bills.id','=',$id)
            ->first();

        }else{
            echo 'Auth Failed for this page.';

        }



        return view('paper.view_bill',compact('remunerationBill'));
    }


    public function billSubmitToAcc(Request $request)
    {
        // Ensure the referer is valid
        $referer = $request->headers->get('referer');
        $allowedDomain = url('/paper/viewBill'); 

        if (!str_starts_with($referer, $allowedDomain)) {
            abort(403, 'Unauthorized access');
        }

        // Get the current authenticated user
        $current_user = Auth::user();
        $current_user_id = $current_user->id;

        // Fetch the remuneration bill based on user roles
        if ($current_user->hasRole('Super_Admin') || $current_user->hasRole('Secrecy')) {
            $remunerationBill = RemunerationBill::find($request->input('id'));
        } else {
            return redirect()->back()->with('error', 'Authentication failed for this page.');
        }

        if (!$remunerationBill) {
            return redirect()->back()->with('error', 'Remuneration Bill not found.');
        }

        // Update remarks if provided
        if ($request->input('secy_remarks')) {
            $remunerationBill->secy_remarks = $request->input('secy_remarks');
        }

        // Update bill status
        $remunerationBill->submitted_to_acc = 1;
        $remunerationBill->submitted_to_acc_datetime = now();

        // Save the record and set the response message
        $response_status_msg = $remunerationBill->save()
            ? "Submitted to Account Branch successfully."
            : "Failed to submit to Account Branch.";

        // Redirect back to the specified page with a status message
        if($response_status_msg=='Failed to submit to Account Branch.'){
            return redirect()->back()->with('error', $response_status_msg);
        }
        return redirect()->back()->with('status', $response_status_msg);
    }


    public function billUpdateOtherDeduct(Request $request)
    {
        // Ensure the referer is valid
        $referer = $request->headers->get('referer');
        $allowedDomain = url('/paper/viewBill'); 

        if (!str_starts_with($referer, $allowedDomain)) {
            abort(403, 'Unauthorized access');
        }

        // Get the current authenticated user
        $current_user = Auth::user();
        $current_user_id = $current_user->id;

        // Fetch the remuneration bill based on user roles
        if ($current_user->hasRole('Super_Admin') || $current_user->hasRole('Secrecy')) {
            $remunerationBill = RemunerationBill::find($request->input('id'));
        } else {
            return redirect()->back()->with('error', 'Authentication failed for this page.');
        }

        if (!$remunerationBill) {
            return redirect()->back()->with('error', 'Remuneration Bill not found.');
        }

        // Update remarks if provided
        if ($request->input('other_deduct') || $request->input('other_deduct')==0) {
            $remunerationBill->other_deduct = $request->input('other_deduct');
            $remunerationBill->net_pay_amount = $remunerationBill->total_rem_amt - ($remunerationBill->rem_deduct + $remunerationBill->other_deduct);
        }

       // Save the record and set the response message
        if($remunerationBill->save()){
            return redirect()->back()->with('status', 'Other Deduction Updated');
        }else{
            return redirect()->back()->with('error', 'Failed to update other deduction.');
        }

        
    }


}
