@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Modifier mon mot de passe</h1>
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
            <li class="breadcrumb-item text-dark">Modifier mon mot de passe</li>
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
    <div class="card shadow-sm mb-10">
        <div class="card-header">
            <h3 class="card-title">Modification du mot de passe</h3>
        </div>
        <form id="formEditPassword" action="{{ route('customer.profil.update') }}" method="POST">
            @csrf
            <input type="hidden" name="action" value="updatePassword">
            <div class="card-body">
                <!--begin::Main wrapper-->
                <div class="fv-row" data-kt-password-meter="true">
                    <!--begin::Wrapper-->
                    <div class="mb-1">
                        <!--begin::Label-->
                        <label class="form-label fw-bold fs-6 mb-2">
                            Nouveau mot de passe
                        </label>
                        <!--end::Label-->

                        <!--begin::Input wrapper-->
                        <div class="position-relative mb-3">
                            <input class="form-control form-control-lg form-control-solid"
                                   type="password" placeholder="" name="new_password" autocomplete="off" />

                            <!--begin::Visibility toggle-->
                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                  data-kt-password-meter-control="visibility">
                                <i class="bi bi-eye-slash fs-2"></i>

                                <i class="bi bi-eye fs-2 d-none"></i>
                            </span>
                            <!--end::Visibility toggle-->
                        </div>
                        <!--end::Input wrapper-->

                        <!--begin::Highlight meter-->
                        <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                        </div>
                        <!--end::Highlight meter-->
                    </div>
                    <!--end::Wrapper-->

                    <!--begin::Hint-->
                    <div class="text-muted">
                        Utilisez 8 caractères ou plus avec un mélange de lettres, de chiffres et de symboles.
                    </div>
                    <!--end::Hint-->
                </div>
                <!--end::Main wrapper-->
            </div>
            <div class="card-footer text-end">
                <x-form.button />
            </div>
        </form>
    </div>
    @if($agent->isPhone())
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Changement du code SECURPASS</h3>
        </div>
        <form id="formEditSecurpass" action="{{ route('customer.profil.update') }}" method="POST">
            @csrf
            <input type="hidden" name="action" value="updateSecurpass">
            <div class="card-body">
                <x-form.input-mask
                    name="auth_code"
                    label="Nouveau code SECURPASS"
                    mask="9999" />
            </div>
            <div class="card-footer text-end">
                <x-form.button />
            </div>
        </form>
    </div>
    @endif
@endsection

@section("script")
    @include("customer.scripts.profil.password")
@endsection
