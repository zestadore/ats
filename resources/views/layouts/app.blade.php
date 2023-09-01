@extends('layouts.parent')
@section('style')
    @yield('styles')
@endsection
@section('title_head')
    @yield('title')
@endsection
@section('content')
    @include('layouts.top_bar')
    <div class="d-flex align-items-stretch">
        @include('layouts.side_bar')
        <div class="page-holder bg-gray-100">
            @yield('contents')
            <footer class="footer bg-white shadow align-self-end py-3 px-xl-5 w-100">
                <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start fw-bold">
                    <p class="mb-2 mb-md-0 fw-bold">{{env('APP_FOOTER','')}} &copy; {{date('Y')}}</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end text-gray-400">
                    <p class="mb-0">Version 1.3.2</p>
                    </div>
                </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
@section('javascripts')
    @yield('javascripts')
@endsection