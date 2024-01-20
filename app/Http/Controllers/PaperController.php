<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Http\Requests\StorePaperRequest;
use App\Http\Requests\UpdatePaperRequest;
use App\Models\Course;
use App\Models\Session;
use App\Models\Event;
use App\Models\Semester;
use App\Models\Year;
use App\Models\Subject;
use Illuminate\Validation\Rule;

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

        $paper = new Paper;
        $paper->course_id = $request->input('course_id');
        $paper->session_id = $request->input('session_id');
        $paper->event_id = $request->input('event_id');
        $paper->semester_id = $request->input('semester_id');
        $paper->year_id = $request->input('year_id');
        $paper->subject_id = $request->input('subject_id');
        $paper->exam_paper_id = $request->input('exam_paper_id');
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

        $paper->course_id = $request->input('course_id');
        $paper->session_id = $request->input('session_id');
        $paper->event_id = $request->input('event_id');
        $paper->semester_id = $request->input('semester_id');
        $paper->year_id = $request->input('year_id');
        $paper->subject_id = $request->input('subject_id');
        $paper->exam_paper_id = $request->input('exam_paper_id');
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

}
