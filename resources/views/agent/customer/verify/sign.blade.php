@extends("agent.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Clients</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.dashboard') }}" class="text-muted text-hover-primary">Agence: {{ auth()->user()->agency->name }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.customer.index') }}" class="text-muted text-hover-primary">Clients</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.customer.show', $file->customer_id) }}" class="text-muted text-hover-primary">Client: {{ \App\Helper\CustomerHelper::getName($file->customer) }} - {{ $file->customer->user->identifiant }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Signature du document: <strong>{{ $file->name }}</strong></li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
<div class="d-flex flex-center">
    <div class="card shadow-sm w-400px">
        <div class="card-header bg-bank">
            <h3 class="card-title text-white">Signature du contrat</h3>
        </div>
        <form action="" id="formSignDocument" method="post">
            <div class="card-body">
                <h3 class="fw-bolder mb-5">Informations relative au document</h3>
                <div class="d-flex flex-column justify-content-between mb-3">
                    <div class="fw-bolder">Nom</div>
                    {{ $file->name }}
                </div>
                <div class="d-flex flex-column justify-content-between mb-3">
                    <div class="fw-bolder">Référence</div>
                    {{ $file->reference }}
                </div>
                <div class="d-flex flex-column justify-content-between mb-10">
                    <div class="fw-bolder">Date d'émission</div>
                    {{ $file->created_at->format("d/m/Y à H:i") }}
                </div>
                <x-form.input
                    name="code_sign"
                    type="password"
                    label="Code de signature"
                    required="true" />
            </div>
            <div class="card-footer text-center">
                <x-form.button text="Signer le document" />
            </div>
        </form>
    </div>
</div>
@endsection

@section("script")
    @include("agent.scripts.customer.verify.sign")
@endsection
