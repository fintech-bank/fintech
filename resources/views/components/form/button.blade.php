<button @isset($id) id="{{ $id }}" @endisset type="submit" class="btn {{ $class }}" @isset($dataset)
    @foreach($dataset as $data)
    data-{{ $data['name'] }}='{{ $data['value'] }}'
    @endforeach
    @endisset>
    <span class="indicator-label">
         {{ $text }}
    </span>
    <span class="indicator-progress">
        {{ $textProgress }} <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
    </span>
</button>
