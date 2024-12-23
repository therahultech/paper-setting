<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Secrecy->View Bill') }}
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
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">



            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                @if(session('status'))
                    <div
                    class="mb-4 rounded-lg bg-success px-6 py-5 text-base text-white-600"
                    role="alert">
                    {{session('status')}}
                    </div>
                @endif
                @if(session('error'))
                    <div
                    class="mb-4 rounded-lg bg-danger-100 px-6 py-5 text-base text-primary-600"
                    role="alert">
                    {{session('error')}}
                    </div>
                @endif


                <div class="p-6 col-span-12 md:col-span-12 xl:col-span-12 ">
                                <a
                                    type="button"
                                    href="{{ url()->previous() }}"
                                    data-te-ripple-init
                                    data-te-ripple-color="light"
                                    class="float-right bg-primary rounded px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white transition duration-150 ease-in-out hover:bg-primary-100 hover:text-white-600 focus:text-white-600 focus:outline-none focus:ring-0 active:text-white-700 dark:hover:bg-primary-700">
                                    <i class="fa-solid fa-arrow-left"></i>&nbsp; Go Back
                                </a>
                </div>

                <!-- BILL START -->
                <div class="container mx-auto py-8" id="bill_body">
                    <div class="text-center mb-8">
                        <h1 class="text-3xl font-bold text-gray-800">Exam Paper Remuneration Bill</h1>
                        <h3 class="font-bold text-gray-800">(Auto Generated using Online Paper Setting Software)</h3>
                    </div>

                    <div class="bg-white shadow-md rounded-lg p-6">
                       
                        <div class="border-b border-gray-200 py-4 space-y-6">

                            <!-- Paper Details Section -->
                            <div>
                                <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Paper Details</h2>
                                <div class="grid grid-cols-2 gap-6 mt-4">
                                    <p><span class="font-bold">Course:</span> {{ $remunerationBill->paper->course->code . ' - ' . $remunerationBill->paper->course->name }}</p>
                                    <p><span class="font-bold">Session:</span> {{ $remunerationBill->paper->session->name }}</p>
                                    <p><span class="font-bold">Event:</span> {{ $remunerationBill->paper->event->name }}</p>
                                    <p><span class="font-bold">Semester/Year:</span> 
                                        {{ $remunerationBill->paper->semester->id ? 'Sem-' . $remunerationBill->paper->semester->name : 'Year-' . $remunerationBill->year->name }}
                                    </p>
                                    <p><span class="font-bold">Subject:</span> {{ $remunerationBill->paper->subject->code . ' - ' . $remunerationBill->paper->subject->name }}</p>
                                    <p><span class="font-bold">Exam Paper ID:</span> {{ $remunerationBill->paper->exam_paper_id }}</p>
                                </div>
                            </div>

                            <!-- Teacher's Details Section -->
                            <div>
                                <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Teacher's Details</h2>
                                <div class="grid grid-cols-2 gap-6 mt-4">
                                    <p><span class="font-bold">Name:</span> {{ $remunerationBill->teacher->name_prefix . ' ' . $remunerationBill->teacher->name }}</p>
                                    <p><span class="font-bold">Dept. Name:</span> {{ $remunerationBill->teacher->department->name }}</p>
                                    <p><span class="font-bold">Email:</span> {{ $remunerationBill->teacher->email }}</p>
                                    <p><span class="font-bold">Mobile:</span> {{ $remunerationBill->teacher->mobile1 . ', ' . $remunerationBill->teacher->mobile2 }}</p>
                                    <p><span class="font-bold">Address:</span> {{ $remunerationBill->teacher->addr1 . ', ' . $remunerationBill->teacher->addr2. ', ' . $remunerationBill->teacher->city->city_name. ', ' . $remunerationBill->teacher->pin_code }}</p>
                                </div>
                            </div>

                            <!-- Remuneration Details Section -->
                            <div>
                                <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Remuneration Details</h2>
                                <div class="grid grid-cols-2 gap-6 mt-4">
                                    <p><span class="font-bold">Total Remuneration:</span> {{$remunerationBill->total_rem_amt}}</p>
                                    <p><span class="font-bold">Deduction (TWF):</span> {{$remunerationBill->rem_deduct}}</p>
                                    <p><span class="font-bold">Other Deduction (if any):</span> {{$remunerationBill->other_deduct}}</p>
                                    <p><span class="font-bold">Net Pay:</span> {{$remunerationBill->net_pay_amount}}</p>
                                </div>
                            </div>
                            <!-- Account Details Section -->
                            <div>
                                <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Teacher's Account Details</h2>
                                <div class="grid grid-cols-2 gap-6 mt-4">
                                    <p><span class="font-bold">Account Holder:</span> {{ $remunerationBill->acc_holder_name }}</p>
                                    <p><span class="font-bold">Bank Acc No:</span> {{ $remunerationBill->bank_acc_no }}</p>
                                    <p><span class="font-bold">Bank Name:</span> {{ $remunerationBill->bank_name }}</p>
                                    <p><span class="font-bold">Branch Name:</span> {{ $remunerationBill->bank_branch_name }}</p>
                                    <p><span class="font-bold">Bank IFSC:</span> {{ $remunerationBill->bank_ifsc }}</p>
                                    <p><span class="font-bold">Bank Code:</span> {{ $remunerationBill->bank_code }}</p>
                                </div>
                            </div>
                            <!-- Status Details Section -->
                             @if($remunerationBill->submitted_to_secy)
                            <div>
                                <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Bill Status Details</h2>
                                <div class="grid grid-cols-2 gap-6 mt-4">
                                    <p><span class="font-bold">Submitted To Secrecy Branch:</span> {{ $remunerationBill->submitted_to_secy?'Yes':'No' }}</p>
                                    <p><span class="font-bold">Secrecy Submit Datetime:</span> {{ $remunerationBill->submitted_to_secy_datetime }}</p>
                                    <p><span class="font-bold">Secrecy Branch Remarks:</span> {{ $remunerationBill->secy_remarks }}</p>

                                    <p><span class="font-bold">Submitted To Account Branch:</span> {{ $remunerationBill->submitted_to_acc?'Yes':'No' }}</p>
                                    <p><span class="font-bold">Account Submit Datetime:</span> {{ $remunerationBill->submitted_to_acc_datetime }}</p>
                                    <p><span class="font-bold">Account Branch Remarks:</span> {{ $remunerationBill->acc_remarks }}</p>
                        
                                    <p><span class="font-bold">Submitted To Audit Branch:</span> {{ $remunerationBill->submitted_to_audit?'Yes':'No' }}</p>
                                    <p><span class="font-bold">Audit Submit Datetime:</span> {{ $remunerationBill->submitted_to_audit_datetime }}</p>
                                    <p><span class="font-bold">Audit Branch Remarks:</span> {{ $remunerationBill->audit_remarks }}</p>

                                    <p><span class="font-bold">Bill Paid:</span> {{ $remunerationBill->bill_paid?'Yes':'No' }}</p>
                                    <p><span class="font-bold">Bill Paid Date:</span> {{ $remunerationBill->bill_paid_date }}</p>

                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    
                </div>

                <!-- Print Button -->
                <div class="text-center mt-8 no-print">
                    <button onclick="printBill()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Print
                    </button>
                </div>

                @if(!$remunerationBill->submitted_to_acc)
                <form method="post" action="{{ url('paper/billUpdateOtherDeduct') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{$remunerationBill->id}}">

                    <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 mb-6">
                        <!-- Input Field -->
                        <div class="w-full sm:w-auto">
                            <label for="other_deduct" class="block text-gray-700 font-medium mb-1">Other Deduction (if any)</label>
                            <input
                                type="number"
                                class="peer block w-full sm:w-auto sm:max-w-xs rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:text-neutral-200 dark:bg-gray-700"
                                id="other_deduct"
                                name="other_deduct"
                                placeholder="Enter deduction amount"
                                value="{{$remunerationBill->other_deduct}}"
                            />
                            @error('other_deduct')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Button -->
                        <div>
                            <button
                                onclick="billUpdateOtherDeduct()"
                                type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-sm"
                            >
                                Update Other Deduction
                            </button>
                        </div>
                    </div>
                </form>
                @endif

                @if(!$remunerationBill->submitted_to_acc)
                <form method="post" action="{{ url('paper/billSubmitToAcc') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{$remunerationBill->id}}">

                    <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4 mb-6">
                        <!-- Input Field -->
                        <div class="w-full sm:w-auto">
                            <label for="secy_remarks" class="block text-gray-700 font-medium mb-1">Remarks By Secrecy Branch (if any)</label>
                            <input
                                type="text"
                                class="peer block w-full sm:w-auto sm:max-w-xs rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:text-neutral-200 dark:bg-gray-700"
                                id="secy_remarks"
                                name="secy_remarks"
                                placeholder="Remarks By Secrecy Branch"
                                value="{{$remunerationBill->secy_remarks}}"
                            />
                            @error('secy_remarks')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Button -->
                        <div>
                            <button
                                onclick="validateAccSubmit()"
                                type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-sm"
                            >
                            Submit to Account Branch
                            </button>
                        </div>
                    </div>
                </form>
                @endif


                    <script>
                        function printBill() {
                            const billContent = document.getElementById('bill_body').innerHTML;

                            const stylesheets = Array.from(document.querySelectorAll('link[rel="stylesheet"], style')).map(
                                (style) => style.outerHTML
                            ).join('');

                            const printWindow = window.open('', '_blank');
                            printWindow.document.open();
                            printWindow.document.write(`
                                <!DOCTYPE html>
                                <html>
                                <head>
                                    <title>Print Bill</title>
                                    ${stylesheets}
                                    <style>
                                        @media print {
                                            body {
                                                margin: 0;
                                                padding: 0.25in;
                                                font-size: 12px;
                                            }
                                        }
                                    </style>
                                </head>
                                <body>
                                    <div>${billContent}</div>
                                </body>
                                </html>
                            `);
                            printWindow.document.close();
                            printWindow.focus();
                            printWindow.print();
                            printWindow.onafterprint = () => printWindow.close();
                        }
                    </script>

                   <!-- BILL END -->
                    
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

        function validateAccSubmit() {
            
            var result = confirm("Are you sure you want to submit this bill to Account Branch.");
            if (result) {
            return true;
            }
            else {
            return false;
            }
            
        }
        
        function billUpdateOtherDeduct() {
            
            var result = confirm("Are you sure you want to update other deduction to this bill.");
            if (result) {
            return true;
            }
            else {
            return false;
            }
            
        }



</script>