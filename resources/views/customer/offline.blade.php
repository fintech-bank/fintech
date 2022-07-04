@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Hors Ligne</h1>
        <!--end::Title-->

    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <x-base.alert
    type="null"
    color="warning"
    icon="power-off"
    title="Application Hors Ligne"
    content="Vous n'etes actuellement pas connecté à internet ou le service est actuellement indisponible !" />
@endsection

@section("script")
    @include("customer.scripts.dashboard")
@endsection
