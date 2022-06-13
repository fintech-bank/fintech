@extends("emails.layouts.app")

@section("content")
    <div class="d-flex flex-column bg-gray-300 ms-20 me-20 mt-20 mb-5 w-600px rounded">
        <!--begin::Alert-->
        <div class="alert bg-bank d-flex flex-column flex-sm-row p-5 mb-10 mt-10 rounded">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <!--begin::Content-->
                <span class="fs-2tx fw-bolder text-start">Votre dossier de pret N°{{ $loan->reference }}</span>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Alert-->
        <div class="ms-10 me-10 mb-5">
            <span class="fw-bolder fs-3 mb-5">Bonjour {{ \App\Helper\CustomerHelper::getFirstname($customer) }}</span>
            <p>Votre demande de pret bancaire N°{{ $loan->reference }} est maintenant passer au status <strong>{{ \App\Helper\CustomerLoanHelper::getStatusLoan($status, false) }}</strong></p>
            <p>
                Si il à été accepter l'argent sera disponible dans les 8 jours ouvrée suivant les conditions générales de ventes.<br>
                Si il vous à été refuser, veuillez prendre contact avec votre interlocuteur bancaire.
            </p>
        </div>
        @include("emails.layouts.salutation")
    </div>
@endsection

