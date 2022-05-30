<div class="mb-10">
    <label for="{{ $name }}" class="{{ $required == true ? 'required' : '' }} form-label">
        {{ $label }}
    </label>
    <select id="{{ $name }}" class="form-select form-select-solid" data-control="select2" @isset($placeholder) data-placeholder="{{ $placeholder }}" @else data-placeholder="{{ $label }}" @endisset name="{{ $name }}">
        <option value=""></option>
        @foreach(json_decode($datas, true) as $data)
            <option value="{{ $data[$key] }}">{{ $data[$value] }}</option>
        @endforeach
    </select>
</div>
