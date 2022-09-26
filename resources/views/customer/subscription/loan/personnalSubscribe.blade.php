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
            <li class="step-active">Vérification</li>
            <li class="step-todo">Réponse</li>
            <li class="step-todo">Envoie des justificatifs</li>
            <li class="step-todo">Signatures</li>
            <li class="step-todo">Terminer</li>
        </ol>
    </div>
    <div class="card shadow-sm">
        <div class="card-header bg-bank">
            <h3 class="card-title text-white">Vérification des données de votre demande de prêt personnel</h3>
        </div>
        <form id="formSubscribePersonnalLoan" action="{{ route('customer.subscription.personnal') }}" method="POST" enctype="multipart/formdata">
            @csrf
            <input type="hidden" name="customer_id" value="{{ $info->customer_id }}">
            <input type="hidden" name="amount" value="{{ $info->amount }}">
            <input type="hidden" name="duration" value="{{ $info->duration }}">
            <input type="hidden" name="action" value="response">
            <div class="card-body">
                <table class="table table-striped gs-7">
                    <tbody>
                        <tr>
                            <td class="fw-bold">Nature du crédit</td>
                            <td>Prêt Personnel</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Montant financé</td>
                            <td>{{ eur($info->amount) }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">{{ $simulate->mensuality_duration_text }}</td>
                            <td>{{ eur($simulate->mensuality) }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Durée</td>
                            <td>{{ $simulate->mensuality_duration }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">TAEG Fixe</td>
                            <td>{{ $simulate->taeg }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Montant dù par l'emprunteur</td>
                            <td>{{ eur($simulate->mensuality * $info->duration + $info->amount) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="d-flex flex-end">
                    <x-form.button />
                </div>
            </div>
        </form>
    </div>
@endsection

@section("script")
    @include("customer.scripts.subscription.loan.personnalSubscribe")
@endsection
