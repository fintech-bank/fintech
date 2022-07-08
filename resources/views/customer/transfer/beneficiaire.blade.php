@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Mes Bénéficiaires</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.dashboard') }}"
                   class="text-muted text-hover-primary">{{ \App\Helper\CustomerHelper::getName($customer) }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Mes Bénéficiaires</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="d-flex flex-row justify-content-between align-items-center bg-white p-10 mb-10 rounded-2">
        <div class="d-flex flex-column">
            <a href="{{ url()->previous(true) }}" class="d-flex flex-row align-items-center text-dark mb-5">
                <i class="fa-solid fa-arrow-left me-2"></i>
                Retour
            </a>
            <div class="fs-1 fw-bold">Mes Bénéficiaires</div>
        </div>
        <button class="btn btn-outline btn-outline-bank btn-active-light-primary btn-lg" data-bs-toggle="modal" data-target="#add_beneficiaire"><i class="fa-solid fa-plus me-3"></i> Nouveau bénéficiaire</button>
    </div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" data-kt-beneficiaire-table-filter="search" class="form-control form-control-solid w-1000px ps-15" placeholder="Rechercher un bénéficiaire" />
                </div>
            </div>
        </div>
        <div class="card-body">
            @foreach($customer->beneficiaires as $beneficiaire)
                <a href="" class="card shadow-sm mb-5 text-black-50 text-hover-primary">
                    <div class="card-body d-flex flex-row justify-content-between align-items-center">
                        <div class="d-flex flex-column">
                            <div class="d-flex flex-row align-items-center fs-6">
                                <i class="fa-solid fa-square text-{{ random_color() }} me-2"></i> {{ $beneficiaire->bankname }}
                            </div>
                            <div class="fs-3 fw-bolder">{{ \App\Helper\CustomerTransferHelper::getNameBeneficiaire($beneficiaire) }}</div>
                        </div>
                        {{ $beneficiaire->iban }}
                        <i class="fa-solid fa-angle-right"></i>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.transfer.beneficiaire")
@endsection
