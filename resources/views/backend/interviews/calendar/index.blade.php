@extends('layouts.app')
@section('styles')
    <!-- Full Calendar-->
    <link rel="stylesheet" href="{{asset('assets/vendor/fullcalendar/main.min.css')}}">
@endsection
@section('title')
    ATS - Calendar
@endsection
@section('contents')
    <div class="container-fluid px-lg-4 px-xl-5">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Calendar</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fas fa-home"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Calendar</li>
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
            <div class="card">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleLargeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Interview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="view-modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascripts')
    <!-- Full Calendar-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js">   </script>
    <script src="{{asset('assets/vendor/fullcalendar/main.min.js')}}">   </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
        // how to integrate Google Calendar: https://fullcalendar.io/docs/google_calendar/
        var eventArray=@json($events, JSON_PRETTY_PRINT);
        // console.warn(events,"events");
        var todayDate = moment().startOf("day");
        var YM = todayDate.format("YYYY-MM");
        var YESTERDAY = todayDate.clone().subtract(1, "day").format("YYYY-MM-DD");
        var TODAY = todayDate.format("YYYY-MM-DD");
        var TOMORROW = todayDate.clone().add(1, "day").format("YYYY-MM-DD");

        var calendarEl = document.getElementById("calendar");
        var events=[];
        for (var i = 0; i < eventArray.length; i++) {
            events.push({
                title: eventArray[i].title,
                start: eventArray[i].start,
                end: eventArray[i].end,
                id:eventArray[i].id,
            })
        } 
        var calendarOptions = {
            header: {
                left: "prev,next today dayGridMonth",
                center: "title",
                right: "month,agendaWeek,agendaDay,listWeek",
            },
            editable: true,
            dayMaxEvents: true, // allow "more" link when too many events
            navLinks: true,
            themeSystem: "standard",
            bootstrapGlyphicons: false,
            initialView: "dayGridMonth",
            selectable: true,
            events: events,
            dateClick: function(info) {
                swal({
                    title: 'Hi!',
                    text: "Do you want to schedule an interview?",
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    if (result) {
                        localStorage.setItem("interview_date", info.dateStr);
                        window.location.href="{{route('admin.interviews.create')}}";
                    }
                })
            },
            eventClick: function(info) {
                info.jsEvent.preventDefault(); // don't let the browser navigate

                if (info.event.id) {
                    viewModal(info.event.id);
                }
            }
        };

        var calendar = new FullCalendar.Calendar(calendarEl, calendarOptions);
        calendar.render();
    });

    function viewModal(id){
            var url="{{route('admin.interviews.show','ID')}}";
            url=url.replace('ID',id);
            $.ajax({
                url: url,
                type:"get",
                success:function(response){
                    console.log(response);
                    if(response.success==true){
                        var atts=response.data.additional_attachments;
                        var html2="";
                        if(atts.length>0){
                            $.each(atts, function( index, value ) {
                                html2+="<tr>";
                                html2+="<td>Additinal Attachment</td>";
                                html2+="<td><a target='_blank' href='"+value.attachment_path+"'>View</a></td>";
                                html2+="</tr>";
                            });
                        }
                        var html="<table class='table table-striped table-bordered'>";
                        html+="<tr>";
                        html+="<td>Interview Name</td>";
                        var interview_name=response.data.interview_name?response.data.interview_name:"-";
                        html+="<td>"+interview_name+"</td>";
                        html+="</tr>";  
                        html+="<tr>";
                        html+="<td>Candidate</td>";
                        var candidate_name=response.data.candidate.candidate_name?response.data.candidate.candidate_name:"-";
                        html+="<td>"+candidate_name+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Client</td>";
                        var client_name=response.data.client.client_name?response.data.client.client_name:"-";
                        html+="<td>"+client_name+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Interview Owner</td>";
                        var interview_owner=response.data.interview_owners.full_name?response.data.interview_owners.full_name:"-";
                        html+="<td>"+interview_owner+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Interviewer's Name</td>";
                        var interviewer_name=response.data.interviewers_names?response.data.interviewers_names:"-";
                        html+="<td>"+interviewer_name+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>From Date</td>";
                        var from_date=response.data.from_date?response.data.from_date:"-";
                        html+="<td>"+from_date+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>To Date</td>";
                        var to_date=response.data.to_date?response.data.to_date:"-";
                        html+="<td>"+to_date+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Location</td>";
                        var location=response.data.location?response.data.location:"-";
                        html+="<td>"+location+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Time zone</td>";
                        var time_zone=response.data.time_zone?response.data.time_zone:"-";
                        html+="<td>"+time_zone+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Comments</td>";
                        var comments=response.data.comments?response.data.comments:"-";
                        html+="<td>"+comments+"</td>";
                        html+="</tr>";
                        html+="<tr>";
                        html+="<td>Assestement Name</td>";
                        var assesment_name=response.data.assesment_name?response.data.assesment_name:"-";
                        html+="<td>"+assesment_name+"</td>";
                        html+="</tr>";
                        html+=html2;
                        html+="</table>";
                        html=html+"</html>";
                        $('#view-modal-body').html(html);
                        $('#exampleLargeModal').modal('show');
                    }else{
                        swal("Oops!", "Failed to fetch the data!", "error");
                    }
                },
            });
        }

    </script>
@endsection