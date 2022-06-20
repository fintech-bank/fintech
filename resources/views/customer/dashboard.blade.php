@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Tableau de Bord</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.dashboard') }}" class="text-muted text-hover-primary">{{ \App\Helper\CustomerHelper::getName($customer) }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Tableau de Bord</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <h3 class="fw-bolder fs-2 mb-10">TOUS MES COMPTES</h3>
    <div class="mb-3 fs-4">Comptes Courants</div>
    @foreach($customer->wallets()->where('type', 'compte')->get() as $wallet)
    <div class="d-flex flex-row justify-content-between align-items-center bg-white h-100px p-5 text-dark rounded-2 mb-5 account" data-account="{{ $wallet->id }}" style="cursor: pointer">
        <div class="fw-bolder">Compte Individuel</div>
        <div class="d-flex flex-column">
            <div class="fw-bolder">{{ \App\Helper\CustomerHelper::getName($customer) }}</div>
            @if($wallet->balance_coming != 0)
            <div class="text-muted">Prochaines opérations: {{ eur($wallet->balance_coming) }}</div>
            @endif
        </div>
        <button type="button" class="btn btn-sm btn-rounded btn-outline btn-outline-bank rotate" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="30px, 30px">
            Gérez <i class="fa-solid fa-caret-down ms-3"></i>
        </button>
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-250px pt-5 pb-5" data-kt-menu="true">
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3">
                    Afficher le RIB / IBAN
                </a>
            </div>
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3">
                    Faire un virement depuis ce compte
                </a>
            </div>
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3">
                    Faire un virement vers ce compte
                </a>
            </div>
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3">
                    Télécharger les opérations
                </a>
            </div>
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3">
                    Voir le détail du compte
                </a>
            </div>
        </div>
        <!--end::Menu-->
        {!! \App\Helper\CustomerWalletHelper::getStatusWallet($wallet->status, true) !!}
        @if($wallet->balance_actual <= 0)
            <span class="text-danger">{{ eur($wallet->balance_actual) }} <i class="fa-solid fa-arrow-right fa-lg ms-2"></i></span>
        @else
            <span class="text-success">{{ eur($wallet->balance_actual) }} <i class="fa-solid fa-arrow-right fa-lg ms-2"></i></span>
        @endif
    </div>
    @endforeach
    <div class="mb-3 fs-4">Epargnes disponible</div>
    @foreach($customer->wallets()->where('type', 'epargne')->get() as $wallet)
        <div class="d-flex flex-row justify-content-between align-items-center bg-white h-100px p-5 text-dark rounded-2 mb-5 account" data-account="{{ $wallet->id }}" style="cursor: pointer">
            <div class="fw-bolder">{{ $wallet->epargne->plan->name }}</div>
            <div class="d-flex flex-column">
                <div class="fw-bolder">{{ \App\Helper\CustomerHelper::getName($customer) }}</div>
                @if($wallet->balance_coming != 0)
                    <div class="text-muted">Prochaines opérations: {{ eur($wallet->balance_coming) }}</div>
                @endif
            </div>
            <button type="button" class="btn btn-sm btn-rounded btn-outline btn-outline-bank rotate" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="30px, 30px">
                Gérez <i class="fa-solid fa-caret-down ms-3"></i>
            </button>
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-250px pt-5 pb-5" data-kt-menu="true">
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3">
                        Faire un virement depuis ce compte
                    </a>
                </div>
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3">
                        Faire un virement vers ce compte
                    </a>
                </div>
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3">
                        Télécharger les opérations
                    </a>
                </div>
                <div class="menu-item px-3">
                    <a href="#" class="menu-link px-3">
                        Voir le détail du compte
                    </a>
                </div>
            </div>
            {!! \App\Helper\CustomerWalletHelper::getStatusWallet($wallet->status, true) !!}
            <!--end::Menu-->
            @if($wallet->balance_actual <= 0)
                <span class="text-danger">{{ eur($wallet->balance_actual) }} <i class="fa-solid fa-arrow-right fa-lg ms-2"></i></span>
            @else
                <span class="text-success">{{ eur($wallet->balance_actual) }} <i class="fa-solid fa-arrow-right fa-lg ms-2"></i></span>
            @endif
        </div>
    @endforeach
    <div class="mb-3 fs-4">Crédits</div>
    @foreach($customer->wallets()->where('type', 'pret')->get() as $wallet)
        <div class="d-flex flex-row justify-content-between align-items-center bg-white h-100px p-5 text-dark rounded-2 mb-5 account" data-account="{{ $wallet->id }}" style="cursor: pointer">
            <div class="fw-bolder">{{ $wallet->loan->plan->name }}</div>
            <div class="d-flex flex-column">
                <div class="fw-bolder">{{ \App\Helper\CustomerHelper::getName($customer) }}</div>
                @if($wallet->balance_coming != 0)
                    <div class="text-muted">Prochaines opérations: {{ eur($wallet->balance_coming) }}</div>
                @endif
            </div>
            <!--end::Menu-->
            {!! \App\Helper\CustomerWalletHelper::getStatusWallet($wallet->status, true) !!}
            @if($wallet->balance_actual <= 0)
                <span class="text-danger">{{ eur($wallet->balance_actual) }} <i class="fa-solid fa-arrow-right fa-lg ms-2"></i></span>
            @else
                <span class="text-success">{{ eur($wallet->balance_actual) }} <i class="fa-solid fa-arrow-right fa-lg ms-2"></i></span>
            @endif
        </div>
    @endforeach
@endsection

@section("script")
    @include("customer.scripts.dashboard")
@endsection
