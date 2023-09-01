@php
    use Carbon\Carbon;
@endphp
@extends('layouts.app')
@section('styles')
    <link href="{{asset('assets/css/datatable/css/dataTables.bootstrap5.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        .select2-container .select2-choice:not(.select2-default) {
            background-image: none !important;
            background-color: #f9860b;
        }

        /* @media print
        {
            #non-printable { display: none; }
            #printable { display: block; }
        } */
    </style>
@endsection
@section('title')
    ATS - View Invoice
@endsection
@section('contents')
    <div class="container-fluid px-lg-4 px-xl-5">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3" id="non-printable">
                <div class="breadcrumb-title pe-3">Invoices</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('admin.invoices.index')}}">Invoices</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">View Invoice</li>
                        </ol>
                    </nav>
                </div>
            </div>
            @if (session('error'))
                <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                    <div class="text-white">{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-primary border-0 bg-primary alert-dismissible fade show">
                    <div class="text-white">{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="bs-stepper">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4">View Invoice</h5>
                        <div class="card">
                            <div class="card-body">
                                <div id="invoice">
                                    <div class="toolbar hidden-print">
                                        <div class="text-end">
                                            <button type="button" class="btn btn-dark" onclick="printDiv()"><i class="fa fa-print"></i> Print</button>
                                            <button type="button" class="btn btn-danger" id="mailModalButton"><i class="fa fa-file-pdf-o"></i> Mail Invoice</button>
                                        </div>
                                        <hr/>
                                    </div>
                                    <div class="invoice overflow-auto" id="printable">
                                        <div style="min-width: 600px">
                                            <header>
                                                <div class="row">
                                                    <div class="col">
                                                        <a href="javascript:;">
                                                            <img src="{{asset('uploads/logos/'.$company->logo)}}" width="80" alt="" />
                                                        </a>
                                                    </div>
                                                    <div class="col company-details">
                                                        <div class="text-gray-light">INVOICE TO:</div>
                                                        <h2 class="name">
                                                            <a target="_blank" href="javascript:;">
                                                                {{$data->client?->client_name}}
                                                            </a>
                                                        </h2>
                                                        <div>{{$data->client?->poc}}, {{$data->client?->region}}</div>
                                                        <div>{{$data->client?->contact}}</div>
                                                        <div>{{$data->client?->email}}</div>
                                                    </div>
                                                </div>
                                            </header>
                                            <main>
                                                <div class="row contacts">
                                                    <div class="col invoice-to">
                                                        <div class="text-gray-light">FOR CANDIDATE:</div>
                                                        <h2 class="to">{{$data->candidate?->candidate_name}}</h2>
                                                    </div>
                                                    <div class="col invoice-details">
                                                        <h1 class="invoice-id">INVOICE #INV{{$data->invoice_no}}</h1>
                                                        <div class="date">Date of Invoice: {{Carbon::parse($data->invoice_date)->format('d/m/Y')}}</div>
                                                        <div class="date">Due Date: {{Carbon::parse($data->due_date)->format('d/m/Y')}}</div>
                                                    </div>
                                                </div>
                                                <table style="width: 100%;">
                                                    <thead>
                                                        <tr>
                                                            <th>Hours</th>
                                                            <th class="text-left">Dates</th>
                                                            <th class="text-right">Rate</th>
                                                            <th class="text-right">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $gTotal = 0
                                                        @endphp
                                                        @foreach ($data->invoiceDetails as $item)
                                                            <tr>
                                                                <td class="no">{{$item->hours}}</td>
                                                                <td>
                                                                    <a href="javascript:;">
                                                                        {{Carbon::parse($item->date)->format('d-M-Y')}} till {{Carbon::parse($item->to_date)->format('d-M-Y')}}
                                                                    </a>
                                                                </td>
                                                                <td class="unit">{{$item->amount}}</td>
                                                                <td class="total">{{$item->total_amount}}</td>
                                                            </tr>
                                                            @php
                                                                $gTotal += $item->total_amount;
                                                            @endphp
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2"></td>
                                                            <td colspan="1">GRAND TOTAL</td>
                                                            <td>{{$gTotal}}</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                {{-- <div class="notices">
                                                    <div>NOTICE:</div>
                                                    <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
                                                </div> --}}
                                            </main>
                                            <footer>Invoice was created on a computer and is valid without the signature and seal.</footer>
                                        </div>
                                        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="emailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mail Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <x-forms.input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" title="Email" name="email" id="email" type="email" required="True"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info" id="mailInvoiceButton">Email</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascripts')
    <script src="{{asset('assets/plugins/validation/jquery.validate.min.js')}}"></script>
    {{-- <script src="{{asset('assets/plugins/validation/validation-script.js')}}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>

        function printDiv(){
            var printContents = document.getElementById('printable').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }

        $('#mailModalButton').click(function(){
            $('#emailModal').modal('show');
        });

        $('#mailInvoiceButton').click(function(){
            var email=$('#email').val();
            var id='{{Crypt::encrypt($data->id)}}';
            var url="{{route('admin.mail-invoice',['ID','EMAIL'])}}";
            url=url.replace('ID',id);
            url=url.replace('EMAIL',email);
            $.ajax({
                url: url,
                type:"get",
                success:function(response){
                    if(response.success){
                        swal("Good job!", "Mail forwarded successfully!", "success");
                        $('#emailModal').modal('hide');
                    }
                }
            });
        });
        
    </script>
@endsection