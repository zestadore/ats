@if ($type=='password')
    <div class="form-floating mb-3">
        <input id="{{$id}}" type="{{$type}}" class="{{$class}}" name="{{$name}}" value="{{ old($name) }}" placeholder="{{$title}}" @if($required=="True") required @endif autocomplete="{{$name}}" autofocus>
        <label for="{{$name}}">{{$title}} @if($required=="True")<span style="color:red;"> *</span>@endif</label>
        
    </div>
    @error($name)
            <span class="error mt-2 text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
@elseif($type=='textarea')
    <div class="form-floating mb-3">
        <textarea id="{{$id}}" cols="30" rows="5" class="{{$class}}" name="{{$name}}" value="{{ old($name) }}" placeholder="{{$title}}" @if($required=="True") required @endif autocomplete="{{$name}}" autofocus></textarea>
        <label for="{{$name}}">{{$title}} @if($required=="True")<span style="color:red;"> *</span>@endif</label>
        @error($name)
            <span class="error mt-2 text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
@elseif($type=='number')
    <div class="form-floating mb-3">
        <input id="{{$id}}" type="{{$type}}" class="{{$class}}" name="{{$name}}" value="{{ old($name) }}" placeholder="{{$title}}" @if($required=="True") required @endif autocomplete="{{$name}}" autofocus>
        <label for="{{$name}}">{{$title}} @if($required=="True")<span style="color:red;"> *</span>@endif</label>
        @error($name)
            <span class="error mt-2 text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
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
    <div class="form-floating mb-3">
        <input id="{{$id}}" type="{{$type}}" class="{{$class}}" name="{{$name}}" value="{{ old($name) }}" placeholder="{{$title}}" @if($required=="True") required @endif autocomplete="{{$name}}" autofocus>
        <label for="{{$name}}">{{$title}} @if($required=="True")<span style="color:red;"> *</span>@endif</label>
        @error($name)
            <span class="error mt-2 text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
@else
    <div class="form-floating mb-3">
        <input id="{{$id}}" type="{{$type}}" class="{{$class}}" name="{{$name}}" value="{{ old($name) }}" placeholder="{{$title}}" @if($required=="True") required @endif autocomplete="{{$name}}" autofocus>
        <label for="{{$name}}">{{$title}} @if($required=="True")<span style="color:red;"> *</span>@endif</label>
        @error($name)
            <span class="error mt-2 text-danger" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
@endif