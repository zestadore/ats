@php
    use Carbon\Carbon;
@endphp
@foreach ($notes as $note)
    <a class="message card px-5 py-3 mb-4 bg-hover-gradient-primary text-decoration-none text-reset" href="#" style="background:{{$note->color_code}};">
        <div class="row">
            <div class="col-xl-3 d-flex align-items-center flex-column flex-xl-row text-center text-md-left"><strong class="h5 mb-0">{{Carbon::parse($note->created_at)->format('d-M-Y')}}</strong>
            </div>
            <div class="col-xl-7 d-flex align-items-center flex-column flex-xl-row text-center text-md-left">
                <div class="bg-gray-200 rounded-pill px-4 py-1 me-0 me-xl-3 mt-3 mt-xl-0 text-sm text-dark exclude">{{$note?->title}}</div>
                <p class="mb-0 mt-3 mt-lg-0">{!!$note->description!!}</p>
            </div>
            <div class="col-xl-2 d-flex align-items-center flex-column flex-xl-row text-center text-md-right">
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" onClick="deleteNote('{{Crypt::encrypt($note->id)}}')"><i class="fa fas fa-trash-alt"></i></button>
                <button type="button" class="btn btn-outline-primary" class="btn btn-outline-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="fa far fa-edit"></i></button>
            </div>
        </div>
    </a>
@endforeach