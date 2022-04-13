@if(session()->has('error'))
    <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
@endif
