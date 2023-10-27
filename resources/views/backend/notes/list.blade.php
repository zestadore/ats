@php
    use Carbon\Carbon;
@endphp
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <h4>Pending {{$type==0?'Notes':'ToDos'}}</h4>
        <div class="table-responsive">
            @if ($type==0)
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Created date</th>
                        <th>Title</th>
                        <th>Descrription</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingNotes as $note)
                            <tr class="align-middle">
                                <td>
                                    {{$loop->iteration}}&nbsp;
                                    <input type="checkbox" name="changeStatus" class="form-check-input changeStatus" onchange="changeStatus('{{Crypt::encrypt($note->id)}}','{{$note->status}}')">
                                </td>
                                <td>{{Carbon::parse($note->created_at)->format('d-M-Y')}}</td>
                                <td>{{$note?->title}}</td>
                                <td>{!!$note->description!!}</td>
                                <td>
                                    @if ($note->status==0)
                                        <span class="badge badge-warning-light">Pending</span>
                                    @else
                                        <span class="badge badge-success-light">Closed</span>
                                    @endif
                                </td>
                                <td class="text-end" style="min-width: 125px;">
                                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="dropdown" data-boundary="window" aria-expanded="false"><i class="fa fas fa-ellipsis-v"></i></button>
                                    <ul class="dropdown-menu" style="white-space: nowrap !important;">
                                        <li><a class="dropdown-item" href="javascript::void(0)" onclick="editNote('{{Crypt::encrypt($note->id)}}')">Edit</a></li>
                                        {{-- <li><a class="dropdown-item" href="javascript::void(0)" onclick="changeStatus('{{Crypt::encrypt($note->id)}}','{{$note->type}}')">Close</a></li> --}}
                                        <li><a class="dropdown-item" href="javascript::void(0)" onclick="deleteNote('{{Crypt::encrypt($note->id)}}')">Delete</a></li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Created date</th>
                        <th>Assigned to</th>
                        <th>Title</th>
                        <th>Descrription</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($pendingNotes as $note)
                            <tr class="align-middle">
                                <td>
                                    {{$loop->iteration}}&nbsp;
                                    <input type="checkbox" name="changeStatus" class="form-check-input changeStatus" onchange="changeStatus('{{Crypt::encrypt($note->id)}}','{{$note->status}}')">
                                </td>
                                <td>{{Carbon::parse($note->created_at)->format('d-M-Y')}}</td>
                                <td>{{$note->assignedTo?->full_name}}</td>
                                <td>{{$note?->title}}</td>
                                <td>{!!$note->description!!}</td>
                                <td>
                                    @if ($note->status==0)
                                        <span class="badge badge-warning-light">Pending</span>
                                    @else
                                        <span class="badge badge-success-light">Closed</span>
                                    @endif
                                </td>
                                <td class="text-end" style="min-width: 125px;">
                                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="dropdown" data-boundary="window" aria-expanded="false"><i class="fa fas fa-ellipsis-v"></i></button>
                                    <ul class="dropdown-menu" style="white-space: nowrap !important;">
                                        <li><a class="dropdown-item" href="javascript::void(0)" onclick="editNote('{{Crypt::encrypt($note->id)}}')">Edit</a></li>
                                        {{-- <li><a class="dropdown-item" href="javascript::void(0)" onclick="changeStatus('{{Crypt::encrypt($note->id)}}')">Close</a></li> --}}
                                        <li><a class="dropdown-item" href="javascript::void(0)" onclick="deleteNote('{{Crypt::encrypt($note->id)}}')">Delete</a></li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <h4>Finished {{$type==0?'Notes':'ToDos'}}</h4>
        <div class="table-responsive">
            @if ($type==0)
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Created date</th>
                        <th>Title</th>
                        <th>Descrription</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($finishedNotes as $note)
                            <tr class="align-middle">
                                <td>
                                    {{$loop->iteration}}&nbsp;
                                    <input type="checkbox" name="changeStatus" class="form-check-input changeStatus" onchange="changeStatus('{{Crypt::encrypt($note->id)}}','{{$note->status}}')">
                                </td>
                                <td>{{Carbon::parse($note->created_at)->format('d-M-Y')}}</td>
                                <td>{{$note?->title}}</td>
                                <td>{!!$note->description!!}</td>
                                <td>
                                    @if ($note->status==0)
                                        <span class="badge badge-warning-light">Pending</span>
                                    @else
                                        <span class="badge badge-success-light">Closed</span>
                                    @endif
                                </td>
                                <td class="text-end" style="min-width: 125px;">
                                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="dropdown" data-boundary="window" aria-expanded="false"><i class="fa fas fa-ellipsis-v"></i></button>
                                    <ul class="dropdown-menu" style="white-space: nowrap !important;">
                                        <li><a class="dropdown-item" href="javascript::void(0)" onclick="editNote('{{Crypt::encrypt($note->id)}}')">Edit</a></li>
                                        {{-- <li><a class="dropdown-item" href="javascript::void(0)" onclick="changeStatus('{{Crypt::encrypt($note->id)}}','{{$note->type}}')">Close</a></li> --}}
                                        <li><a class="dropdown-item" href="javascript::void(0)" onclick="deleteNote('{{Crypt::encrypt($note->id)}}')">Delete</a></li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Created date</th>
                        <th>Assigned to</th>
                        <th>Title</th>
                        <th>Descrription</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($finishedNotes as $note)
                            <tr class="align-middle">
                                <td>
                                    {{$loop->iteration}}&nbsp;
                                    <input type="checkbox" name="changeStatus" class="form-check-input changeStatus" onchange="changeStatus('{{Crypt::encrypt($note->id)}}','{{$note->status}}')">
                                </td>
                                <td>{{Carbon::parse($note->created_at)->format('d-M-Y')}}</td>
                                <td>{{$note->assignedTo?->full_name}}</td>
                                <td>{{$note?->title}}</td>
                                <td>{!!$note->description!!}</td>
                                <td>
                                    @if ($note->status==0)
                                        <span class="badge badge-warning-light">Pending</span>
                                    @else
                                        <span class="badge badge-success-light">Closed</span>
                                    @endif
                                </td>
                                <td class="text-end" style="min-width: 125px;">
                                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="dropdown" data-boundary="window" aria-expanded="false"><i class="fa fas fa-ellipsis-v"></i></button>
                                    <ul class="dropdown-menu" style="white-space: nowrap !important;">
                                        <li><a class="dropdown-item" href="javascript::void(0)" onclick="editNote('{{Crypt::encrypt($note->id)}}')">Edit</a></li>
                                        {{-- <li><a class="dropdown-item" href="javascript::void(0)" onclick="changeStatus('{{Crypt::encrypt($note->id)}}')">Close</a></li> --}}
                                        <li><a class="dropdown-item" href="javascript::void(0)" onclick="deleteNote('{{Crypt::encrypt($note->id)}}')">Delete</a></li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
