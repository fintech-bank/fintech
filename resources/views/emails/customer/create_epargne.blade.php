@extends("emails.layouts.app")

@section("content")
    <div class="d-flex flex-column bg-gray-300 ms-20 me-20 mt-20 mb-5 w-600px rounded">
        <!--begin::Alert-->
        <div class="alert bg-bank d-flex flex-column flex-sm-row p-5 mb-10 mt-10 rounded">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <!--begin::Content-->
                <span class="fs-2tx fw-bolder text-start">Votre nouveau compte épargne est maintenant actif</span>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Alert-->
        <div class="ms-10 me-10 mb-5">
            <span class="fw-bolder fs-3 mb-5">Bonjour {{ \App\Helper\CustomerHelper::getFirstname($customer) }}</span>
            <p>Un nouveau compte épargne à été créer, voici les informations récapitulative:</p>
            <ul>
                <li><strong>Numéro de Compte:</strong> {{ $wallet->number_account }}</li>
                <li><strong>IBAN:</strong> {{ $wallet->iban }}</li>
                <li><strong>Versement Initial:</strong> {{ eur($epargne->initial_payment) }}</li>
                <li>
                    <strong>Versement periodique:</strong>
                    <ul>
                        <li>Date du premier versement: {{ \Carbon\Carbon::create(now()->year, now()->month, $epargne->monthly_days)->format('d/m/Y') }}</li>
                        <li>Montant Unitaire: {{ eur($epargne->monthly_payment) }}</li>
                        <li>Périodicité: Mensuel</li>
                        <li>Compte donneur d'ordre: {{ $wallet->number_account }}</li>
                    </ul>
                </li>
                <li>
                    <strong>Montant & Taux d'interet en vigueur:</strong>
                    <ul>
                        <li>Montant minimum des opérations: {{ eur($epargne->plan->init) }}</li>
                        <li>Solde minimum: {{ eur($epargne->plan->init) }}</li>
                        <li>Plafond Maximum légal: {{ eur($epargne->plan->limit) }}</li>
                        <li>Taux d'intérêt net: {{ number_format($epargne->plan->profit_percent, 2, ',', ' ') }} %</li>
                    </ul>
                </li>
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

