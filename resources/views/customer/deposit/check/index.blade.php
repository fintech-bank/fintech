@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Dépot de chèque</h1>
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
            <li class="breadcrumb-item text-dark">Dépot de chèque</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="row mb-10">
        <div class="col-4">
            <div class="card card-flush shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Limite de dépot (<div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="{{ \App\Helper\CustomerDepositCheckHelper::getAmountMonthDeposit($customer) }}" data-kt-countup-suffix="€" data-kt-countup-separator="," data-kt-countup-decimal-places="2">0</div> / {{ $customer->info->type == 'part' ? eur(\App\Helper\CustomerDepositCheckHelper::$limit_deposit_month_part) : eur(\App\Helper\CustomerDepositCheckHelper::$limit_deposit_month_pro) }})</h3>
                </div>
                <div class="card-body py-5">
                    <div id="chart_gauge_deposit" style="height: 300px;"></div>
                </div>

            </div>
        </div>
        <div class="col-8">
            <img src="/storage/depot_check_manual.png" alt="" class="img-fluid" />
        </div>
    </div>
    <div class="card card-flush shadow-sm">
        <div class="card-header">
            <h3 class="card-title">Liste de mes dépots de chèques</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#CheckDeposit">
                    <i class="fa-solid fa-plus-circle me-3"></i> Nouveau dépot
                </button>
            </div>
        </div>
        <div class="card-body py-5">
            <table class="table table-striped table-hover gy-7 gx-7" id="list_check_deposit">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Montant</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($wallets as $wallet)
                        @foreach($wallet->deposits as $deposit)
                            <tr>
                                <td>{{ $deposit->reference }}</td>
                                <td>{{ eur($deposit->amount) }}</td>
                                <td>{!! $deposit->status_label !!}</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-icon btn-bank viewCheck" data-deposit="{{ $deposit->id }}" data-bs-toggle="tooltip" title="Voir les chèques"><i class="fa-solid fa-eye"></i> </button>
                                    @if($deposit->state == 'pending')
                                        <button class="btn btn-sm btn-icon btn-danger deleteDeposit" data-deposit="{{ $deposit->id }}" data-bs-toggle="tooltip" title="Supprimer la remise"><i class="fa-solid fa-xmark-circle"></i> </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="CheckDeposit" data-bs-focus="false">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Nouveau dépot de chèque</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fa-lg text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="formCheckDeposit" action="{{ route('customer.deposit.check.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="customer_wallet_id" class="form-label required">Compte à crédité</label>
                            <select id="customer_wallet_id" class="form-select form-select-solid" data-control="select2" name="customer_wallet_id" data-placeholder="Selectionnez un compte à crédité" data-allow-clear="true" required>
                                <option></option>
                                @foreach($customer->wallets()->where('type', 'compte')->where('status', 'active')->get() as $wallet)
                                    <option value="{{ $wallet->id }}">{{ \App\Helper\CustomerWalletHelper::getNameAccount($wallet) }}</option>
                                @endforeach
                                @foreach($customer->wallets()->where('type', 'epargne')->where('status', 'active')->get() as $wallet)
                                    <option value="{{ $wallet->id }}">{{ \App\Helper\CustomerWalletHelper::getNameAccount($wallet) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="kt_docs_repeater_basic">
                            <div class="form-group">
                                <div data-repeater-list="check_lists">
                                    <div data-repeater-item>
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label class="form-label">Numéro de chèque:</label>
                                                <input type="text" name="number[]" class="form-control mb-2 mb-md-0" placeholder="1234567" />
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label">Montant:</label>
                                                <input type="text" name="amount[]" class="form-control mb-2 mb-md-0" placeholder="12.00" />
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Dépositaire:</label>
                                                <input type="text" name="name_deposit[]" class="form-control mb-2 mb-md-0" placeholder="John Doe" />
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Banque Dépositaire:</label>
                                                <input type="text" name="bank_deposit[]" class="form-control mb-2 mb-md-0" placeholder="Crédit Mutuel" />
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label">Date du chèque:</label>
                                                <input type="text" name="date_deposit[]" class="form-control mb-2 mb-md-0" placeholder="01/01/1970" />
                                            </div>
                                            <div class="col-md-1">
                                                <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                    <i class="la la-trash-o"></i>Supprimer
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-repeater-item>
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label class="form-label">Numéro de chèque:</label>
                                                <input type="text" name="number[]" class="form-control mb-2 mb-md-0" placeholder="1234567" />
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label">Montant:</label>
                                                <input type="text" name="amount[]" class="form-control mb-2 mb-md-0" placeholder="12.00" />
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Dépositaire:</label>
                                                <input type="text" name="name_deposit[]" class="form-control mb-2 mb-md-0" placeholder="John Doe" />
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Banque Dépositaire:</label>
                                                <input type="text" name="bank_deposit[]" class="form-control mb-2 mb-md-0" placeholder="Crédit Mutuel" />
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label">Date du chèque:</label>
                                                <input type="text" name="date_deposit[]" class="form-control mb-2 mb-md-0" placeholder="01/01/1970" />
                                            </div>
                                            <div class="col-md-1">
                                                <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                    <i class="la la-trash-o"></i>Supprimer
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-repeater-item>
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label class="form-label">Numéro de chèque:</label>
                                                <input type="text" name="number[]" class="form-control mb-2 mb-md-0" placeholder="1234567" />
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label">Montant:</label>
                                                <input type="text" name="amount[]" class="form-control mb-2 mb-md-0" placeholder="12.00" />
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Dépositaire:</label>
                                                <input type="text" name="name_deposit[]" class="form-control mb-2 mb-md-0" placeholder="John Doe" />
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Banque Dépositaire:</label>
                                                <input type="text" name="bank_deposit[]" class="form-control mb-2 mb-md-0" placeholder="Crédit Mutuel" />
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label">Date du chèque:</label>
                                                <input type="text" name="date_deposit[]" class="form-control mb-2 mb-md-0" placeholder="01/01/1970" />
                                            </div>
                                            <div class="col-md-1">
                                                <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                    <i class="la la-trash-o"></i>Supprimer
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-repeater-item>
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label class="form-label">Numéro de chèque:</label>
                                                <input type="text" name="number[]" class="form-control mb-2 mb-md-0" placeholder="1234567" />
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label">Montant:</label>
                                                <input type="text" name="amount[]" class="form-control mb-2 mb-md-0" placeholder="12.00" />
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Dépositaire:</label>
                                                <input type="text" name="name_deposit[]" class="form-control mb-2 mb-md-0" placeholder="John Doe" />
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Banque Dépositaire:</label>
                                                <input type="text" name="bank_deposit[]" class="form-control mb-2 mb-md-0" placeholder="Crédit Mutuel" />
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label">Date du chèque:</label>
                                                <input type="text" name="date_deposit[]" class="form-control mb-2 mb-md-0" placeholder="01/01/1970" />
                                            </div>
                                            <div class="col-md-1">
                                                <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                    <i class="la la-trash-o"></i>Supprimer
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-repeater-item>
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label class="form-label">Numéro de chèque:</label>
                                                <input type="text" name="number[]" class="form-control mb-2 mb-md-0" placeholder="1234567" />
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label">Montant:</label>
                                                <input type="text" name="amount[]" class="form-control mb-2 mb-md-0" placeholder="12.00" />
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Dépositaire:</label>
                                                <input type="text" name="name_deposit[]" class="form-control mb-2 mb-md-0" placeholder="John Doe" />
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Banque Dépositaire:</label>
                                                <input type="text" name="bank_deposit[]" class="form-control mb-2 mb-md-0" placeholder="Crédit Mutuel" />
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label">Date du chèque:</label>
                                                <input type="text" name="date_deposit[]" class="form-control mb-2 mb-md-0" placeholder="01/01/1970" />
                                            </div>
                                            <div class="col-md-1">
                                                <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                    <i class="la la-trash-o"></i>Supprimer
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div data-repeater-item>
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label class="form-label">Numéro de chèque:</label>
                                                <input type="text" name="number[]" class="form-control mb-2 mb-md-0" placeholder="1234567" />
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label">Montant:</label>
                                                <input type="text" name="amount[]" class="form-control mb-2 mb-md-0" placeholder="12.00" />
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Dépositaire:</label>
                                                <input type="text" name="name_deposit[]" class="form-control mb-2 mb-md-0" placeholder="John Doe" />
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Banque Dépositaire:</label>
                                                <input type="text" name="bank_deposit[]" class="form-control mb-2 mb-md-0" placeholder="Crédit Mutuel" />
                                            </div>
                                            <div class="col-md-1">
                                                <label class="form-label">Date du chèque:</label>
                                                <input type="text" name="date_deposit[]" class="form-control mb-2 mb-md-0" placeholder="01/01/1970" />
                                            </div>
                                            <div class="col-md-1">
                                                <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                    <i class="la la-trash-o"></i>Supprimer
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!--end::Form group-->

                        <!--begin::Form group-->
                        <div class="form-group mt-5">
                            <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                <i class="la la-plus"></i> Ajouter
                            </a>
                        </div>
                        <!--end::Form group-->
                    </div>
                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="viewCheck">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white" data-content="title"></h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <table class="table table-striped table-hover gy-5 gs-5" id="liste_checks">
                        <thead>
                            <tr>
                                <th>Numero</th>
                                <th>Montant</th>
                                <th>Depositaire</th>
                                <th>Date de dépot</th>
                                <th>Vérifié</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="liste_checks_content"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="/assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    @include("customer.scripts.deposit.check.index")
@endsection
