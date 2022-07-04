@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Mes Virements</h1>
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
            <li class="breadcrumb-item text-dark">Mes Virements</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="d-flex flex-row justify-content-between align-items-center bg-white p-10 mb-10 rounded-2">
        <div class="d-flex flex-column">
            <a href="{{ route('customer.dashboard') }}" class="d-flex flex-row align-items-center text-dark mb-5">
                <i class="fa-solid fa-arrow-left me-2"></i>
                Retour
            </a>
            <div class="fs-1 fw-bold">Mes Virements</div>
        </div>
        <a href="" class="btn btn-outline btn-outline-bank btn-active-light-primary btn-lg"><i class="fa-solid fa-plus me-3"></i> Nouveau virement</a>
    </div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-toolbar">
                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#history">Historique</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#permanents">Permanents</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="history" role="tabpanel">
                    <!--begin::Menu-->
                    <div class="menu menu-rounded menu-column menu-active-bg menu-gray-600 menu-state-bg fw-bold" data-kt-menu="true">

                        <!--begin::Menu item-->
                        @foreach($customer->wallets()->where('type', '!=', 'pret')->where('status', 'active')->get() as $wallet)
                            @foreach($wallet->transfers()->where('type', '!=', 'permanent')->get() as $virement)
                                <div class="menu-item">
                                    <a href="#" class="menu-link border-3 border-start border-transparent py-5 d-flex flex-row justify-content-between show" data-transfer="{{ $virement->id }}">
                                        <span class="menu-title">{{ $virement->reason }}</span>
                                        <span class="me-10">{{ $virement->transfer_date->format('d/m/Y') }}</span>
                                        <span class="me-3">{{ eur($virement->amount) }}</span>
                                        <i class="fa-solid fa-caret-right"></i>
                                    </a>
                                </div>
                            @endforeach
                        @endforeach
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div>
                <div class="tab-pane fade" id="permanents" role="tabpanel">
                    <div class="menu menu-rounded menu-column menu-active-bg menu-gray-600 menu-state-bg fw-bold" data-kt-menu="true">

                        <!--begin::Menu item-->
                        @foreach($customer->wallets()->where('type', '!=', 'pret')->where('status', 'active')->get() as $wallet)
                            @foreach($wallet->transfers()->where('type', 'permanent')->get() as $virement)
                                <div class="menu-item">
                                    <a href="#" class="menu-link border-3 border-start border-transparent py-5 d-flex flex-row justify-content-between show" data-transfer="{{ $virement->id }}">
                                        <span class="menu-title">{{ $virement->reason }}</span>
                                        <span class="me-10">{{ $virement->recurring_start->format('d/m/Y') }} au {{ $virement->recurring_end->format('d/m/Y') }}</span>
                                        <span class="me-10 btn btn-outline btn-sm btn-outline-bank">Tous les mois</span>
                                        <span class="me-3">{{ eur($virement->amount) }}</span>
                                        <i class="fa-solid fa-caret-right"></i>
                                    </a>
                                </div>
                        @endforeach
                    @endforeach
                    <!--end::Menu item-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--begin::View component-->
    <div
        id="drawerInfoTransfer"

        class="bg-white"
        data-kt-drawer="true"
        data-kt-drawer-activate="true"
        data-kt-drawer-close="#kt_drawer_example_basic_close"
        data-kt-drawer-overlay="true"
        data-kt-drawer-width="500px"
    >
        <div class="card rounded-0 w-100" id="cardInfoTransfer">
            <!--begin::Card header-->
            <div class="card-header pe-5">
                <!--begin::Title-->
                <div class="card-title">
                    <!--begin::User-->
                    <div class="d-flex justify-content-center flex-column me-3">
                        <span class="fs-4 fw-bolder text-gray-900 text-hover-primary me-1 lh-1 text-center">Détails</span>
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-light-primary" id="kt_drawer_example_basic_close" data-kt-drawer-dismiss="true">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-2">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
								<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
							</svg>
						</span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body hover-scroll-overlay-y">
                <div class="fs-1" data-virement="reference">Virement N°FRD78554DF</div>
                <div class="separator my-10"></div>
                <div class="d-flex flex-column mb-10">
                    <div class="d-flex flex-row align-items-center fs-3 mb-2">
                        <i class="fa-solid fa-right-from-bracket me-3"></i> Depuis le compte
                    </div>
                    <div class="d-flex flex-row align-items-center fs-6" data-virement="wallet_bank">
                        <div class="symbol symbol-20px symbol-2by3 me-2">
                            <div class="symbol-label" style="background-image:url(https://web.bankin.com/img/banks-logo/france/07_CIC@2x.png)"></div>
                        </div>
                        <span class="bank_name">CIC Banque Privée</span>
                    </div>
                    <div class="d-flex flex-row align-items-center fs-5" data-virement="wallet_name">
                        <div class="fw-bolder">M. MOCKELYN Maxime</div>
                    </div>
                    <div class="d-flex flex-row align-items-center fs-5" data-virement="wallet_account">
                        <div class="fw-normal">Compte Chèque N°32251255410</div>
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <div class="d-flex flex-row align-items-center fs-3 mb-2">
                        <i class="fa-solid fa-right-to-bracket me-3"></i> Vers le compte
                    </div>
                    <div class="d-flex flex-row align-items-center fs-6" data-virement="beneficiaire_bank">
                        <div class="symbol symbol-20px symbol-2by3 me-2">
                            <div class="symbol-label" style="background-image:url(https://web.bankin.com/img/banks-logo/france/07_CIC@2x.png)"></div>
                        </div>
                        <span class="bank_name">CIC Banque Privée</span>
                    </div>
                    <div class="d-flex flex-row align-items-center fs-5" data-virement="beneficiaire_name">
                        <div class="fw-bolder">M. MOCKELYN Maxime</div>
                    </div>
                    <div class="d-flex flex-row align-items-center fs-5" data-virement="beneficiaire_account">
                        <div class="fw-normal">DE93 1001 1001 2627 1026 84</div>
                    </div>
                </div>
                <div class="separator border-3 my-10"></div>
                <div class="d-flex flex-column mb-5">
                    <div class="fs-6 text-grey-700">Status</div>
                    <div class="fs-4 fw-bolder" data-virement="status">Exécuté</div>
                </div>
                <div class="d-flex flex-column mb-5">
                    <div class="fs-6 text-grey-700">Montant</div>
                    <div class="fs-4 fw-bolder" data-virement="amount">650,00 €</div>
                </div>
                <div class="d-flex flex-column mb-5">
                    <div class="fs-6 text-grey-700">Motif</div>
                    <div class="fs-4 fw-bolder" data-virement="reason">Virement de M MAXIME MOCKELYN</div>
                </div>
                <div class="d-flex flex-column mb-5">
                    <div class="fs-6 text-grey-700">Type</div>
                    <div class="fs-4 fw-bolder" data-virement="type">Immédiat</div>
                </div>
                <div class="d-flex flex-column mb-5">
                    <div class="fs-6 text-grey-700">Date</div>
                    <div class="fs-4 fw-bolder" data-virement="transfer_date">9 Juin 2022</div>
                </div>
                <div id="permanent_transfer" class="d-none">
                    <div class="d-flex flex-column mb-5">
                        <div class="fs-6 text-grey-700">Périodicité</div>
                        <div class="fs-4 fw-bolder">Tous les mois</div>
                    </div>
                    <div class="d-flex flex-column mb-5">
                        <div class="fs-6 text-grey-700">Date de début</div>
                        <div class="fs-4 fw-bolder" data-virement="recurring_start">09/07/2022</div>
                    </div>
                    <div class="d-flex flex-column mb-5">
                        <div class="fs-6 text-grey-700">Date de Fin</div>
                        <div class="fs-4 fw-bolder" data-virement="recurring_end">09/07/2024</div>
                    </div>
                </div>
            </div>
            <!--end::Card body-->
            <!--begin::Card footer-->
            <div class="card-footer d-flex flex-wrap justify-content-center">
                <!--begin::Dismiss button-->
                <a href="" class="btn btn-bank w-100 mb-2 edit">Modifier</a>
                <a href="" class="btn btn-outline btn-outline-bank w-100 mb-2 delete">Supprimer</a>
                <!--end::Dismiss button-->
                <button class="btn btn-secondary w-100 print" data-href=""><i class="fa-solid fa-print me-2"></i> Imprimer le récapitulatif</button>
                <!--end::Dismiss button-->
            </div>
            <!--end::Card footer-->
        </div>
    </div>
    <!--end::View component-->
    <div class="modal fade" tabindex="-1" id="EditVirement">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edition d'un Virement</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmarks fa-2x text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formEditVirement" action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <x-form.input
                            name="amount"
                            type="text"
                            label="Montant" />

                        <x-form.input-date
                            name="recurring_end"
                            type="text"
                            label="Date de fin" />
                    </div>

                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.transfer.history")
@endsection
