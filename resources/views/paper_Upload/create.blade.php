<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Paper Files Upload') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    
    
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">



            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                <div class="p-6 col-span-12 md:col-span-12 xl:col-span-12 ">
                                <a
                                    type="button"
                                    href="{{url('paper_Upload')}}"
                                    data-te-ripple-init
                                    data-te-ripple-color="light"
                                    class="float-right bg-primary rounded px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white transition duration-150 ease-in-out hover:bg-primary-100 hover:text-white-600 focus:text-white-600 focus:outline-none focus:ring-0 active:text-white-700 dark:hover:bg-primary-700">
                                    <i class="fa-solid fa-arrow-left"></i>&nbsp; Go Back
                                </a>
                </div>
                <!--  -->
                <table class="min-w-full text-left text-sm font-light nowrap" id='view_table' style="width:100%">
                        <thead class="border-b font-medium dark:border-neutral-500">
                            <tr class="border-b dark:border-neutral-500">
                                <th scope="col" class="px-6 py-4">Course</th>
                                <th scope="col" class="px-6 py-4">Session</th>
                                <th scope="col" class="px-6 py-4">Event</th>
                                <th scope="col" class="px-6 py-4">Semster/Year</th>
                                <th scope="col" class="px-6 py-4">Subject</th>
                                <th scope="col" class="px-6 py-4">Paper ID</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paper_Allocations_with_upload as $tkey=>$paper_Allocation)
                            <tr class="border-b dark:border-neutral-500">
                                <td class="whitespace-nowrap px-6 py-4">{{$paper_Allocation->paper->course->code.'-'.$paper_Allocation->paper->course->name}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper_Allocation->paper->session->name}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper_Allocation->paper->event->name}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper_Allocation->paper->semester->id?'Sem-'.$paper_Allocation->paper->semester->name:'Year'.$paper_Allocation->year->name}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper_Allocation->paper->subject->code.'-'.$paper_Allocation->paper->subject->name}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper_Allocation->paper->exam_paper_id}}</td>
                            </tr>
                            @endforeach
                        </tbody>   
                        
                    </table>

                <!--  -->

                <br><br>

                    <div
                    class="mb-4 rounded-lg bg-danger-100 px-6 py-5 text-base text-danger-700"
                    role="alert">
                    <h4 class="mb-2 text-2xl font-medium leading-tight">Note!</h4>
                    <p class="mb-4">
                        You must upload password protected zip files for both set of papers and password of zip files must be shared to the Secrecy Branch from another channel. We are not responsible for the uploaded zip files and papers.
                    </p>
                    </div>

                    <div class="grid grid-cols-12 gap-4">
                        <!-- Column -->
                        
                        
                        <div class="col-span-12 md:col-span-12 xl:col-span-12">
                            <form method="post" action="{{ url('paper_Upload') }}" enctype="multipart/form-data">
                                @csrf
                                
                                <!-- start -->

                                <input type="hidden" name="id" value="{{$paper_Allocations_with_upload[0]->paper_upload ? $paper_Allocations_with_upload[0]->paper_upload->id : 'null'}}">

                                <input type="hidden" name="paper_allocation_id" id="paper_allocation_id" value="{{$paper_allocation_id?$paper_allocation_id:''}}">

                                <div class="relative mb-6" >
                                <label
                                    for="set1_file"
                                    class="mb-2 inline-block text-neutral-700 dark:text-neutral-200"
                                    >Set 1 File Upload</label
                                >
                                @if($paper_Allocations_with_upload[0]->paper_upload->final_submit!=1)
                                <input
                                    class="@error('set1_file') is-invalid @enderror relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] font-normal leading-[2.15] text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                                    id="set1_file"
                                    name="set1_file"
                                    type="file"
                                    accept=".zip"
                                    />

                                @error('set1_file')
                                <div
                                    class="absolute w-full text-sm text-neutral-500 peer-focus:text-primary dark:text-neutral-200 dark:peer-focus:text-primary"
                                    data-te-input-helper-ref>
                                    {{ $message }}
                                </div>
                                @enderror
                                </div>
                                @endif
                                <div class="relative mb-6" >
                                
                                @if($paper_Allocations_with_upload[0]->paper_upload->set1_file)
                                <label
                                    class="mb-2 inline-block text-neutral-700 dark:text-neutral-200"
                                    >Uploaded</label
                                >
                                <a 
                                href="{{ asset($paper_Allocations_with_upload[0]->paper_upload->set1_file)}}" 
                                target="_blank"
                                class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600"
                                >Download Set1</a>
                                @endif
                                </div>
                                
                                

                                <div class="relative mb-6" >
                                <label
                                    for="set2_file"
                                    class="mb-2 inline-block text-neutral-700 dark:text-neutral-200"
                                    >Set 2 File Upload</label
                                >
                                @if($paper_Allocations_with_upload[0]->paper_upload->final_submit!=1)
                                <input
                                    class="@error('set2_file') is-invalid @enderror relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] font-normal leading-[2.15] text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                                    id="set2_file"
                                    name="set2_file"
                                    type="file" 
                                    accept=".zip"
                                    />
                                
                                @error('set2_file')
                                <div
                                    class="absolute w-full text-sm text-neutral-500 peer-focus:text-primary dark:text-neutral-200 dark:peer-focus:text-primary"
                                    data-te-input-helper-ref>
                                    {{ $message }}
                                </div>
                                @enderror
                                @endif
                                </div>

                                <div class="relative mb-6" >
                                @if($paper_Allocations_with_upload[0]->paper_upload->set2_file)
                                <label
                                    class="mb-2 inline-block text-neutral-700 dark:text-neutral-200"
                                    >Uploaded</label
                                >
                                <a 
                                href="{{ asset($paper_Allocations_with_upload[0]->paper_upload->set2_file)}}" 
                                target="_blank"
                                class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600"
                                >Download Set2</a>
                                @endif
                                </div>
                                

                                <!--Submit button-->
                                @if($paper_Allocations_with_upload[0]->paper_upload->final_submit!=1)
                                <button
                                type="submit"
                                class="inline-block w-full rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]"
                                data-te-ripple-init
                                data-te-ripple-color="light">
                                Upload
                                </button>
                                @endif

                                @if(($paper_Allocations_with_upload[0]->paper_upload->set1_file && $paper_Allocations_with_upload[0]->paper_upload->set2_file) && $paper_Allocations_with_upload[0]->paper_upload->final_submit!=1)
                                <br><br>
                                <button
                                type="submit"
                                class="inline-block w-full rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]"
                                data-te-ripple-init
                                data-te-ripple-color="light"
                                id="final_submit"
                                name="final_submit"
                                value="1"
                                onclick="return validateFinalSubmit()"
                                >
                                Final Submit
                                </button>
                                @endif

                                <!-- end -->
                            </form>
                        </div>

                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
        $(document).ready(function() {
            $('#view_table').DataTable( {
                responsive: true,
                "bPaginate": false, //hide pagination
                "bFilter": false, //hide Search bar
                "bInfo": false, // hide showing entries
            } );
        } );

        function validateFinalSubmit() {
            
            var result = confirm("Are you sure you want to proceed with the final submission? Keep in mind that you won't be able to make any changes after the final submission.");
            if (result) {
            return true;
            }
            else {
            return false;
            }
            
        }

</script>