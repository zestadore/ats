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
                        <h5 class="modal-title">Notes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div style="text-align:right;" id="toggleDiv"><i class='fas fa-plus-square' style='font-size:24px;color:green;'></i></div>
                        <div id="hiddenDiv">
                            <div class="row">
                                <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                                    <x-forms.input class="form-control {{ $errors->has('note_title') ? ' is-invalid' : '' }}" title="Title" name="note_title" id="note_title" type="text" required="False"/>
                                </div>
                                <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                                    <label for="note_choice">Type</label>
                                    <select name="note_choice" id="note_choice" class="form-select">
                                        <option value="0">Note</option>
                                        <option value="1">Todo</option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-lg-2 col-sm-12 col-xs-12" style="text-align:right;">
                                    <label for="note_color">Color</label><br>
                                    <input type="color" id="note_color" name="note_color" value="#FFFFFF"><br><br>
                                </div>
                            </div>
                            <x-forms.input class="form-control summernote {{ $errors->has('note_description') ? ' is-invalid' : '' }}" title="Description" name="note_description" id="note_description" type="textarea" required="False"/>
                            <div style="text-align: right;">
                                <button type="button" class="btn btn-primary" id="saveNotes">Save</button>
                            </div>
                        </div>
                        <p> </p>
                        <div id="view-notes-modal-body"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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