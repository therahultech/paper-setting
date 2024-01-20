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
    <pre>
</pre>
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
                            href="{{url('paper/create')}}"
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
                                <th scope="col" class="px-6 py-4">Status</th>
                                <th scope="col" class="px-6 py-4">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($papers as $tkey=>$paper)
                            <tr class="border-b dark:border-neutral-500">
                                <td class="whitespace-nowrap px-6 py-4 font-medium">{{$tkey+1}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper->course->code.'-'.$paper->course->name}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper->session->name}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper->event->name}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper->semester->id?'Sem-'.$paper->semester->name:'Year'.$paper->year->name}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper->subject->code.'-'.$paper->subject->name}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper->exam_paper_id}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$paper->status==1?'Active':'Inactive'}}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @can('paper-edit')
                                    <a href="{{ url('paper/'.$paper->id.'/edit') }}" class="inline-block float-left"><i class="fa-solid fa-pen-to-square px-4"></i></a> 
                                    @endcan

                                    @can('paper-delete')

                                    <form action="{{url('paper/'.$paper->id)}}" method="POST" onsubmit="return validateDelete()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-block"><i class="fa-solid fa-trash px-4"></i></button>
                                    </form>
                                    
                                    @endcan
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
    </script>

</x-app-layout>
