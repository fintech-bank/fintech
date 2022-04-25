<div class="mb-10">
    <label for="{{ $name }}" class="@if($required == true) required @endif form-label">{{ $label }}</label>
    <input type="text" class="form-control form-control-solid maskinput" id="{{ $name }}" name="{{ $name }}" data-mask="{{ $mask }}" @if($required == true) required @endif />
</div>
