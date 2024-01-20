<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;

class SubjectController extends Controller
{
    
    function __construct()
    {
         $this->middleware('permission:subject-list|subject-create|subject-edit|subject-delete', ['only' => ['index','store']]);
         $this->middleware('permission:subject-create', ['only' => ['create','store']]);
         $this->middleware('permission:subject-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:subject-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $subjects = Subject::all();
        return view('subject.index',compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('subject.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubjectRequest $request)
    {
        //
        $validated = $request->validate([
            'code'=>'required|unique:subject|max:50',
            'name'=>'required|unique:subject|max:500',
        ]);

        $subject = new Subject;
        $subject->code = $request->input('code');
        $subject->name = $request->input('name');
        $subject->is_credit_based = $request->input('is_credit_based');
        $subject->status = $request->input('status');
        $subject->created_by = $request->user()->id;
        $subject->save();

        return redirect('subject')->with('status','Subject Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        //
        $subject = Subject::find($subject->id);
        return view('subject.edit',compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubjectRequest  $request
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        //
        $validated = $request->validate([
            'code'=>'required|max:50',
            'name'=>'required|max:500', 
        ]);

        // $subject = new subject;
        $subject->code = $request->input('code');
        $subject->name = $request->input('name');
        $subject->is_credit_based = $request->input('is_credit_based');
        $subject->status = $request->input('status');
        $subject->updated_by = $request->user()->id;
        $subject->update();

        return redirect('subject')->with('status','Subject Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        //
        $subject->delete();
        return redirect('subject')->with('status','Subject Deleted Successfully');
    }
}
