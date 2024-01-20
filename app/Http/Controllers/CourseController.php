<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

class CourseController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:course-list|course-create|course-edit|course-delete', ['only' => ['index','store']]);
         $this->middleware('permission:course-create', ['only' => ['create','store']]);
         $this->middleware('permission:course-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:course-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $courses = Course::all();
        return view('course.index',compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('course.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCourseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseRequest $request)
    {
        //
        $validated = $request->validate([
            'code'=>'required|unique:course|max:50',
            'name'=>'required|unique:course|max:500',
            'duration'=>'required',
        ]);

        $course = new Course;
        $course->code = $request->input('code');
        $course->name = $request->input('name');
        $course->is_year_based = $request->input('is_year_based');
        $course->duration = $request->input('duration');
        $course->status = $request->input('status');
        $course->created_by = $request->user()->id;
        $course->save();

        return redirect('course')->with('status','Course Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
        $course = Course::find($course->id);
        return view('course.edit',compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCourseRequest  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        //
        $validated = $request->validate([
            'code'=>'required|max:50',
            'name'=>'required|max:500',
            'duration'=>'required',
        ]);

        // $course = new Course;
        $course->code = $request->input('code');
        $course->name = $request->input('name');
        $course->is_year_based = $request->input('is_year_based');
        $course->duration = $request->input('duration');
        $course->status = $request->input('status');
        $course->updated_by = $request->user()->id;
        $course->update();

        return redirect('course')->with('status','Course Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
        $course->delete();
        return redirect('course')->with('status','Course Deleted Successfully');
    }
}
