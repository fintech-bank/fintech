<div class="mb-10">
    <label for="{{ $name }}" class="form-label @if($required == true) required @endif">{{ $label }}</label>
    <div class="input-group">
        @if($placement == 'left')
            <span class="input-group-text" id="basic-addon1">{{ $symbol }}</span>
        @endif

        <input type="text" id="{{ $name }}" name="{{ $name }}" @isset($value) value="{{ $value }}" @endisset class="form-control" @if($required == true) required @endif placeholder="{{ $label }}">

        @if($placement == 'right')
            <span class="input-group-text" id="basic-addon1">{{ $symbol }}</span>
        @endif
    </div>
</div>
