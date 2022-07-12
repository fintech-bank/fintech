<div class="form-check form-check-custom form-check-solid me-3">
    <input class="form-check-input" type="radio" name="{{ $name }}" value="{{ $value }}" id="{{ $for }}" @if($checked == true) checked @endif @if($function != null) {{ $function }}={{ $nameFunction }} @endif />
    <label class="form-check-label" for="{{ $for }}">
        {{ $label }}
    </label>
</div>
