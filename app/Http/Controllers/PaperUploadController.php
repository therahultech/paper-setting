<?php

namespace App\Http\Controllers;

use App\Models\Paper_Upload;
use App\Http\Requests\StorePaper_UploadRequest;
use App\Http\Requests\UpdatePaper_UploadRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Paper_Allocation;
// use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PaperUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct()
    {
         $this->middleware('permission:paper_Upload-list|paper_Upload-create|paper_Upload-edit|paper_Upload-delete', ['only' => ['index','store']]);
         $this->middleware('permission:paper_Upload-create', ['only' => ['create','store']]);
         $this->middleware('permission:paper_Upload-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:paper_Upload-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $current_user = Auth::user();
        $current_user_id = $current_user->id;

        // dd(auth()->user()->roles, auth()->user()->permissions);

        
        if($current_user->hasRole('Super_Admin')){
            // $paper_Allocations_with_upload = Paper_Allocation::with('teacher','teacher.department','teacher.user','paper','paper.course','paper.session','paper.event','paper.semester','paper.year','paper.subject')->get();
        

            $paper_Allocations_with_upload = Paper_Allocation::with('teacher','teacher.department','teacher.user','paper','paper.course','paper.session','paper.event','paper.semester','paper.year','paper.subject','paper_upload')
            // ->whereHas('teacher.user', function ($query) use ($current_user_id) {
            //     $query->where('teacher.user_id', $current_user_id);
            // })
            // ->whereHas('paper_upload', function ($query) {
            //     $query->where('paper_upload.status', 1);
            // })
            // ->orWhereDoesntHave('paper_upload')
            ->where('paper_allocation.status','=','1')
            // ->toSql();
            ->get();

        }else if($current_user->hasRole('Teacher')){
            $paper_Allocations_with_upload = Paper_Allocation::with('teacher','teacher.department','teacher.user','paper','paper.course','paper.session','paper.event','paper.semester','paper.year','paper.subject','paper_upload')
            ->whereHas('teacher.user', function ($query) use ($current_user_id) {
                $query->where('teacher.user_id', $current_user_id);
            })
            // ->whereHas('paper_upload', function ($query) {
            //     $query->where('paper_upload.status', 1);
            // })
            // ->orWhereDoesntHave('paper_upload')
            // ->where('paper_allocation.status','=','1')
            // ->toSql();
            ->get();
        }else{
            echo 'Auth Failed for this page.';

        }

        // dd($paper_Allocations_with_upload);
        // dd($paper_Allocations_with_upload[0]->paper_upload);

        return view('paper_Upload.index',compact('paper_Allocations_with_upload','current_user'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($paper_allocation_id)
    {
        //
        // $request->validate([
        //     'paper_allocation_id' => 'required|exists:paper_allocation,id',
        // ]);

        $current_user = Auth::user();
        // dd($current_user);
        $current_user_id = $current_user->id;
        
        if($current_user->hasRole('Super_Admin')){
            // $paper_Allocations_with_upload = Paper_Allocation::with('teacher','teacher.department','teacher.user','paper','paper.course','paper.session','paper.event','paper.semester','paper.year','paper.subject')->get();
        

            $paper_Allocations_with_upload = Paper_Allocation::with('teacher','teacher.department','teacher.user','paper','paper.course','paper.session','paper.event','paper.semester','paper.year','paper.subject','paper_upload')
            // ->whereHas('teacher.user', function ($query) use ($current_user_id) {
            //     $query->where('teacher.user_id', $current_user_id);
            // })
            // ->whereHas('paper_upload', function ($query) {
            //     $query->where('paper_upload.status', 1);
            // })
            // ->orWhereDoesntHave('paper_upload')
            ->where('paper_allocation.status','=','1')
            ->where('paper_allocation.id','=',$paper_allocation_id)
            // ->toSql();
            ->get();

        }else if($current_user->hasRole('Teacher')){
            $paper_Allocations_with_upload = Paper_Allocation::with('teacher','teacher.department','teacher.user','paper','paper.course','paper.session','paper.event','paper.semester','paper.year','paper.subject','paper_upload')
            ->whereHas('teacher.user', function ($query) use ($current_user_id) {
                $query->where('teacher.user_id', $current_user_id);
            })
            // ->whereHas('paper_upload', function ($query) {
            //     $query->where('paper_upload.status', 1);
            // })
            // ->orWhereDoesntHave('paper_upload')
            // ->where('paper_allocation.status','=','1')
            // ->toSql();
            ->where('paper_allocation.id','=',$paper_allocation_id)
            ->get();
        }else{
            echo 'Auth Failed for this page.';

        }
        

        // dd($paper_Allocations_with_upload);

        return view('paper_Upload.create',compact('paper_Allocations_with_upload','paper_allocation_id'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePaper_UploadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaper_UploadRequest $request)
    {
        //
        // dd($request->all());
        $paper_Upload;
        $paper_Upload_id;
        $response_status_msg = 'Paper Uploaded Successfully';
        if($request->id){
            $paper_Upload = Paper_Upload::find($request->id);
        }else{
            $paper_Upload = new Paper_Upload();
            $paper_Upload->paper_allocation_id = $request->input('paper_allocation_id');
            $paper_Upload->created_by = $request->user()->id;
            $paper_Upload->save(); 
            $paper_Upload_id = $paper_Upload->getKey();
            $paper_Upload = Paper_Upload::find($paper_Upload_id);
        }
        if(!($paper_Upload->set1_uploaded && $paper_Upload->set1_file)){
            $validator = $request->validate([
                'paper_allocation_id' => 'required',
                'set1_file' => 'required|mimes:zip',
                'set2_file' => 'nullable|mimes:zip',
         
            ]);
        }

        // echo($paper_Upload_id);
        // echo($paper_Upload);
        
        // dd($paper_Upload);

        if(($paper_Upload->set1_uploaded && $paper_Upload->set1_file && !$request->hasFile('set1_file') && !$request->hasFile('set2_file')) && !$request->input('final_submit')){
            $validator = $request->validate([
                'paper_allocation_id' => 'required',
                // 'set1_file' => 'required|mimes:zip',
                'set2_file' => 'required|mimes:zip',
         
            ]);
        }

  

        if(($paper_Upload->set1_uploaded && $paper_Upload->set1_file) && ($paper_Upload->set2_uploaded && $paper_Upload->set2_file) && $request->input('final_submit')){

            $paper_Upload->update([
                'final_submit' => $request->input('final_submit'),
            ]);
            $response_status_msg = 'Final Submission has been done for the Paper';
            
        }else{
            if((!$paper_Upload->set1_uploaded && !$paper_Upload->set1_file) || ($paper_Upload->set1_uploaded && $paper_Upload->set1_file && $request->hasFile('set1_file'))){
                $set1FileName = $this->generateFileName($request->paper_allocation_id,'set1', $request->user()->id);
                $set1FilePath = $request->file('set1_file')->storeAs('public/uploads', $set1FileName);
                $set1FileUrl = Storage::url($set1FilePath);
    
                // dd($set1FilePath);
    
                if($paper_Upload){
                    // $paper_Upload = Paper_Upload::find($request->id);
                    // $paper_Upload->paper_allocation_id = $request->input('paper_allocation_id');
                    $paper_Upload->set1_uploaded = $set1FilePath?1:0;
                    $paper_Upload->set1_file = $set1FileUrl;
                    $paper_Upload->update();
                }else{
                    $paper_Upload = new Paper_Upload();
                    $paper_Upload->paper_allocation_id = $request->input('paper_allocation_id');
                    $paper_Upload->set1_uploaded = $set1FilePath?1:0;
                    $paper_Upload->set1_file = $set1FileUrl;
                    $paper_Upload->save();            
                }
            }
                    
            // dd($paper_Upload);
        
                
            // $paperAllocation = Paper_Allocation::find($request->paper_allocation_id);
            // $paperAllocation->paper_upload()->save($paper_Upload);
        
            if ($request->hasFile('set2_file')) {
                $set2FileName = $this->generateFileName($request->paper_allocation_id,'set2', $request->user()->id);
                $set2FilePath = $request->file('set2_file')->storeAs('public/uploads', $set2FileName);
                $set2FileUrl = Storage::url($set2FilePath);
        
                $paper_Upload->update([
                    'set2_uploaded' => 1,
                    'set2_file' => $set2FileUrl,
                    'final_submit' => $request->input('final_submit'),
                ]);
            }
    
        }
        
    
       
        
    
        return redirect('paper_Upload')->with('status',$response_status_msg);
    }




    private function generateFileName($paper_allocation_id,$set, $userId)
    {
        return "{$paper_allocation_id}_{$set}_user_id_{$userId}_" . time() . '.zip';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paper_Upload  $paper_Upload
     * @return \Illuminate\Http\Response
     */
    public function show(Paper_Upload $paper_Upload)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paper_Upload  $paper_Upload
     * @return \Illuminate\Http\Response
     */
    public function edit(Paper_Upload $paper_Upload)
    {
        //
        return $paper_Upload;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaper_UploadRequest  $request
     * @param  \App\Models\Paper_Upload  $paper_Upload
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaper_UploadRequest $request, Paper_Upload $paper_Upload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paper_Upload  $paper_Upload
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paper_Upload $paper_Upload)
    {
        //
    }
}
