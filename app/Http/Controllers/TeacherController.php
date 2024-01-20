<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
// use Illuminate\Support\Facades\DB;
use App\Models\Department;
use App\Models\City;
use App\Models\District;
use App\Models\State;


class TeacherController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:teacher-list|teacher-create|teacher-edit|teacher-delete', ['only' => ['index','store']]);
         $this->middleware('permission:teacher-create', ['only' => ['create','store']]);
         $this->middleware('permission:teacher-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:teacher-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $teachers = Teacher::all();
        
        // DB::enableQueryLog();
         $teachers = Teacher::with('department','user','city')->get();
        // echo '<pre>';
        // print_r($teachers);
        // $quries = DB::getQueryLog();
        // return $teachers;
        return view('teacher.index',compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $departments = Department::all();
        $cities = City::with('district','state')->get();

        return view('teacher.create',compact('departments','cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTeacherRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeacherRequest $request)
    {
        //
        $validated = $request->validate([
            'department_id'=>'required',
            // 'user_id'=>'required',
            'emp_code'=>'required|unique:teacher',
            'name_prefix'=>'required|max:10',
            'name'=>'required|max:100',
            'email'=>'required|unique:teacher|max:500',
            'mobile1'=>'required|max:10',
            'mobile1'=>'max:10',
            'addr1'=>'required|max:500',
            'addr2'=>'max:500',
            'city_id'=>'required',
        ]);

        $teacher = new Teacher;
        $teacher->department_id = $request->input('department_id');
        $teacher->emp_code = $request->input('emp_code');
        $teacher->name_prefix = $request->input('name_prefix');
        $teacher->name = $request->input('name');
        $teacher->email = $request->input('email');
        $teacher->mobile1 = $request->input('mobile1');
        $teacher->mobile2 = $request->input('mobile2');
        $teacher->addr1 = $request->input('addr1');
        $teacher->addr2 = $request->input('addr2');
        $teacher->city_id = $request->input('city_id');
        $teacher->status = $request->input('status');
        $teacher->created_by = $request->user()->id;
        $teacher->save();

        return redirect('teacher')->with('status','Teacher Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        //

        $teacher = Teacher::find($teacher->id);
        $departments = Department::all();
        $cities = City::with('district','state')->get();
        return view('teacher.edit',compact('teacher','departments','cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTeacherRequest  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeacherRequest $request, Teacher $teacher)
    {
        //
        $validated = $request->validate([
            'department_id'=>'required',
            // 'user_id'=>'required',
            'emp_code'=>'required|unique:teacher',
            'name_prefix'=>'required|max:10',
            'name'=>'required|max:100',
            'email'=>'required|unique:teacher|max:500',
            'mobile1'=>'required|max:10',
            'mobile1'=>'max:10',
            'addr1'=>'required|max:500',
            'addr2'=>'max:500',
            'city_id'=>'required',
        ]);

        $teacher->department_id = $request->input('department_id');
        $teacher->emp_code = $request->input('emp_code');
        $teacher->name_prefix = $request->input('name_prefix');
        $teacher->name = $request->input('name');
        $teacher->email = $request->input('email');
        $teacher->mobile1 = $request->input('mobile1');
        $teacher->mobile2 = $request->input('mobile2');
        $teacher->addr1 = $request->input('addr1');
        $teacher->addr2 = $request->input('addr2');
        $teacher->city_id = $request->input('city_id');
        $teacher->status = $request->input('status');
        $teacher->updated_by = $request->user()->id;
        $teacher->update();

        return redirect('teacher')->with('status','Teacher Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        //
        $teacher->delete();
        return redirect('teacher')->with('status','Teacher Deleted Successfully');
    }
}
