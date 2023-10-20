@php
    use Carbon\Carbon;
@endphp
@extends('layouts.parent')
@section('title_head')
    Invoice
@endsection
@section('content')
    <div class="section-authentication-cover">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <div id="invoice">
                        <div class="toolbar hidden-print">
                            <div class="text-end">
                                <button type="button" class="btn btn-dark" onclick="printDiv()"><i class="fa fa-print"></i> Print</button>
                                <a href="{{route('download-invoice',Crypt::encrypt($data->id))}}" class="btn btn-danger" ><i class="fa fa-file-pdf-o"></i> Export as PDF</a>
                            </div>
                            <hr/>
                        </div>
                        <div class="invoice overflow-auto" id="printable">
                            <div style="min-width: 600px">
                                <header>
                                    <div class="row">
                                        <div class="col">
                                            <div class="text-gray-light">INVOICE FROM:</div>
                                            <h5 class="name">
                                                <a target="_blank" href="javascript:;" style="color:black !important;">
                                                    American Nexus Trading Inc.
                                                </a>
                                            </h5>
                                            <div>6400 N Cicero Avenue, </div>
                                            <div>Lincolnwood, IL – 60712</div>
                                        </div>
                                        <div class="col company-details" style="text-align: right;">
                                            <div class="text-gray-light">INVOICE TO:</div>
                                            <h5 class="name">
                                                <a target="_blank" href="javascript:;" style="color:black !important;">
                                                    {{$data->client?->client_name}}
                                                </a>
                                            </h5>
                                            <div>{{$data->client?->poc}}, {{$data->client?->region}}</div>
                                            <div>{{$data->client?->contact}}</div>
                                            <div>{{$data->client?->email}}</div>
                                        </div>
                                    </div>
                                </header>
                                <br><hr>
                                <main>
                                    <div class="row contacts">
                                        <div class="col invoice-to">
                                            <div class="text-gray-light">FOR CANDIDATE:</div>
                                            <h5 class="to"><a target="_blank" href="javascript:;" style="color:black !important;">{{$data->candidate?->candidate_name}}</a></h5>
                                        </div>
                                        <div class="col invoice-details" style="text-align: right;">
                                            <h5 class="invoice-id"><a target="_blank" href="javascript:;" style="color:black !important;">INVOICE #INV{{$data->invoice_no}}</a></h5>
                                            <div class="date">Date of Invoice: {{Carbon::parse($data->invoice_date)->format('d/m/Y')}}</div>
                                            <div class="date">Due Date: {{Carbon::parse($data->due_date)->format('d/m/Y')}}</div>
                                        </div>
                                    </div><br><hr>
                                    <img src="{{asset('uploads/site_logo/'.env('SITE_LOGO',''))}}" class="watermark" alt="User Image">
                                    <table style="width: 100%;" class="table table-striped table-bordered">
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
                                                        <a href="javascript:;" style="color:black !important;">
                                                            {{Carbon::parse($item->from_date)->format('d-M-Y')}} till {{Carbon::parse($item->to_date)->format('d-M-Y')}}
                                                        </a>
                                                    </td>
                                                    <td class="unit">$ {{$item->amount}}</td>
                                                    <td class="total">$ {{$item->total_amount}}</td>
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
                                                <td>$ {{$gTotal}}</td>
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
@endsection
@section('javascripts')
    <script>

        function printDiv(){
            var printContents = document.getElementById('printable').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }

    </script>
@endsection