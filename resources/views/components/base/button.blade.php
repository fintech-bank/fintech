<button type="button" id="{{ $id }}" class="btn {{ $class }}" @foreach($datas as $data) data-{{ $data['name'] }}='{{ $data['value'] }}' @endforeach @if($tooltip != null) data-bs-toggle="tooltip" title="{{ $tooltip }}" @endisset>
    <span class="indicator-label">
        {!! $text !!}
    </span>
    <span class="indicator-progress">
        {{ $textIndicator }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
    </span>
</button>
