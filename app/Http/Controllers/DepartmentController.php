<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;

class DepartmentController extends Controller
{


    function __construct()
    {
         $this->middleware('permission:department-list|department-create|department-edit|department-delete', ['only' => ['index','store']]);
         $this->middleware('permission:department-create', ['only' => ['create','store']]);
         $this->middleware('permission:department-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:department-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $depts = Department::all();
        // echo '<pre>';
        $all_users_with_all_their_roles = User::with('roles')->get();
        // print_r($dept);
        // return view('department');
        return view('department.index',compact('depts','all_users_with_all_their_roles'));
        // return View::make(department.index, compact($dept));
        // echo Role::all()->pluck('name');
        // echo User::with('roles')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('department.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDepartmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartmentRequest $request)
    {
        //
        $validated = $request->validate([
            'code'=>'required|unique:department|max:50',
            'name'=>'required|unique:department|max:500',
        ]);

        $department = new Department;
        $department->code = $request->input('code');
        $department->name = $request->input('name');
        $department->status = $request->input('status');
        $department->created_by = $request->user()->id;
        $department->save();
        // print_r($department);
        // echo '<br>status:'.$department->status;
        return redirect('department')->with('status','Department Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
        // print_r($department);
        $dept = Department::find($department->id);
        return view('department.edit',compact('dept'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDepartmentRequest  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        //
        $validated = $request->validate([
            'code'=>'required|max:50',
            'name'=>'required|max:500',
        ]);

        // $department = Department::find($department->id);
        $department->code = $request->input('code');
        $department->name = $request->input('name');
        $department->status = $request->input('status');
        $department->updated_by = $request->user()->id;
        $department->save();
        
        return redirect('department')->with('status','Department Updated Successfully');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //
        $department->delete();
        return redirect('department')->with('status','Department Deleted Successfully');
    }
}
