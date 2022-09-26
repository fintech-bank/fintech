@extends("customer.layouts.app")

@section("css")
    <link rel="stylesheet" href="/css/customer.css">
@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Prêt Personnel</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('customer.dashboard') }}"
                   class="text-muted text-hover-primary">{{ \App\Helper\CustomerHelper::getName($customer) }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Souscription du pret personnel</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->

    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="mb-10">
        <ol id="progress-bar">
            <li class="step-done">Simulation</li>
            <li class="step-done">Vérification</li>
            <li class="step-done">Réponse</li>
            <li class="step-done">Envoie des justificatifs</li>
            <li class="step-done">Signatures</li>
            <li class="step-done">Terminer</li>
        </ol>
    </div>
    <div class="card shadow-sm">
        <div class="card-header bg-bank">
            <h3 class="card-title text-white">Demande de prêt terminé</h3>
        </div>
        <div class="card-body">
            <p class="fs-3">
                Votre demande de prêt N°<strong>{{ $loan->reference }}</strong> d'un montant de <strong>{{ eur($loan->amount_loan) }}</strong> est maintenant terminé.<br>
                Notre équipe financière va étudié votre dossier et une réponse vous sera transmis sous 48H maximum.
            </p>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.subscription.loan.personnalSubscribe")
@endsection
