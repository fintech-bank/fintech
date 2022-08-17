@extends("customer.layouts.app")

@section("css")

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
            <li class="breadcrumb-item text-dark">Prêt Personnel</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->

    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="row">
        <div class="col-9">
            <div class="card card-flush shadow-sm">
                <div class="card-header bg-bank">
                    <h3 class="card-title text-white">Simuler votre crédit</h3>
                </div>
                <div class="card-body py-5">
                    <x-form.input
                        name="amount"
                        type="text"
                        label="Montant Souhaité"
                        placeholder="{{ $loan_plan->minimum }} - {{ $loan_plan->maximum }}"
                        class="mb-10" />

                    <div class="mb-20 d-flex flex-row justify-content-between align-items-center">
                        <div class="d-flex flex-column w-50 me-10">
                            <label for="" class="form-label">Durée</label>
                            <div id="slider_duration"></div>
                        </div>
                        <input type="text" name="duration" class="form-control form-control-solid w-50">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card card-flush shadow-sm">
                <div class="card-header bg-bank">
                    <h3 class="card-title text-white">Votre Résultat</h3>
                </div>
                <div class="card-body py-5 fs-4" id="block_resultat">
                    <div class="d-flex flex-row justify-content-between mb-3">
                        <span>Nature du crédit</span>
                        <span class="fw-bolder fs-3">Prêt Personnel</span>
                    </div>
                    <div class="d-flex flex-row justify-content-between mb-3">
                        <span>Montant financé</span>
                        <span class="fw-bolder fs-3" data-content="amount_loan">3 000 €</span>
                    </div>
                    <div class="d-flex flex-row justify-content-between mb-3">
                        <span data-content="mensuality_duration_text">30 Mensualités</span>
                        <span class="fw-bolder fs-3" data-content="mensuality">111 €</span>
                    </div>
                    <div class="d-flex flex-row justify-content-between mb-3">
                        <span>Durée</span>
                        <span class="fw-bolder fs-3" data-content="mensuality_duration">36 mois</span>
                    </div>
                    <div class="d-flex flex-row justify-content-between mb-3">
                        <span>TAEG Fixe</span>
                        <span class="fw-bolder fs-3" data-content="taeg">4,93 %</span>
                    </div>
                    <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                        <span class="w-50">Montant dù par l'emprunteur</span>
                        <span class="fw-bolder fs-3" data-content="amount_du">3 980,00 €</span>
                    </div>
                </div>
                <div class="card-footer d-flex flex-wrap">
                    <x-base.button
                        class="btn btn-bank btn-sm w-100"
                        text="Je demande ce crédit"
                        id="btnSubmit" />
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.subscription.loan.personnalSimulate")
@endsection
