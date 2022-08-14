@extends("emails.layouts.app")

@section("content")
    <div class="d-flex flex-column bg-gray-300 ms-20 me-20 mt-20 mb-5 w-600px rounded">
        <div class="ms-10 me-10 mb-5">
            <span class="fw-bolder fs-3 mb-5">Bonjour {{ \App\Helper\CustomerHelper::getFirstname($mobility->customer) }}</span>
            <p>Votre demande concernant le mandat de mobilité bancaire <strong>{{ $mobility->mandate }}</strong> à évolué:</p>
            @if($mobility->status == 'bank_return')
                <p>Votre banque de départ <strong>({{ $mobility->bank->name }})</strong> à transmis les informations que nous lui avions demandés.</p>
                <p>Afin de poursuivre cette demande, vous devez valider l'ensemble des documents et opérations fournis par votre banque de départ dans votre espace client</p>
                <a href="{{ route('customer.subscription.index') }}#request" class="btn btn-bank">Mandat N°{{ $mobility->mandate }}</a>
            @endif
            @if($mobility->status == 'creditor_start')
                <p>Nous avons émis une demande à tous vos créditeurs afin qu'il nous fournisse une liste des mouvements susceptible d'être réceptionné par notre banque.</p>
                <p>Vous recevrez une alerte par mail lorsque vos créditeurs nous aurons envoyé ces mouvements.</p>
            @endif
            @if($mobility->status == 'creditor_end')
                <p>Tous vos créditeurs nous ont transmis les informations demander.</p>
                <p>Afin de poursuivre cette demande, vous devez valider l'ensemble des documents et opérations fournis par vos créditeurs dans votre espace client</p>
                <a href="{{ route('customer.subscription.index') }}#request" class="btn btn-bank">Mandat N°{{ $mobility->mandate }}</a>
            @endif
        </div>
        @include("emails.layouts.salutation")
    </div>
@endsection

