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