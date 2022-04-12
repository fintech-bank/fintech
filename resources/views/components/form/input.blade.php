@if($type == 'hidden')
    <input type="hidden" name="{{ $name }}" value="{{ $value }}">
@else
    <div class="mb-10">
        @if($help == true)
            <label for="{{ $name }}" class="{{ $required == true ? 'required' : '' }} form-label">
                {{ $label }}
                <i class="fas fa-info-circle text-primary fa-lg"
                   data-bs-toggle="popover"
                   data-bs-custom-class="popover-dark" title="Aide" data-bs-content="{{ $helpText }}"></i>
            </label>
        @else
            <label for="{{ $name }}" class="{{ $required == true ? 'required' : '' }} form-label">
                {{ $label }}
            </label>
        @endif
        <input
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, isset($value) ? $value : '') }}"
            {{ $required ? 'required' : ''}}
            {{ $autofocus ? 'autofocus' : '' }}
            class="form-control form-control-solid {{ $errors->has($name) ? ' is-invalid' : '' }} {{ $class }}"
            @if($placeholder) placeholder="{{ $placeholder }}"  @else placeholder="{{ $label }}" @endif/>

        @if($text)
            <p class="text-muted">{!! $text !!}</p>
        @endif

        @if ($errors->has($name))
            <div class="invalid-feedback">
                {{ $errors->first($name) }}
            </div>
        @endif
    </div>
@endif
