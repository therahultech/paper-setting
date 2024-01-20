<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Paper') }}
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

                    <div class="grid grid-cols-12 gap-4">

                        <!-- Column -->
                        <div class="p-6 col-span-12 md:col-span-12 xl:col-span-12 ">
                            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                                {{ __('Edit') }}
                            </h2>
                                <a
                                    type="button"
                                    href="{{url('paper')}}"
                                    data-te-ripple-init
                                    data-te-ripple-color="light"
                                    class="float-right bg-primary rounded px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white transition duration-150 ease-in-out hover:bg-primary-100 hover:text-white-600 focus:text-white-600 focus:outline-none focus:ring-0 active:text-white-700 dark:hover:bg-primary-700">
                                    <i class="fa-solid fa-arrow-left"></i>&nbsp; Go Back
                                </a>
                        </div>

                        <!-- Column -->
                        <div class="col-span-12 md:col-span-12 xl:col-span-12">
                            <form method="POST" action="{{ url('paper/'.$paper->id) }}" onsubmit="return validateForm()">
                                @csrf
                                @method('PUT')
                                
                                 <!-- start -->
                                <!--course_id input-->
                                <div class="relative mb-6" >

                                    <select data-te-select-init data-te-select-filter="true"
                                    class="@error('course_id') is-invalid @enderror peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                    id="course_id"
                                    name="course_id"
                                    placeholder="Course"
                                    >
                                    <option value="" hidden selected></option>
                                    @foreach($courses as $course)
                                        <option value="{{$course->id}}" {{ $course->id == $paper->course_id ? 'selected':''}}>{{$course->code.'-'.$course->name}}</option>

                                    @endforeach
                                    </select>

                                @error('course_id')
                                <div
                                    class="absolute w-full text-sm text-neutral-500 peer-focus:text-primary dark:text-neutral-200 dark:peer-focus:text-primary"
                                    data-te-input-helper-ref>
                                    {{ $message }}
                                </div>
                                @enderror
                                <label data-te-select-label-ref>Select Course</label>
                                </div>

                                <!--session_id input-->
                                <div class="relative mb-6" >

                                    <select data-te-select-init data-te-select-filter="true"
                                    class="@error('session_id') is-invalid @enderror peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                    id="session_id"
                                    name="session_id"
                                    placeholder="Course"
                                    >
                                    <option value="" hidden selected></option>
                                    @foreach($sessions as $session)
                                        <option value="{{$session->id}}" {{ $session->id == $paper->session_id ? 'selected':''}}>{{$session->name}}</option>

                                    @endforeach
                                    </select>

                                @error('session_id')
                                <div
                                    class="absolute w-full text-sm text-neutral-500 peer-focus:text-primary dark:text-neutral-200 dark:peer-focus:text-primary"
                                    data-te-input-helper-ref>
                                    {{ $message }}
                                </div>
                                @enderror
                                <label data-te-select-label-ref>Select Session</label>
                                </div>

                                <!--event_id input-->
                                <div class="relative mb-6" >

                                    <select data-te-select-init data-te-select-filter="true"
                                    class="@error('event_id') is-invalid @enderror peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                    id="event_id"
                                    name="event_id"
                                    placeholder="Course"
                                    >
                                    <option value="" hidden selected></option>
                                    @foreach($events as $event)
                                        <option value="{{$event->id}}" {{ $event->id == $paper->event_id ? 'selected':''}}>{{$event->name}}</option>

                                    @endforeach
                                    </select>

                                @error('event_id')
                                <div
                                    class="absolute w-full text-sm text-neutral-500 peer-focus:text-primary dark:text-neutral-200 dark:peer-focus:text-primary"
                                    data-te-input-helper-ref>
                                    {{ $message }}
                                </div>
                                @enderror
                                <label data-te-select-label-ref>Select Event</label>
                                </div>

                                <!--semester_id input-->
                                <div class="relative mb-6" id='semesterDiv'>

                                    <select data-te-select-init data-te-select-filter="true"
                                    class="@error('semester_id') is-invalid @enderror peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                    id="semester_id"
                                    name="semester_id"
                                    placeholder="Course"
                                    >
                                    <option value="" hidden selected></option>
                                    @foreach($semesters as $semester)
                                        <option value="{{$semester->id}}" {{ $semester->id == $paper->semester_id ? 'selected':''}}>{{$semester->name}}</option>

                                    @endforeach
                                    </select>

                                @error('semester_id')
                                <div
                                    class="absolute w-full text-sm text-neutral-500 peer-focus:text-primary dark:text-neutral-200 dark:peer-focus:text-primary"
                                    data-te-input-helper-ref>
                                    {{ $message }}
                                </div>
                                @enderror
                                <label data-te-select-label-ref>Select Semester</label>
                                </div>

                                <!--year_id input-->
                                <div class="relative mb-6" id='yearDiv'>

                                    <select data-te-select-init data-te-select-filter="true"
                                    class="@error('year_id') is-invalid @enderror peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                    id="year_id"
                                    name="year_id"
                                    placeholder="Course"
                                    >
                                    <option value="" hidden selected></option>
                                    @foreach($years as $year)
                                        <option value="{{$year->id}}" {{ $year->id == $paper->year_id ? 'selected':''}}>{{$year->name}}</option>

                                    @endforeach
                                    </select>

                                @error('year_id')
                                <div
                                    class="absolute w-full text-sm text-neutral-500 peer-focus:text-primary dark:text-neutral-200 dark:peer-focus:text-primary"
                                    data-te-input-helper-ref>
                                    {{ $message }}
                                </div>
                                @enderror
                                <label data-te-select-label-ref>Select Year</label>
                                </div>

                                <!--subject_id input-->
                                <div class="relative mb-6" >

                                    <select data-te-select-init data-te-select-filter="true"
                                    class="@error('subject_id') is-invalid @enderror peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                    id="subject_id"
                                    name="subject_id"
                                    placeholder="Course"
                                    >
                                    <option value="" hidden selected></option>
                                    @foreach($subjects as $subject)
                                        <option value="{{$subject->id}}" {{ $subject->id == $paper->subject_id ? 'selected':''}}>{{$subject->code.'-'.$subject->name}}</option>

                                    @endforeach
                                    </select>

                                @error('subject_id')
                                <div
                                    class="absolute w-full text-sm text-neutral-500 peer-focus:text-primary dark:text-neutral-200 dark:peer-focus:text-primary"
                                    data-te-input-helper-ref>
                                    {{ $message }}
                                </div>
                                @enderror
                                <label data-te-select-label-ref>Select Subject</label>
                                </div>



                                <div class="relative mb-6" data-te-input-wrapper-init>
                                <input
                                    type="text"
                                    class="@error('exam_paper_id') is-invalid @enderror peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                    id="empcode"
                                    name="exam_paper_id"
                                    placeholder="Exam Paper id" 
                                    value="{{$paper->exam_paper_id}}"
                                    />

                                @error('exam_paper_id')
                                <div
                                    class="absolute w-full text-sm text-neutral-500 peer-focus:text-primary dark:text-neutral-200 dark:peer-focus:text-primary"
                                    data-te-input-helper-ref>
                                    {{ $message }}
                                </div>
                                @enderror
                                <label
                                    for="exam_paper_id"
                                    class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200"
                                    >Exam Paper ID
                                </label>
                                </div>                                   

                                <div
                                class="mb-6 flex min-h-[1.5rem] pl-[1.5rem]">
                                    <input type="hidden" name="status" value="0" />
                                    <input
                                        class="relative float-left -ml-[1.5rem] mr-[6px] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:-mt-px checked:after:ml-[0.25rem] checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-l-0 checked:after:border-t-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:-mt-px checked:focus:after:ml-[0.25rem] checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-l-0 checked:focus:after:border-t-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent dark:border-neutral-600 dark:checked:border-primary dark:checked:bg-primary"
                                        type="checkbox"
                                        value="1"
                                        name="status"
                                        id="status" 
                                        {{$paper->status?'checked':''}}
                                        />
                                    <label
                                        class="inline-block pl-[0.15rem] hover:cursor-pointer"
                                        for="status">
                                        Active
                                    </label>
                                </div>

                                <!--Submit button-->
                                <button
                                type="submit"
                                class="inline-block w-full rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)]"
                                data-te-ripple-init
                                data-te-ripple-color="light">
                                Update
                                </button>

                                <!-- end -->
                                
                            
                            </form>
                        </div>

                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <script>
        function validateForm() {
            
            var result = confirm("Do you want to update?");
            if (result) {
            return true;
            }
            else {
            return false;
            }
            
        }

        function checkCourseAnnual(courseArr,idVal){

        var isAnnual=false;

        $.each(courseArr,(index,item)=>{
            if(item['id']=idVal){
                if(item['is_year_based']==1){
                    isAnnual=true;
                }
                return isAnnual;
            }
        });

        return isAnnual;
        }

        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {

        // fillEventOption($('#session_id').val());
        $('#yearDiv').hide();

        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


        var courses=@json($courses);
        //  console.log(courses);
        $('#course_id').change(function(){
            if(checkCourseAnnual(courses,$(this).val())){
                $('#yearDiv').show();
                $('#semesterDiv').hide();
            }else{
                $('#yearDiv').hide();
                $('#semesterDiv').show();
            }
        });


        // Attach an event listener to the session_id select
        $('#session_id').change(function() {
                    // Get the selected session_id
                    var session_id = $(this).val();
                    fillEventOption(session_id);
                   
                });

        });

        function fillEventOption(session_id){
             // Make an AJAX request to fetch events based on the selected session_id
             $.ajax({
                        url: '/getEventsBySessionId/' + session_id,
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            // Clear existing options in the event_id select
                            $('#event_id').empty();

                            // Add options based on the retrieved events
                            $.each(response.events, function(index, event) {
                                $('#event_id').append('<option value="' + event.id + '">' + event.name + '</option>');
                                // Assuming each event has an "id" and "name" field, adjust accordingly
                            });
                        },
                        error: function(error) {
                            console.error('Error fetching events:', error);
                        }
                    });
        }

       

    </script>
</x-app-layout>
