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
    <div class="row">
        <div class="col-9">
            <h3 class="fw-bolder fs-2 mb-10">TOUS MES COMPTES</h3>
            <div class="mb-3 fs-4">Comptes Courants</div>
            @foreach($customer->wallets()->where('type', 'compte')->get() as $wallet)
                <div class="d-flex flex-row justify-content-between align-items-center bg-white h-100px p-5 text-dark rounded-2 mb-5" data-account="{{ $wallet->id }}" style="cursor: pointer">
                    <div class="fw-bolder">Compte Individuel</div>
                    <div class="d-flex flex-column">
                        <div class="fw-bolder">{{ \App\Helper\CustomerHelper::getName($customer) }}</div>
                        @if($wallet->balance_coming != 0)
                            <div class="text-muted">Prochaines opérations: {{ eur($wallet->balance_coming) }}</div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-sm btn-rounded btn-outline btn-outline-bank rotate" data-kt-menu-trigger="hover" data-kt-menu-placement="bottom-start" data-kt-menu-offset="30px, 30px">
                        Gérez <i class="fa-solid fa-caret-down ms-3"></i>
                    </button>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-250px pt-5 pb-5" data-kt-menu="true">
                        <div class="menu-item px-3">
                            <a data-wallet="{{ $wallet->id }}" class="menu-link px-3 showRib">
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
                            <a data-wallet="{{ $wallet->id }}" class="menu-link px-3 showExport">
                                Télécharger les opérations
                            </a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="{{ route('customer.wallet.index', $wallet->id) }}" class="menu-link px-3">
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
        </div>
        <div class="col-3">
            <div class="card mb-5">
                <!--begin::Body-->
                <div class="card-body d-flex flex-column flex-center">
                    <!--begin::Heading-->
                    <div class="mb-2">
                        <!--begin::Title-->
                        <h1 class="fw-bold text-gray-800 text-center lh-lg">Vous prévoyez une dépense exceptionnelle ?</h1>
                        <h6 class="text-muted text-center">Modifiez temporairement les plafonds de votre carte en quelques clics*.</h6>
                        <!--end::Title-->
                        <!--begin::Illustration-->
                        <div class="flex-grow-1 bgi-no-repeat bgi-size-contain bgi-position-x-center card-rounded-bottom h-200px mh-200px my-5 my-lg-12" style="background-image:url('/assets/media/svg/shapes/abstract-4.svg')"></div>
                        <!--end::Illustration-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Links-->
                    <div class="text-center mb-1">
                        <!--begin::Link-->
                        <a class="btn btn-sm btn-primary me-2" data-bs-target="#kt_modal_new_card" data-bs-toggle="modal">Changer mon plafond</a>
                        <!--end::Link-->
                        <!--begin::Link-->
                        <a class="btn btn-sm btn-light" href="/metronic8/demo1/../demo1/pages/user-profile/followers.html">En savoir plus</a>
                        <!--end::Link-->
                    </div>
                    <!--end::Links-->
                </div>
                <!--end::Body-->
            </div>
            <div class="card mb-5">
                <!--begin::Body-->
                <div class="card-body d-flex flex-column flex-center">
                    <!--begin::Heading-->
                    <div class="mb-2">
                        <!--begin::Title-->
                        <h1 class="fw-bold text-gray-800 text-center lh-lg">Besoins d'aide ?</h1>
                        <h6 class="text-muted text-center">La réponse se trouve peut être déjà dans la F.A.Q dédiée à votre espace banque à distance.</h6>
                        <!--end::Title-->
                        <!--begin::Illustration-->
                        <div class="flex-grow-1 bgi-no-repeat bgi-size-contain bgi-position-x-center card-rounded-bottom h-200px mh-200px my-5 my-lg-12" style="background-image:url('/assets/media/illustrations/dozzy-1/1.png')"></div>
                        <!--end::Illustration-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Links-->
                    <div class="text-center mb-1">
                        <!--begin::Link-->
                        <a class="btn btn-sm btn-light" href="/metronic8/demo1/../demo1/pages/user-profile/followers.html">Voir la FAQ</a>
                        <!--end::Link-->
                    </div>
                    <!--end::Links-->
                </div>
                <!--end::Body-->
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="show_rib">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Afficher RIB / IBAN</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-times fa-2x text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="text-center mb-10">
                        <div class="fs-1" data-div="type"></div>
                        <div class="fs-3">
                            <span data-div="number_account"></span>
                            <span data-div="agency"></span> -
                            <span data-div="customer"></span>
                        </div>
                    </div>

                    <div class="d-flex flex-row justify-content-between align-items-center mb-5 border-bottom">
                        <div class="d-flex flex-column">
                            <div class="fs-2">IBAN</div>
                            <div class="fs-4" data-div="iban"></div>
                        </div>
                        <!-- COPY -->
                    </div>
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <div class="d-flex flex-column">
                            <div class="fs-2">BIC</div>
                            <div class="fs-4" data-div="bic"></div>
                        </div>
                        <!-- COPY -->
                    </div>
                </div>

                <div class="modal-footer d-flex flex-wrap">
                    <a href="" target="_blank" class="btn btn-bank w-100">Télécharger</a>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="export_account">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Export d'écriture</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-times fa-lg text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formExportAccount" action="/api/wallet/{{ $wallet->id }}/exportAccount" method="POST">
                    <div class="modal-body">
                        <x-form.input-date
                            name="start"
                            type="text"
                            label="Date de début" />

                        <x-form.input-date
                            name="end"
                            type="text"
                            label="Date de fin" />
                    </div>

                    <div class="modal-footer d-flex flex-wrap">
                        <button type="submit" class="btn btn-bank w-100">Télécharger</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.dashboard")
@endsection
