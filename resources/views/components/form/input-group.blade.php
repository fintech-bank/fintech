@if($label == null)
    <div class="input-group @if($class != null) {{ $class }} @endif">
        @if($placement == 'left')
            <span class="input-group-text" id="basic-addon1">{!! $symbol !!}</span>
        @endif

        <input type="text" id="{{ $name }}" name="{{ $name }}" @isset($value) value="{{ $value }}" @endisset class="form-control" @if($required == true) required @endif placeholder="@if($placeholder != null) {{ $placeholder }} @else {{ $label }} @endif">

        @if($placement == 'right')
            <span class="input-group-text" id="basic-addon1">{!! $symbol !!}</span>
        @endif
    </div>
    @if($text)
        <p class="text-muted">{!! $text !!}</p>
    @endif
@else
    <div class="mb-10">
        <label for="{{ $name }}" class="form-label @if($required == true) required @endif">{{ $label }}</label>
        <div class="input-group @if($class != null) {{ $class }} @endif">
            @if($placement == 'left')
                <span class="input-group-text" id="basic-addon1">{!! $symbol !!}</span>
            @endif

            <input type="text" id="{{ $name }}" name="{{ $name }}" @isset($value) value="{{ $value }}" @endisset class="form-control" @if($required == true) required @endif placeholder="@if($placeholder != null) {{ $placeholder }} @else {{ $label }} @endif">

            @if($placement == 'right')
                <span class="input-group-text" id="basic-addon1">{!! $symbol !!}</span>
            @endif
        </div>
        @if($text)
            <p class="text-muted">{!! $text !!}</p>
        @endif
    </div>
@endif
