@extends("emails.layouts.app")

@section("content")
    <div class="d-flex flex-column bg-gray-300 ms-20 me-20 mt-20 mb-5 w-600px rounded">
        <!--begin::Alert-->
        <div class="alert bg-bank d-flex flex-column flex-sm-row p-5 mb-10 mt-10 rounded">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <!--begin::Content-->
                <span class="fs-2tx fw-bolder text-start">Nouveau prélèvement bancaire</span>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Alert-->
        <div class="ms-10 me-10 mb-5">
            <span class="fw-bolder fs-3 mb-5">Bonjour {{ \App\Helper\CustomerHelper::getFirstname($sepa->wallet->customer) }}</span>
            <p>
                Un nouveau prélèvement bancaire c'est présenté sur votre compte N°<strong>{{ $sepa->wallet->number_account }}</strong>en date du <strong>{{ $sepa->created_at->format('d/m/Y à H:i') }}</strong>.<br>
                Voici un récapitulatif du prélèvement:
            </p>
            <ul>
                <li>Mandat: {{ $sepa->number_mandat }}</li>
                <li>Créancier: {{ $sepa->creditor }}</li>
                <li>Montant: {{ eur($sepa->amount) }}</li>
                <li>Prélevé sur le compte: {{ \App\Helper\CustomerWalletHelper::getNameAccount($sepa->wallet) }}</li>
                <li>Date de prélèvement: {{ $sepa->updated_at->format('d/m/Y') }}</li>
            </ul>
        </div>
        @include("emails.layouts.salutation")
    </div>
@endsection

