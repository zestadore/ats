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
        <!-- Modal -->
        <div class="modal fade" id="notesModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="notesTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- <div style="text-align:right;" id="toggleDiv"><i class='fas fa-plus-square' style='font-size:24px;color:green;'></i></div> --}}
                        <div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <input type="hidden" name="note_choice" id="note_choice" value="0">
                                    <x-forms.input class="form-control {{ $errors->has('note_title') ? ' is-invalid' : '' }}" title="Title" name="note_title" id="note_title" type="text" required="False"/>
                                </div>
                                @php
                                    $relatedUsers=getRelatedUsers();
                                @endphp
                                <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                    <div class="form-floating mb-3 assigned_to">
                                        <select name="assigned_to" id="assigned_to" class="form-select">
                                            <option value="">Select User</option>
                                            @foreach($relatedUsers as $user)
                                                <option value="{{$user->id}}">{{$user->full_name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="assigned_to" class="form-label">Type</label>
                                    </div>
                                </div>
                            </div>
                            <x-forms.input class="form-control summernote {{ $errors->has('note_description') ? ' is-invalid' : '' }}" title=" " name="note_description" id="note_description" type="textarea" required="False"/>
                            {{-- <div style="text-align: right;">
                                <button type="button" class="btn blue-button" id="saveNotes" data-id="0">Save</button>
                            </div> --}}
                        </div>
                        <p> </p>
                        <div id="view-notes-modal-body"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn cancel-button" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn blue-button" id="saveNotes" data-id="0">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-holder bg-gray-100">
            @yield('contents')
            <br>
            <div style="padding : 10px;">

            </div>
            <footer class="footer bg-white shadow align-self-end py-3 px-xl-5 w-100">
                <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start fw-bold">
                    <p class="mb-2 mb-md-0 fw-bold">{{env('APP_FOOTER','')}}</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end text-gray-400">
                    {{-- <p class="mb-0">Version 1.3.2</p> --}}
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