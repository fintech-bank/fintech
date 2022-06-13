@extends("emails.layouts.agent")

@section('content')
    <div class="d-flex flex-column bg-gray-300 ms-20 me-20 mt-20 mb-5 w-600px rounded">
        <!--end::Alert-->
        <div class="ms-10 me-10 mb-5 pt-5">
            <p class="pt-5">Commande exécuté</p>
            <p>{!! $text !!}</p>
        </div>
        @include("emails.layouts.salutation")
    </div>
@endsection
