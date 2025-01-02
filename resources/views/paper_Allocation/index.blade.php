<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Paper Allocation') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <style>

        #set1_used_event_id div {
            z-index: 99999;
        }
    </style>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

       
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if(session('status'))
                        <div
                        class="mb-4 rounded-lg bg-primary-100 px-6 py-5 text-base text-primary-600"
                        role="alert">
                        {{session('status')}}
                        </div>
                    @endif
                    
                    <div class="p-6 bg-white float-right">
                        <a
                            type="button"
                            href="{{url('paper_Allocation/create')}}"
                            data-te-ripple-init
                            data-te-ripple-color="light"
                            class=" bg-primary rounded px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white transition duration-150 ease-in-out hover:bg-primary-100 hover:text-white-600 focus:text-white-600 focus:outline-none focus:ring-0 active:text-white-700 dark:hover:bg-primary-700">
                            <i class="fa-solid fa-plus"></i>&nbsp; Add
                        </a>
                    </div>
                    
                    <table class="min-w-full text-left text-sm font-light nowrap" id='view_table' style="width:100%">
                        <thead class="border-b font-medium dark:border-neutral-500">
                            <tr class="border-b dark:border-neutral-500">
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">Course</th>
                                <th scope="col" class="px-6 py-4">Session</th>
                                <th scope="col" class="px-6 py-4">Event</th>
                                <th scope="col" class="px-6 py-4">Semster/Year</th>
                                <th scope="col" class="px-6 py-4">Subject</th>
                                <th scope="col" class="px-6 py-4">Paper ID</th>
                                <th scope="col" class="px-6 py-4">Teacher</th>
                                <th scope="col" class="px-6 py-4">Teacher's Dept</th>
                                <th scope="col" class="px-6 py-4">Status</th>
                                <th scope="col" class="px-6 py-4">Set1</th>
                                <th scope="col" class="px-6 py-4">Set2</th>
                                <th scope="col" class="px-6 py-4">Final Submit</th>
                                <th scope="col" class="px-6 py-4">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paper_Allocations as $tkey=>$paper_Allocation)
                            <tr class="border-b dark:border-neutral-500">
                                <td class="whitespace-nowrap px-6 py-4 font-medium">{{$tkey+1}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper_Allocation->paper->course->code.'-'.$paper_Allocation->paper->course->name}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper_Allocation->paper->session->name}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper_Allocation->paper->event->name}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper_Allocation->paper->semester->id?'Sem-'.$paper_Allocation->paper->semester->name:'Year'.$paper_Allocation->year->name}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper_Allocation->paper->subject->code.'-'.$paper_Allocation->paper->subject->name}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper_Allocation->paper->exam_paper_id}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper_Allocation->teacher->name_prefix.' '.$paper_Allocation->teacher->name}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper_Allocation->teacher->department->code.' '.$paper_Allocation->teacher->department->name}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper_Allocation->status==1?'Active':'Inactive'}}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if($paper_Allocation->paper_upload && $paper_Allocation->paper_upload->set1_uploaded)

                                        @if($paper_Allocation->paper_upload->final_submit)
                                        @can('paper_download')
                                        <a 
                                href="{{ asset($paper_Allocation->paper_upload->set1_file)}}" 
                                target="_blank"
                                class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600"
                                >Download Set1</a>
                                        @else
                                        Yes
                                        @endcan

                                        @if($paper_Allocation->paper_upload->final_submit && !$paper_Allocation->set1_used_event_id)
                                            @can('paper_download')
                                            <form action="{{ url('paper_Allocation/'.$paper_Allocation->id) }}" method="POST" onsubmit="return validateUse1()">
                                                @csrf
                                                @method('PUT')
                                                <!--set1_used_event_id input-->
                                                    <select data-te-select-init data-te-select-filter="true"
                                                    class="@error('set1_used_event_id') is-invalid @enderror peer inline-block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                                    id="set1_used_event_id"
                                                    name="set1_used_event_id"
                                                    >
                                                    <option value="" hidden selected></option>
                                                    @foreach($events as $event)
                                                        <option value="{{$event->id}}">{{$event->name}}</option>

                                                    @endforeach
                                                    </select>
                                                    <button
                                                    class="inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]"
                                                    data-te-ripple-init
                                                    data-te-ripple-color="light"
                                                    
                                                    type="submit" class="inline-block">Use In</button>
                                            </form>
                                            @endcan
                                        @else
                                            | Used
                                        @endif

                                        @else
                                        Uploaded
                                        @endif
                                    
                                    @else

                                    N/A

                                    @endif                                                
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if($paper_Allocation->paper_upload && $paper_Allocation->paper_upload->set2_uploaded)

                                        @if($paper_Allocation->paper_upload->final_submit)
                                        @can('paper_download')
                                        <a 
                                href="{{ asset($paper_Allocation->paper_upload->set2_file)}}" 
                                target="_blank"
                                class="text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600"
                                >Download Set2</a>
                                        @else
                                        Yes
                                        @endcan

                                            @if($paper_Allocation->paper_upload->final_submit && !$paper_Allocation->set2_used_event_id)
                                            @can('paper_download')
                                            <form action="{{ url('paper_Allocation/'.$paper_Allocation->id) }}" method="POST" onsubmit="return validateUse2()">
                                                @csrf
                                                @method('PUT')
                                                <!--set2_used_event_id input-->
                                                    <select data-te-select-init data-te-select-filter="true"
                                                    class="@error('set2_used_event_id') is-invalid @enderror peer inline-block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                                    id="set2_used_event_id"
                                                    name="set2_used_event_id"
                                                    >
                                                    <option value="" hidden selected></option>
                                                    @foreach($events as $event)
                                                        <option value="{{$event->id}}">{{$event->name}}</option>

                                                    @endforeach
                                                    </select>
                                                    <button
                                                    class="inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]"
                                                    data-te-ripple-init
                                                    data-te-ripple-color="light"
                                                    
                                                    type="submit" class="inline-block">Use In</button>
                                            </form>
                                            @endcan
                                            @else
                                            | Used
                                            @endif



                                        @else
                                        Uploaded
                                        @endif
                                    
                                    @else

                                    N/A

                                    @endif                                                
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper_Allocation->paper_upload && $paper_Allocation->paper_upload->final_submit ? 'Yes':'No'}}</td>
                                <td class="whitespace-nowrap px-6 py-4">

                                @if($paper_Allocation->paper_upload && $paper_Allocation->paper_upload->set1_uploaded || $paper_Allocation->paper_upload && $paper_Allocation->paper_upload->set2_uploaded)

                                    
                                @else
                                    @can('paper_Allocation-edit')
                                    <a href="{{ url('paper_Allocation/'.$paper_Allocation->id.'/edit') }}" class="inline-block float-left"><i class="fa-solid fa-pen-to-square px-4"></i></a> 
                                    @endcan

                                    @can('paper_Allocation-delete')

                                    <form action="{{url('paper_Allocation/'.$paper_Allocation->id)}}" method="POST" onsubmit="return validateDelete()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-block"><i class="fa-solid fa-trash px-4"></i></button>
                                    </form>
                                    
                                    @endcan
                                @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>   
                        
                    </table>
                    

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#view_table').DataTable( {
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            } );
        } );

        function validateDelete() {
            
            var result = confirm("Do you want to Delete?");
            if (result) {
            return true;
            }
            else {
            return false;
            }
            
        }

        function validateUse1() {

            if(!$('#set1_used_event_id').val()){
                alert("Kindly select Event");
                return false;
            }
            var set1SelectedValue = $('#set1_used_event_id').val();
            // var set1SelectedName = $('#set1_used_event_id').attr('name');    
            var result = confirm("Do you want to use Set1 for selected Event, As it can't be reversed.");
            if (result) {
            return true;
            }
            else {
            return false;
            }
            
        }
        function validateUse2() {

            if(!$('#set2_used_event_id').val()){
                alert("Kindly select Event");
                return false;
            }
            var set2SelectedValue = $('#set2_used_event_id').val();
            // var set2SelectedName = $('#set2_used_event_id').attr('name');    
            var result = confirm("Do you want to use Set2 for selected Even1, As it can't be reversed.");
            if (result) {
            return true;
            }
            else {
            return false;
            }
            
        }
    </script>

</x-app-layout>
