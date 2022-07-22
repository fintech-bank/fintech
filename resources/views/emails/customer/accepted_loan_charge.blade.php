@extends("emails.layouts.app")

@section("content")
    <div class="d-flex flex-column bg-gray-300 ms-20 me-20 mt-20 mb-5 w-600px rounded">
        <!--begin::Alert-->
        <div class="alert bg-bank d-flex flex-column flex-sm-row p-5 mb-10 mt-10 rounded">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <!--begin::Content-->
                <span class="fs-2tx fw-bolder text-start">Votre Pret Bancaire</span>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Alert-->
        <div class="ms-10 me-10 mb-5">
            <span class="fw-bolder fs-3 mb-5">Bonjour {{ \App\Helper\CustomerHelper::getFirstname($loan->customer) }}</span>
            <p>
                Le montant de votre pret bancaire N°{{ $loan->reference }} est maintenant disponible.<br>
                Voici un récapitulatif de l'opération:
            </p>
            <ul>
                <li>Pret N°{{ $loan->reference }}</li>
                <li>Montant Disponible: {{ eur($loan->amount_loan) }}</li>
                <li>Souscrit le: {{ $loan->created_at->format('d/m/Y') }}</li>
                <li>Libéré le: {{ $loan->updated_at->format('d/m/Y à H:i') }}</li>
            </ul>
        </div>
        @include("emails.layouts.salutation")
    </div>
@endsection

