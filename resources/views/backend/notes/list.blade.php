@php
    use Carbon\Carbon;
@endphp
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
                @foreach ($notes as $note)
                    <tr class="align-middle">
                        <td>{{$loop->iteration}}</td>
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
                                <li><a class="dropdown-item" href="javascript::void(0)" onclick="changeStatus('{{Crypt::encrypt($note->id)}}','{{$note->type}}')">Close</a></li>
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
                @foreach ($notes as $note)
                    <tr class="align-middle">
                        <td>{{$loop->iteration}}</td>
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
                                <li><a class="dropdown-item" href="javascript::void(0)" onclick="changeStatus('{{Crypt::encrypt($note->id)}}')">Close</a></li>
                                <li><a class="dropdown-item" href="javascript::void(0)" onclick="deleteNote('{{Crypt::encrypt($note->id)}}')">Delete</a></li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
  </div>