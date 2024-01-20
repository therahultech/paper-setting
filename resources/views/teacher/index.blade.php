<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher') }}
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
                            href="{{url('teacher/create')}}"
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
                                <th scope="col" class="px-6 py-4">Department</th>
                                <th scope="col" class="px-6 py-4">Emp Code</th>
                                <th scope="col" class="px-6 py-4">Name</th>
                                <th scope="col" class="px-6 py-4">Email</th>
                                <th scope="col" class="px-6 py-4">Mobile</th>
                                <th scope="col" class="px-6 py-4">Address</th>
                                <th scope="col" class="px-6 py-4">City</th>
                                <th scope="col" class="px-6 py-4">Status</th>
                                <th scope="col" class="px-6 py-4">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $tkey=>$teacher)
                            <tr class="border-b dark:border-neutral-500">
                                <td class="whitespace-nowrap px-6 py-4 font-medium">{{$tkey+1}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$teacher->department->name}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$teacher->emp_code}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$teacher->name_prefix." ".$teacher->name}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$teacher->email}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$teacher->mobile1.$teacher->mobile2?','.$teacher->mobile2:''}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$teacher->addr1.','.$teacher->addr2}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$teacher->city->city_name}}</td>
                                <td class="whitespace-nowrap px-6 py-4">{{$teacher->status==1?'Active':'Inactive'}}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @can('teacher-edit')
                                    <a href="{{ url('teacher/'.$teacher->id.'/edit') }}" class="inline-block float-left"><i class="fa-solid fa-pen-to-square px-4"></i></a> 
                                    @endcan

                                    @can('teacher-delete')

                                    <form action="{{url('teacher/'.$teacher->id)}}" method="POST" onsubmit="return validateDelete()">
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
