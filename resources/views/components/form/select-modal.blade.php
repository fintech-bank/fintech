<div class="mb-10">
    <label for="{{ $name }}" class="{{ $required == true ? 'required' : '' }} form-label">
        {{ $label }}
    </label>
    <select id="{{ $name }}" class="form-select form-select-solid" data-control="select2" @isset($parent) data-dropdown-parent="{{ $parent }}" @endisset @isset($placeholder) data-placeholder="{{ $placeholder }}" @endisset name="{{ $name }}" data-allow-clear="true">
        <option value=""></option>
        @foreach(json_decode($datas, true) as $data)
            <option value="{{ $data['name'] }}">{{ $data['name'] }}</option>
        @endforeach
    </select>
</div>
