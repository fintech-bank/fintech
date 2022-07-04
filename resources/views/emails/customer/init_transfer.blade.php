@extends("emails.layouts.app")

@section("content")
    <div class="d-flex flex-column bg-gray-300 ms-20 me-20 mt-20 mb-5 w-600px rounded">
        <!--begin::Alert-->
        <div class="alert bg-bank d-flex flex-column flex-sm-row p-5 mb-10 mt-10 rounded">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <!--begin::Content-->
                <span class="fs-2tx fw-bolder text-start">Votre virement bancaire</span>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Alert-->
        <div class="ms-10 me-10 mb-5">
            <span class="fw-bolder fs-3 mb-5">Bonjour {{ \App\Helper\CustomerHelper::getFirstname($customer) }}</span>
            <p>Nous confirmons la prise en compte de votre demande de virement le {{ now()->format('d/m/Y à H:i') }}</p>
            <ul>
                <li>Vers le compte: {{ $transfer->beneficiaire->iban }}</li>
                <li>Au nom de: {{ \App\Helper\CustomerTransferHelper::getNameBeneficiaire($transfer->beneficiaire) }}</li>
                <li>Pour un montant de: {{ eur($transfer->amount) }}</li>
                <li>Motif: {{ $transfer->reason }}</li>
                <li>Type de virement: {{ \App\Helper\CustomerTransferHelper::getTypeTransfer($transfer->type) }}</li>
            </ul>
            <p>Si vous n'êtes pas à l'origine de l'opération, veuillez contacter rapidement votre conseiller.</p>
        </div>
        @include("emails.layouts.salutation")
    </div>
@endsection

