<div class="mb-10">
    <label for="{{ $name }}" class="@if($required == true) required @endif form-label">{{ $label }}</label>
    <div
        class="input-group w-md-300px"
        data-kt-dialer="true"
        data-kt-dialer-min="{{ $min }}"
        data-kt-dialer-max="{{ $max }}"
        data-kt-dialer-step="{{ $step }}"
        data-kt-dialer-prefix="@isset($prefix) {{ $prefix }} @endisset"
        >

        <button class="btn btn-icon btn-outline btn-outline-secondary" type="button" data-kt-dialer-control="decrease">
            <i class="bi bi-dash fs-1"></i>
        </button>

        <input type="text" id="{{ $name }}" class="form-control" value="{{ $value }}" data-kt-dialer-control="input" @if($required == true) required @endif />

        <button class="btn btn-icon btn-outline btn-outline-secondary" type="button" data-kt-dialer-control="increase">
            <i class="bi bi-plus fs-1"></i>
        </button>

    </div>
</div>
