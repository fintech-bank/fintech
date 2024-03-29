@extends("emails.layouts.app")

@section("content")
    <div class="d-flex flex-column bg-gray-300 ms-20 me-20 mt-20 mb-5 w-600px rounded">
        <!--begin::Alert-->
        <div class="alert bg-bank d-flex flex-column flex-sm-row p-5 mb-10 mt-10 rounded">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <!--begin::Content-->
                <span class="fs-2tx fw-bolder text-start">Votre prélèvement bancaire</span>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Alert-->
        <div class="ms-10 me-10 mb-5">
            <span class="fw-bolder fs-3 mb-5">Bonjour {{ \App\Helper\CustomerHelper::getFirstname($customer) }}</span>
            <p>
                Le prélèvement bancaire initié par {{ $prlv->creditor }} en date du {{ $prlv->created_at->format('d/m/Y à H:i') }} est passé au status: {!! \App\Helper\CustomerSepaHelper::getStatus($prlv->status) !!}<br>
                Voici un récapitulatif du prélèvement
            </p>
            <ul>
                <li>Mandat: {{ $prlv->number_mandat }}</li>
                <li>Créancier: {{ $prlv->creditor }}</li>
                <li>Montant: {{ eur($prlv->amount) }}</li>
                <li>Prélevé sur le compte: {{ \App\Helper\CustomerWalletHelper::getNameAccount($prlv->wallet) }}</li>
            </ul>
        </div>
        @include("emails.layouts.salutation")
    </div>
@endsection

