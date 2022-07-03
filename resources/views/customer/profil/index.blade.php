@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Profil & Données Personnelles</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('customer.dashboard') }}" class="text-muted text-hover-primary">{{ \App\Helper\CustomerHelper::getName($customer) }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Profil & Données Personnelles</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <a href="{{ url()->previous(true) }}" class="d-flex flex-row align-items-center text-dark mb-5">
        <i class="fa-solid fa-arrow-left me-2"></i>
        Retour
    </a>
    @if(!$customer->info->isVerified)
    <x-base.alert
        type="solid"
        color="warning"
        icon="triangle-exclamation"
        title="Votre identité n'est pas vérifier"
        content="Certaine fonctionnalité de l'espace ne sont pas disponible tant que votre identité n'à pas été vérifier par notre système" />
    @endif
    <div class="row mb-10">
        @if(!$customer->info->isVerified)
            <div class="col-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Téléphone Sécurisé</h3>
                    </div>
                    <form action="{{ route('customer.profil.update') }}" id="formEditSecureMobile" method="post">
                        @csrf
                        <input type="hidden" name="action" value="updateSecurePhone">
                        <div class="card-body">
                            <x-form.input
                                name="mobile"
                                type="text"
                                value="{{ $customer->info->mobile }}" />
                        </div>
                        <div class="card-footer">
                            <x-form.button />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Gestion des préférences</h3>
                    </div>
                    <form id="formEditPreference" action="{{ route('customer.profil.update') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <input type="hidden" name="action" value="updatePreference">
                            <x-form.switches
                                name="notif_sms"
                                label="Recevoir des notifications commercial par SMS"
                                value="true"
                                :checked="$customer->setting->notif_sms ? true : false" />

                            <x-form.switches
                                name="notif_app"
                                label="Recevoir des notifications commercial par l'application"
                                value="true"
                                :checked="$customer->setting->notif_app ? true : false" />

                            <x-form.switches
                                name="notif_mail"
                                label="Recevoir des notifications commercial par Email"
                                value="true"
                                :checked="$customer->setting->notif_mail ? true : false" />
                        </div>
                        <div class="card-footer text-end">
                            <x-form.button />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Vérification d'identité</h3>
                    </div>
                    <div class="card-body">
                        <x-base.button
                            class="btn btn-bank"
                            text="Vérifier mon identité"
                            id="verifUser" />
                    </div>
                </div>
            </div>
        @else
            <div class="col-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Téléphone Sécurisé</h3>
                    </div>
                    <form action="{{ route('customer.profil.update') }}" id="formEditSecureMobile" method="post">
                        @csrf
                        <input type="hidden" name="action" value="updateSecurePhone">
                        <div class="card-body">
                            <x-form.input
                                name="mobile"
                                type="text"
                                value="{{ $customer->info->mobile }}" />
                        </div>
                        <div class="card-footer">
                            <x-form.button />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Gestion des préférences</h3>
                    </div>
                    <form id="formEditPreference" action="{{ route('customer.profil.update') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <input type="hidden" name="action" value="updatePreference">
                            <x-form.switches
                                name="notif_sms"
                                label="Recevoir des notifications commercial par SMS"
                                value="1"
                                :checked="$customer->setting->notif_sms ? true : false" />

                            <x-form.switches
                                name="notif_app"
                                label="Recevoir des notifications commercial par l'application"
                                value="1"
                                :checked="$customer->setting->notif_app ? true : false" />

                            <x-form.switches
                                name="notif_mail"
                                label="Recevoir des notifications commercial par Email"
                                value="1"
                                :checked="$customer->setting->notif_mail ? true : false" />
                        </div>
                        <div class="card-footer text-end">
                            <x-form.button />
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Coordonnées Personnelles</h3>
        </div>
        <form id="formEditPerso" action="{{ route('customer.profil.update') }}" method="POST">
            @csrf
            <input type="hidden" name="action" value="updateInfoPerso">
            <div class="card-body">
                <x-form.input
                    name="email"
                    type="text"
                    label="Adresse Mail"
                    value="{{ \App\Helper\UserHelper::emailObscurate($customer->user->email) }}" />

                <x-form.input
                    name="phone"
                    type="text"
                    label="Téléphone Fixe"
                    value="{{ $customer->info->phone }}"
                    text="Format: +33XXXXXXXXX" />

                <h3 class="fw-bolder mb-5">Adresse</h3>
                <x-form.input
                    name="address"
                    type="text"
                    label="Adresse"
                    value="{{ $customer->info->address }}" />
                <div class="row">
                    <div class="col-3">
                        <x-form.input
                            name="postal"
                            type="text"
                            label="Code Postal"
                            value="{{ $customer->info->postal }}" />
                    </div>
                    <div class="col-5">
                        <x-form.input
                            name="postal"
                            type="text"
                            label="Ville"
                            value="{{ $customer->info->city }}" />
                    </div>
                    <div class="col-4">
                        <x-form.input
                            name="country"
                            type="text"
                            label="Pays"
                            value="{{ $customer->info->country }}" />
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <x-form.button />
            </div>
        </form>
    </div>

@endsection

@section("script")
    @include("customer.scripts.profil.index")
@endsection
