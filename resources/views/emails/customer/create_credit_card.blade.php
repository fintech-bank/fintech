@extends("emails.layouts.app")

@section("content")
    <div class="d-flex flex-column bg-gray-300 ms-20 me-20 mt-20 mb-5 w-600px rounded">
        <!--begin::Alert-->
        <div class="alert bg-bank d-flex flex-column flex-sm-row p-5 mb-10 mt-10 rounded">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <!--begin::Content-->
                <span class="fs-2tx fw-bolder text-start">Votre nouvelle carte bancaire {{ config('app.name') }}</span>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Alert-->
        <div class="ms-10 me-10 mb-5">
            <span class="fw-bolder fs-3 mb-5">Bonjour {{ \App\Helper\CustomerHelper::getFirstname($customer) }}</span>
            <p>Une nouvelle carte bancaire à été créer, voici les informations récapitulative:</p>
            <ul>
                <li><strong>Numéro de Carte Bancaire:</strong> {{ \App\Helper\CustomerCreditCard::getCreditCard($card->number) }}</li>
                <li><strong>Type:</strong> {{ \App\Helper\CustomerCreditCard::getType($card->type) }}</li>
                <li><strong>Support:</strong> {{ Str::ucfirst($card->support) }}</li>
                <li><strong>Type de débit:</strong> {{ \App\Helper\CustomerCreditCard::getDebit($card->debit) }}</li>
                <li><strong>Limite de Retrait:</strong> {{ eur($card->limit_retrait) }} / 7 jours</li>
                <li><strong>Limite de Retrait:</strong> {{ eur($card->limit_payment) }} / 30 jours</li>
            </ul>
            @if($document->signable == true && $document->signed_by_client == false)
                <p class="text-bank">
                    Vous devez impérativement signer le document contractuel disponible via votre interface client ou prendre contact avec votre conseiller.<br>
                    Une fois votre contrat signer votre carte bancaire sera <strong>Active</strong> et vous pourrer l'utiliser.
                </p>
            @endif
            <p>Le code confidentiel de votre carte bancaire vous à été envoyer par SMS.</p>
            <p>Le contract relatif à cette nouvelle carte bancaire est disponible via votre interface client.</p>
        </div>
        @include("emails.layouts.salutation")
    </div>
@endsection

