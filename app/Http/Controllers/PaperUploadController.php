<?php

namespace App\Http\Controllers;

use App\Models\Paper_Upload;
use App\Http\Requests\StorePaper_UploadRequest;
use App\Http\Requests\UpdatePaper_UploadRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Paper_Allocation;
use App\Models\RemunerationBill;
use App\Models\Remuneration;

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
    // public function store(StorePaper_UploadRequest $request)
    // {
    //     //
    //     // dd($request->all());
    //     $paper_Upload;
    //     $paper_Upload_id;
    //     $response_status_msg = 'Paper Uploaded Successfully';
    //     if($request->id){
    //         $paper_Upload = Paper_Upload::find($request->id);
    //     }else{
    //         $paper_Upload = new Paper_Upload();
    //         $paper_Upload->paper_allocation_id = $request->input('paper_allocation_id');
    //         $paper_Upload->created_by = $request->user()->id;
    //         $paper_Upload->save(); 
    //         $paper_Upload_id = $paper_Upload->getKey();
    //         $paper_Upload = Paper_Upload::find($paper_Upload_id);
    //     }
    //     if(!($paper_Upload->set1_uploaded && $paper_Upload->set1_file)){
    //         $validator = $request->validate([
    //             'paper_allocation_id' => 'required',
    //             'set1_file' => 'required|mimes:zip',
    //             'set2_file' => 'nullable|mimes:zip',
         
    //         ]);
    //     }

    //     // echo($paper_Upload_id);
    //     // echo($paper_Upload);
        
    //     // dd($paper_Upload);

    //     if(($paper_Upload->set1_uploaded && $paper_Upload->set1_file && !$request->hasFile('set1_file') && !$request->hasFile('set2_file')) && !$request->input('final_submit')){
    //         $validator = $request->validate([
    //             'paper_allocation_id' => 'required',
    //             // 'set1_file' => 'required|mimes:zip',
    //             'set2_file' => 'required|mimes:zip',
         
    //         ]);
    //     }

  

    //     if(($paper_Upload->set1_uploaded && $paper_Upload->set1_file) && ($paper_Upload->set2_uploaded && $paper_Upload->set2_file) && $request->input('final_submit')){

    //         $paper_Upload->update([
    //             'final_submit' => $request->input('final_submit'),
    //         ]);
    //         $response_status_msg = 'Final Submission has been done for the Paper';
            
    //     }else{
    //         if((!$paper_Upload->set1_uploaded && !$paper_Upload->set1_file) || ($paper_Upload->set1_uploaded && $paper_Upload->set1_file && $request->hasFile('set1_file'))){
    //             $set1FileName = $this->generateFileName($request->paper_allocation_id,'set1', $request->user()->id);
    //             $set1FilePath = $request->file('set1_file')->storeAs('public/uploads', $set1FileName);
    //             $set1FileUrl = Storage::url($set1FilePath);
    
    //             // dd($set1FilePath);
    
    //             if($paper_Upload){
    //                 // $paper_Upload = Paper_Upload::find($request->id);
    //                 // $paper_Upload->paper_allocation_id = $request->input('paper_allocation_id');
    //                 $paper_Upload->set1_uploaded = $set1FilePath?1:0;
    //                 $paper_Upload->set1_file = $set1FileUrl;
    //                 $paper_Upload->update();
    //             }else{
    //                 $paper_Upload = new Paper_Upload();
    //                 $paper_Upload->paper_allocation_id = $request->input('paper_allocation_id');
    //                 $paper_Upload->set1_uploaded = $set1FilePath?1:0;
    //                 $paper_Upload->set1_file = $set1FileUrl;
    //                 $paper_Upload->save();            
    //             }
    //         }
                    
    //         // dd($paper_Upload);
        
                
    //         // $paperAllocation = Paper_Allocation::find($request->paper_allocation_id);
    //         // $paperAllocation->paper_upload()->save($paper_Upload);
        
    //         if ($request->hasFile('set2_file')) {
    //             $set2FileName = $this->generateFileName($request->paper_allocation_id,'set2', $request->user()->id);
    //             $set2FilePath = $request->file('set2_file')->storeAs('public/uploads', $set2FileName);
    //             $set2FileUrl = Storage::url($set2FilePath);
        
    //             $paper_Upload->update([
    //                 'set2_uploaded' => 1,
    //                 'set2_file' => $set2FileUrl,
    //                 'final_submit' => $request->input('final_submit'),
    //             ]);
    //         }
    
    //     }
        
    
       
        
    
    //     return redirect('paper_Upload')->with('status',$response_status_msg);
    // }




    // private function generateFileName($paper_allocation_id,$set, $userId)
    // {
    //     return "{$paper_allocation_id}_{$set}_user_id_{$userId}_" . time() . '.zip';
    // }

    private function generateFileName($paper_allocation_id, $set, $userId, $extension)
    {
        return "{$paper_allocation_id}_{$set}_user_id_{$userId}_" . time() . ".{$extension}";
    }


    public function store(StorePaper_UploadRequest $request)
    {
        $paper_Upload;
        $paper_Upload_id;
        $response_status_msg = 'Paper Uploaded Successfully';

        if ($request->id) {
            $paper_Upload = Paper_Upload::find($request->id);
        } else {
            $paper_Upload = new Paper_Upload();
            $paper_Upload->paper_allocation_id = $request->input('paper_allocation_id');
            $paper_Upload->created_by = $request->user()->id;
            $paper_Upload->save();
            $paper_Upload_id = $paper_Upload->getKey();
            $paper_Upload = Paper_Upload::find($paper_Upload_id);
        }

        $allowedExtensions = 'pdf,doc,docx,zip'; // Define allowed file extensions

        if (!($paper_Upload->set1_uploaded && $paper_Upload->set1_file)) {
            $request->validate([
                'paper_allocation_id' => 'required',
                'set1_file' => 'required|file',
                'set2_file' => 'nullable|file',
            ]);
        }

        if (($paper_Upload->set1_uploaded && $paper_Upload->set1_file && !$request->hasFile('set1_file') && !$request->hasFile('set2_file')) && !$request->input('final_submit')) {
            $request->validate([
                'paper_allocation_id' => 'required',
                'set2_file' => 'required|file',
            ]);
        }

        if (($paper_Upload->set1_uploaded && $paper_Upload->set1_file) && ($paper_Upload->set2_uploaded && $paper_Upload->set2_file) && $request->input('final_submit')) {
            $paper_Upload->update([
                'final_submit' => $request->input('final_submit'),
            ]);
            $response_status_msg = 'Final Submission has been done for the Paper';
        } else {
            if ((!$paper_Upload->set1_uploaded && !$paper_Upload->set1_file) || ($paper_Upload->set1_uploaded && $paper_Upload->set1_file && $request->hasFile('set1_file'))) {
                $file = $request->file('set1_file');
                $extension = $file->getClientOriginalExtension();
                $set1FileName = $this->generateFileName($request->paper_allocation_id, 'set1', $request->user()->id, $extension);
                $set1FilePath = $file->storeAs('public/uploads', $set1FileName);
                $set1FileUrl = Storage::url($set1FilePath);

                $paper_Upload->set1_uploaded = $set1FilePath ? 1 : 0;
                $paper_Upload->set1_file = $set1FileUrl;
                $paper_Upload->update();
            }

            if ($request->hasFile('set2_file')) {
                $file = $request->file('set2_file');
                $extension = $file->getClientOriginalExtension();
                $set2FileName = $this->generateFileName($request->paper_allocation_id, 'set2', $request->user()->id, $extension);
                $set2FilePath = $file->storeAs('public/uploads', $set2FileName);
                $set2FileUrl = Storage::url($set2FilePath);

                $paper_Upload->update([
                    'set2_uploaded' => 1,
                    'set2_file' => $set2FileUrl,
                    'final_submit' => $request->input('final_submit'),
                ]);
            }
        }

        return redirect('paper_Upload')->with('status', $response_status_msg);
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

    public function viewBill($paper_upload_id)
    {
        $current_user = Auth::user();
        $remuneration = Remuneration::where('status', 1)->first();
        // dd($current_user);
        $current_user_id = $current_user->id;
        
        if($current_user->hasRole('Super_Admin')){
            // $paper_Allocations_with_upload = Paper_Allocation::with('teacher','teacher.department','teacher.user','paper','paper.course','paper.session','paper.event','paper.semester','paper.year','paper.subject')->get();
        

            $paper_Allocations_with_upload = Paper_Allocation::with('teacher','teacher.department','teacher.user','paper','paper.course','paper.session','paper.event','paper.semester','paper.year','paper.subject','paper_upload')
            // ->whereHas('teacher.user', function ($query) use ($current_user_id) {
            //     $query->where('teacher.user_id', $current_user_id);
            // })
            ->whereHas('paper_upload', function ($query)  use ($paper_upload_id){
                $query->where('paper_upload.id', $paper_upload_id);
            })
            // ->orWhereDoesntHave('paper_upload')
            ->where('paper_allocation.status','=','1')
            // ->toSql();
            ->get();

        }else if($current_user->hasRole('Teacher')){
            $paper_Allocations_with_upload = Paper_Allocation::with('teacher','teacher.department','teacher.user','paper','paper.course','paper.session','paper.event','paper.semester','paper.year','paper.subject','paper_upload')
            ->whereHas('teacher.user', function ($query) use ($current_user_id) {
                $query->where('teacher.user_id', $current_user_id);
            })
            ->whereHas('paper_upload', function ($query)  use ($paper_upload_id){
                $query->where('paper_upload.id', $paper_upload_id);
            })
            // ->orWhereDoesntHave('paper_upload')
            ->where('paper_allocation.status','=','1')
            // ->toSql();
            ->get();
        }else{
            echo 'Auth Failed for this page.';

        }

        if(($paper_Allocations_with_upload[0]->paper_upload->set1_file && $paper_Allocations_with_upload[0]->paper_upload->set2_file) && $paper_Allocations_with_upload[0]->paper_upload->final_submit!=1){
            return redirect()->back()->with('error', 'Paper is not final submitted or something is incomplete');
        }

        // dd($paper_Allocations_with_upload[0]->paper_upload);
        // dd($paper_Allocations_with_upload);

        $paper_Allocation = $paper_Allocations_with_upload[0];

       
        $remunerationBill = RemunerationBill::where('paper_upload_id', $paper_Allocation->paper_upload->id)
            ->where('paper_allocation_id', $paper_Allocation->id)
            ->first();

        if (!$remunerationBill) {
            // If it doesn't exist, create a new instance
            $remunerationBill = new RemunerationBill();
            $remunerationBill->paper_upload_id = $paper_Allocation->paper_upload->id;
            $remunerationBill->paper_allocation_id = $paper_Allocation->id;
            // Assign or update other values
            $remunerationBill->course_id = $paper_Allocation->paper->course->id;
            $remunerationBill->session_id = $paper_Allocation->paper->session->id;
            $remunerationBill->event_id = $paper_Allocation->paper->event->id;
            $remunerationBill->semester_id = $paper_Allocation->paper->semester->id ?? 0;
            $remunerationBill->year_id = $paper_Allocation->year->id ?? 0;
            $remunerationBill->paper_id = $paper_Allocation->paper->id;
            $remunerationBill->subject_id = $paper_Allocation->paper->subject->id;
            $remunerationBill->exam_paper_id = $paper_Allocation->paper->exam_paper_id;
            if($paper_Allocation->paper_upload->set1_file && $paper_Allocation->paper_upload->set2_file && $paper_Allocation->paper_upload->final_submit==1){
                $remunerationBill->paper_set_count = 2;
            }elseif($paper_Allocation->paper_upload->set1_file || $paper_Allocation->paper_upload->set2_file){
                $remunerationBill->paper_set_count = 1;
            }else{
                $remunerationBill->paper_set_count = 0;
            }

            // Teacher Details
            $remunerationBill->user_id = $paper_Allocation->teacher->user_id;
            $remunerationBill->teacher_id = $paper_Allocation->teacher->id;
            $remunerationBill->acc_holder_name = $paper_Allocation->teacher->acc_holder_name;
            $remunerationBill->bank_acc_no = $paper_Allocation->teacher->bank_acc_no;
            $remunerationBill->bank_name = $paper_Allocation->teacher->bank_name;
            $remunerationBill->bank_branch_name = $paper_Allocation->teacher->bank_branch_name;
            $remunerationBill->bank_ifsc = $paper_Allocation->teacher->bank_ifsc;
            $remunerationBill->bank_code = $paper_Allocation->teacher->bank_code;

            // Remuneration Details
            $remunerationBill->total_rem_amt = $remuneration->per_set*$remunerationBill->paper_set_count; // Fixed value, update as needed
            $remunerationBill->rem_deduct = $remuneration->twf_deduction*$remunerationBill->paper_set_count; // Fixed value, update as needed
            $remunerationBill->net_pay_amount = $remunerationBill->total_rem_amt-$remunerationBill->rem_deduct; // Fixed value, update as needed

            // Timestamps and User Information
            $remunerationBill->created_by = $remunerationBill->created_by ?? auth()->id(); // Preserve the creator if it already exists
            // $remunerationBill->updated_by = auth()->id(); // Set the updater to the current user

            $remunerationBill->save();
        }

        // $remunerationBill = RemunerationBill::where('paper_upload_id', $paper_Allocation->paper_upload->id)
        // ->where('paper_allocation_id', $paper_Allocation->id)
        // ->first();

        $remunerationBill = RemunerationBill::with('teacher','teacher.department','teacher.user','paper','paper.course','paper.session','paper.event','paper.semester','paper.year','paper.subject','paper_upload','paper_allocation')
        ->where('remuneration_bills.paper_allocation_id','=',$paper_Allocation->id)
        ->where('remuneration_bills.paper_upload_id','=',$paper_Allocation->paper_upload->id)
        ->first();

        // dd($remunerationBill);
        // dd($remunerationBill->toSql(), $remunerationBill->getBindings());

        return view('paper_Upload.view_bill',compact('remunerationBill','paper_upload_id'));
    }


    public function billSubmitToSecy(Request $request)
    {

        $referer = $request->headers->get('referer');
        $allowedDomain = url('/'.'paper_Upload/viewBill'); 

        if (!str_starts_with($referer, $allowedDomain)) {
            abort(403, 'Unauthorized access');
        }

        $current_user = Auth::user();
        $current_user_id = $current_user->id;

        if($current_user->hasRole('Super_Admin')){
            
            $remunerationBill = RemunerationBill::where('remuneration_bills.id','=',$request->input('id'))
            ->first();
            
        }else if($current_user->hasRole('Teacher')){
            
            $remunerationBill = RemunerationBill::where('remuneration_bills.id','=',$request->input('id'))
            ->where('remuneration_bills.user_id','=',$current_user_id)
            ->first();
        }else{
            echo 'Auth Failed for this page.';
        }

        // dd($remunerationBill);
        $remunerationBill->submitted_to_secy=1;
        $remunerationBill->submitted_to_secy_datetime=date('Y-m-d H:i:s');
        if ($remunerationBill->save()) {
            $response_status_msg = "Submitted to Secrecy Branch successfully.";
        } else {
            $response_status_msg = "Failed to submit to Secrecy Branch.";
        }


        return redirect('paper_Upload')->with('status',$response_status_msg);

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
