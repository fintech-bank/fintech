@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">{{ \App\Helper\CustomerWalletHelper::getTypeWallet($wallet->type) }} N° {{ $wallet->number_account }}</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('customer.dashboard') }}" class="text-muted text-hover-primary">{{ \App\Helper\CustomerHelper::getName($wallet->customer) }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">{{ \App\Helper\CustomerWalletHelper::getTypeWallet($wallet->type) }} N° {{ $wallet->number_account }}</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <a href="{{ route('customer.dashboard') }}" class="d-flex flex-row align-items-center text-dark mb-5">
        <i class="fa-solid fa-arrow-left me-2"></i>
        Retour
    </a>
    @if($wallet->type == 'compte')
        <div class="d-flex flex-row justify-content-between align-items-center p-5 bg-white rounded mb-15 shadow-lg">
            <div class="d-flex flex-column">
                <div class="fs-1">{{ \App\Helper\CustomerWalletHelper::getTypeWallet($wallet->type) }}</div>
                {{ $wallet->number_account }} {{ $wallet->customer->user->agency->name }}
            </div>
            <div class="d-flex flex-column justify-content-center">
                @if($wallet->balance_actual < 0)
                    <span class="fs-1 text-danger fw-bolder">{{ eur($wallet->balance_actual) }}</span>
                @else
                    <span class="fs-1 text-success fw-bolder">+ {{ eur($wallet->balance_actual) }}</span>
                @endif
                <div class="text-muted text-center">Solde Actuel</div>
            </div>
            <div class="d-flex flex-column justify-content-end fs-4">
                <div class="d-flex flex-row justify-content-between w-400px">
                    <div class="fw-bolder">Prochaines Opérations</div>
                    <div class="text-end">{{ \App\Helper\CustomerWalletHelper::getSumMonthOperation($wallet) >= 0 ? '+ '.eur(\App\Helper\CustomerWalletHelper::getSumMonthOperation($wallet)) :  eur(\App\Helper\CustomerWalletHelper::getSumMonthOperation($wallet))}}</div>
                </div>
                <div class="d-flex flex-row justify-content-between w-400px">
                    <div class="fw-bolder">Titulaire</div>
                    <div class="text-end">{{ \App\Helper\CustomerHelper::getName($wallet->customer) }}</div>
                </div>
                <div class="d-flex flex-row justify-content-between w-400px">
                    <div class="fw-bolder">Découvert Autorisée</div>
                    <div class="text-end">{{ eur($wallet->balance_decouvert) }}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-9">
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
                                <input type="text" data-kt-transaction-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Rechercher une transaction" />
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#history">Historique</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#coming">A Venir</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="history" role="tabpanel">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="liste_transaction">
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                    @foreach($wallet->transactions()->whereBetween('confirmed_at', [now()->startOfMonth(), now()->endOfMonth()])->where('confirmed', true)->orderBy('confirmed_at', 'desc')->get() as $transaction)
                                        <tr>
                                            <td>
                                                {!! \App\Helper\CustomerTransactionHelper::getTypeTransaction($transaction->type, false, true) !!}
                                            </td>
                                            <td>
                                                <div class="fw-bolder fs-5">{{ $transaction->designation }}</div>
                                                <div class="text-muted">{{ $transaction->created_at->format('d/m/Y') }}</div>
                                            </td>
                                            <td class="text-end">
                                                @if($transaction->amount < 0)
                                                    <span class="text-danger">{{ eur($transaction->amount) }}</span>
                                                @else
                                                    <span class="text-success">+ {{ eur($transaction->amount) }}</span>
                                                @endif
                                            </td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                            </div>
                            <div class="tab-pane fade" id="coming" role="tabpanel">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="liste_transaction_coming">
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                    @foreach($wallet->transactions()->whereBetween('updated_at', [now()->startOfMonth(), now()->endOfMonth()])->where('confirmed', false)->orderBy('updated_at', 'desc')->get() as $transaction)
                                        <tr>
                                            <td>
                                                {!! \App\Helper\CustomerTransactionHelper::getTypeTransaction($transaction->type, false, true) !!}
                                            </td>
                                            <td>
                                                <div class="fw-bolder fs-5">{{ $transaction->designation }}</div>
                                                <div class="text-muted">{{ $transaction->updated_at->format('d/m/Y') }}</div>
                                            </td>
                                            <td class="text-end">
                                                @if($transaction->amount < 0)
                                                    <span class="text-danger">{{ eur($transaction->amount) }}</span>
                                                @else
                                                    <span class="text-success">+ {{ eur($transaction->amount) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($transaction->type == 'sepa')
                                                    @if($transaction->updated_at->startOfDay() == now()->startOfDay())
                                                        <button class="btn btn-icon btn-circle btn-danger btn-sm reject" data-transaction="{{ $transaction->id }}" data-bs-toggle="tooltip" title="Rejeter la transaction"><i class="fa-solid fa-xmark"></i> </button>
                                                    @endif
                                                @endif
                                                @if($transaction->type == 'payment')
                                                    @if($transaction->updated_at->startOfDay() == now()->startOfDay())
                                                        <button class="btn btn-icon btn-circle btn-danger btn-sm reject" data-transaction="{{ $transaction->id }}" data-bs-toggle="tooltip" title="Rejeter la transaction"><i class="fa-solid fa-xmark"></i> </button>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <!--begin::Menu-->
                        <div class="menu menu-rounded menu-column menu-gray-600 menu-state-bg fw-bold " data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item">
                                <a href="#" data-wallet="{{ $wallet->id }}" class="menu-link py-3 showRib">
                                    <span class="menu-title">Afficher RIB/IBAN</span>
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item">
                                <a href="#" class="menu-link py-3">
                                    <span class="menu-title">Faire un virement depuis ce compte</span>
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item">
                                <a href="#" class="menu-link py-3">
                                    <span class="menu-title">Faire un virement vers ce compte</span>
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item">
                                <a href="#" data-wallet="{{ $wallet->id }}" class="menu-link py-3 showExport">
                                    <span class="menu-title">Télécharger des opérations</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($wallet->type == 'epargne')
        <div class="d-flex flex-row justify-content-between align-items-center p-5 bg-white rounded mb-15 shadow-lg">
            <div class="d-flex flex-column">
                <div class="fs-1">{{ \App\Helper\CustomerWalletHelper::getTypeWallet($wallet->type) }}</div>
                {{ $wallet->number_account }} {{ $wallet->customer->user->agency->name }}
            </div>
            <div class="d-flex flex-column justify-content-center">
                @if($wallet->balance_actual < 0)
                    <span class="fs-1 text-danger fw-bolder">{{ eur($wallet->balance_actual) }}</span>
                @else
                    <span class="fs-1 text-success fw-bolder">+ {{ eur($wallet->balance_actual) }}</span>
                @endif
                <div class="text-muted text-center">Solde Actuel</div>
            </div>
            <div class="d-flex flex-column justify-content-end fs-4">
                <div class="d-flex flex-row justify-content-between w-400px">
                    <div class="fw-bolder">Titulaire</div>
                    <div class="text-end">{{ \App\Helper\CustomerHelper::getName($wallet->customer) }}</div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-9">
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
                                <input type="text" data-kt-transaction-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Rechercher une transaction" />
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#history">Historique</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#coming">A Venir</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="history" role="tabpanel">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="liste_transaction">
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                    @foreach($wallet->transactions()->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->where('confirmed', true)->orderBy('created_at', 'desc')->get() as $transaction)
                                        <tr>
                                            <td>
                                                {!! \App\Helper\CustomerTransactionHelper::getTypeTransaction($transaction->type, false, true) !!}
                                            </td>
                                            <td>
                                                <div class="fw-bolder fs-5">{{ $transaction->designation }}</div>
                                                <div class="text-muted">{{ $transaction->created_at->format('d/m/Y') }}</div>
                                            </td>
                                            <td class="text-end">
                                                @if($transaction->amount < 0)
                                                    <span class="text-danger">{{ eur($transaction->amount) }}</span>
                                                @else
                                                    <span class="text-success">+ {{ eur($transaction->amount) }}</span>
                                                @endif
                                            </td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                            </div>
                            <div class="tab-pane fade" id="coming" role="tabpanel">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="liste_transaction_coming">
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                    @foreach($wallet->transactions()->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->where('confirmed', false)->orderBy('created_at', 'desc')->get() as $transaction)
                                        <tr>
                                            <td>
                                                {!! \App\Helper\CustomerTransactionHelper::getTypeTransaction($transaction->type, false, true) !!}
                                            </td>
                                            <td>
                                                <div class="fw-bolder fs-5">{{ $transaction->designation }}</div>
                                                <div class="text-muted">{{ $transaction->updated_at->format('d/m/Y') }}</div>
                                            </td>
                                            <td class="text-end">
                                                @if($transaction->amount < 0)
                                                    <span class="text-danger">{{ eur($transaction->amount) }}</span>
                                                @else
                                                    <span class="text-success">+ {{ eur($transaction->amount) }}</span>
                                                @endif
                                            </td>
                                            <td></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
            </div>
        </div>
    @endif
    @if($wallet->type == 'pret')

    @endif
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
    @include("customer.scripts.wallet.index")
@endsection
