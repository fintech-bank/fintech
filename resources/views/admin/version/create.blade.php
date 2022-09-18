@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Création d'une version</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Administration</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Gestion des versions de l'application</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="card card-flush shadow-sm">
        <form id="formCreateVersion" action="{{ route('admin.version.store') }}" method="POST" novalidate>
            @csrf
            <div class="card-header">
                <h3 class="card-title">Nouvelle version</h3>
                <div class="card-toolbar">
                    <x-form.button text="Sauvegarder" />
                </div>
            </div>
            <div class="card-body py-5">
                <x-form.input
                    name="name"
                    type="text"
                    label="Nom de la version"
                    required="true" />

                <x-form.input
                    name="types"
                    type="text"
                    label="Types (Tags)"
                    required="true" />

                <div id="textarea" class="mb-10">
                    <textarea name="content" style="display: none" cols="10"></textarea>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked="checked" name="publish" value="1">
                    <label class="form-check-label" for="flexSwitchCheckChecked">Publier la mise à jours</label>
                </div>
            </div>
        </form>
    </div>
@endsection

@section("script")
    @include('admin.scripts.version.create')
@endsection
