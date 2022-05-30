@extends("emails.layouts.app")

@section("content")
    <div class="d-flex flex-column bg-gray-300 ms-20 me-20 mt-20 mb-5 w-600px rounded">
        <!--begin::Alert-->
        <div class="alert bg-bank d-flex flex-column flex-sm-row p-5 mb-10 mt-10 rounded">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <!--begin::Content-->
                <span class="fs-2tx fw-bolder text-start">Votre nouveau compte bancaire est maintenant actif</span>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Alert-->
        <div class="ms-10 me-10 mb-5">
            <span class="fw-bolder fs-3 mb-5">Bonjour {{ \App\Helper\CustomerHelper::getFirstname($customer) }}</span>
            <p>Un nouveau compte bancaire à été créer, voici les informations récapitulative:</p>
            <ul>
                <li><strong>Numéro de Compte:</strong> {{ $wallet->number_account }}</li>
                <li><strong>IBAN:</strong> {{ $wallet->iban }}</li>
                <li><strong>Découvert Autorisé:</strong> {{ $wallet->decouvert == true ? 'OUI' : 'NON' }}</li>
            </ul>
            @if($document->signable == true && $document->signed_by_client == false)
                <p class="text-bank">
                    Vous devez impérativement signer le document contractuel disponible via votre interface client ou prendre contact avec votre conseiller.<br>
                    Une fois votre contrat signer votre compte sera <strong>Actif</strong> et vous pourrer l'utiliser.
                </p>
            @endif
            <p>Le contract relatif à ce nouveau compte est disponible via votre interface client.</p>
        </div>
        @include("emails.layouts.salutation")
    </div>
@endsection

