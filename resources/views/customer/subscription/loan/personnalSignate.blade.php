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
            <li class="step-active">Signatures</li>
            <li class="step-todo">Terminer</li>
        </ol>
    </div>
    <div class="card shadow-sm">
        <div class="card-header bg-bank">
            <h3 class="card-title text-white">Signature des documents de prêt</h3>
        </div>
        <form id="formSubscribePersonnalLoan" action="{{ route('customer.subscription.personnal') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="loan_id" value="{{ $loan->id }}">
            <input type="hidden" name="customer_id" value="{{ $customer->id }}">
            <input type="hidden" name="action" value="terminate" />
            <div class="card-body">
                <table class="table table-striped border gs-7">
                    <thead>
                        <tr>
                            <th>Document</th>
                            <th>Signé ?</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documents as $document)
                            <tr>
                                <td><a href="/storage/gdd/{{ $customer->id }}/3/{{ $document->name }}.pdf"><i class="fa-solid fa-file-pdf me-2"></i>{{ $document->name }}</a></td>
                                <td>{!! $document->signed_by_client_label !!}</td>
                                <td>
                                    <button class="btn btn-icon btn-sm btn-bank btnSignate" data-document="{{ $document->id }}" data-bs-toggle="tooltip" title="Signé le document"><i class="fa-solid fa-signature"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <div class="d-flex flex-end">
                    <x-form.button text="Continuer"/>
                </div>
            </div>
        </form>
    </div>
@endsection

@section("script")
    @include("customer.scripts.subscription.loan.personnalSubscribe")
@endsection
