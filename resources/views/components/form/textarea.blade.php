<div class="mb-10">
    <label for="{{ $name }}" class="form-label {{ $required == true ? "required" : '' }}">{{ $label }}</label>
    <textarea
        id="{{ $name }}"
        class="form-control ckeditor {{ $errors->has($name) ? ' is-invalid' : '' }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}>{{ old($name, isset($value) ? $value : '') }}</textarea>

    @if ($errors->has($name))
        <div class="invalid-feedback">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>
