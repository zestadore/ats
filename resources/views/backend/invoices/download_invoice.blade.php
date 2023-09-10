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
                        <div class="invoice overflow-auto" id="printable">
                            <div style="min-width: 600px">
                                <header>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="text-gray-light">INVOICE FROM:</div>
                                            <h5 class="name">
                                                <a target="_blank" href="javascript:;">
                                                    American Nexus Trading Inc.
                                                </a>
                                            </h5>
                                            <div>6400 N Cicero Avenue, </div>
                                            <div>Lincolnwood, IL – 60712</div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 company-details" style="text-align: right;">
                                            <div class="text-gray-light">INVOICE TO:</div>
                                            <h5 class="name">
                                                <a target="_blank" href="javascript:;">
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
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 invoice-to">
                                            <div class="text-gray-light">FOR CANDIDATE:</div>
                                            <h4 class="to"><a target="_blank" href="javascript:;">{{$data->candidate?->candidate_name}}</a></h4>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 invoice-details" style="text-align: right;">
                                            <h4 class="invoice-id"><a target="_blank" href="javascript:;">INVOICE #INV{{$data->invoice_no}}</a></h4>
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
                                                        <a href="javascript:;">
                                                            {{Carbon::parse($item->date)->format('d-M-Y')}} till {{Carbon::parse($item->to_date)->format('d-M-Y')}}
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
        document.body.style.backgroundColor = "white";
    </script>
@endsection