@if ($type=='password')
    <label class="form-label" for="{{$name}}">{{$title}} @if($required=="True")<span style="color:red;"> *</span>@endif</label>
    <input id="{{$id}}" type="{{$type}}" class="{{$class}}" name="{{$name}}" value="{{ old($name) }}" placeholder="{{$title}}" @if($required=="True") required @endif autocomplete="{{$name}}" autofocus>
    @error($name)
        <span class="error mt-2 text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
@elseif($type=='textarea')
    <div class="form-group">
        <label class="form-label" for="{{$name}}">{{$title}} @if($required=="True")<span style="color:red;"> *</span>@endif</label>
        <textarea id="{{$id}}" cols="30" rows="5" class="{{$class}}" name="{{$name}}" value="{{ old($name) }}" placeholder="{{$title}}" @if($required=="True") required @endif autocomplete="{{$name}}" autofocus></textarea>
        @error($name)
            <span class="error mt-2 text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
@elseif($type=='number')
    <label class="form-label" for="{{$name}}">{{$title}} @if($required=="True")<span style="color:red;"> *</span>@endif</label>
    <input id="{{$id}}" type="{{$type}}" class="{{$class}}" name="{{$name}}" value="{{ old($name) }}" placeholder="{{$title}}" @if($required=="True") required @endif autocomplete="{{$name}}" autofocus>
    @error($name)
        <span class="error mt-2 text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
@elseif($type=='file')
    <label class="form-label" for="{{$name}}">{{$title}} @if($required=="True")<span style="color:red;"> *</span>@endif</label>
    <div class="input-group">
        <div class="custom-file">
            <input type="file" class="{{$class}}" id="{{$id}}" name="{{$name}}"  @if($required=="True") required @endif style="width:100% !important;">
        </div>
    </div>
    @error($name)
        <span class="error mt-2 text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
@elseif($type=='date')
    <label class="form-label" for="{{$name}}">{{$title}} @if($required=="True")<span style="color:red;"> *</span>@endif</label>
    <div class="input-group date" id="{{$id}}" data-target-input="nearest">
        <input type="date" class="datetimepicker-input {{$class}}" data-target="#{{$id}}" name="{{$name}}"  @if($required=="True") required @endif>
    </div>
    @error($name)
        <span class="error mt-2 text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
@else
    <label class="form-label" for="{{$name}}">{{$title}} @if($required=="True")<span style="color:red;"> *</span>@endif</label>
    <input id="{{$id}}" type="{{$type}}" class="{{$class}}" name="{{$name}}" value="{{ old($name) }}" placeholder="{{$title}}" @if($required=="True") required @endif autocomplete="{{$name}}" autofocus>
    @error($name)
        <span class="error mt-2 text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
@endif