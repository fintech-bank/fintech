<div class="mb-10">
    <label for="{{ $name }}" class="{{ $required == true ? 'required' : '' }} form-label">
        {{ $label }}
    </label>
    <select id="{{ $name }}" data-uri="{{ $url }}" class="form-select form-select-solid" data-control="select2" @isset($placeholder) data-placeholder="{{ $placeholder }}" @endisset name="{{ $name }}">
        <option value=""></option>
    </select>
</div>
