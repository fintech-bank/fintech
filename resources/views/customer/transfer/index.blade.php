@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Virement Bancaire</h1>
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
            <li class="breadcrumb-item text-dark">Virement Bancaire</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="row">
        <div class="col-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Effectuer un virement bancaire</h3>
                </div>
                <form id="formAddTransfer" action="{{ route('customer.transfer.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <x-form.input-group
                            name="amount"
                            label="Je fais un virement de"
                            symbol="€"
                            placement="left"
                            placeholder="0.00"
                            required="true" onchange="formTransferIsNotEmpty()" />

                        <div class="mb-10">
                            <label for="customer_wallet_id" class="form-label required">Depuis le compte</label>
                            <select name="customer_wallet_id" id="customer_wallet_id" class="form-control form-select bank_select" data-placeholder="Selectionner un compte à débité" onchange="formTransferIsNotEmpty()">
                                <option value=""></option>
                                @foreach($customer->wallets()->where('type', '!=', 'pret')->where('status', 'active')->get() as $wallet)
                                    <option value="{{ $wallet->id }}" data-bank="FINBANK" data-bank-logo="/storage/logo/logo_carre.png" data-type="{{ \App\Helper\CustomerWalletHelper::getTypeWallet($wallet->type) }}" data-account="{{ $wallet->number_account }}" data-customer="{{ \App\Helper\CustomerHelper::getName($wallet->customer) }}" data-solde="{{ $wallet->balance_actual >= 0 ? '+ '.eur($wallet->balance_actual) : '- '.eur($wallet->balance_actual)}}" data-solde-style="{{ $wallet->balance_actual >= 0 ? 'text-success' : 'text-danger' }}"></option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-10">
                            <label for="customer_beneficiaire_id" class="form-label required">Vers le compte</label>
                            <select name="customer_beneficiaire_id" id="customer_beneficiaire_id" class="form-control form-select bank_select" data-placeholder="Vers le compte" onchange="formTransferIsNotEmpty()">
                                <option value=""></option>
                                @foreach($customer->wallets()->where('type', '!=', 'pret')->where('status', 'active')->get() as $wallet)
                                    <option value="{{ $wallet->id }}" data-bank="FINBANK" data-bank-logo="/storage/logo/logo_carre.png" data-type="{{ \App\Helper\CustomerWalletHelper::getTypeWallet($wallet->type) }}" data-account="{{ $wallet->number_account }}" data-customer="{{ \App\Helper\CustomerHelper::getName($wallet->customer) }}" data-solde="{{ $wallet->balance_actual >= 0 ? '+ '.eur($wallet->balance_actual) : '- '.eur($wallet->balance_actual)}}" data-solde-style="{{ $wallet->balance_actual >= 0 ? 'text-success' : 'text-danger' }}"></option>
                                @endforeach
                                @foreach($customer->beneficiaires as $wallet)
                                    <option value="{{ $wallet->id }}" data-bank="{{ $wallet->bank->name }}" data-bank-logo="{{ $wallet->bank->logo }}" data-beneficiaire="{{ \App\Helper\CustomerTransferHelper::getNameBeneficiaire($wallet) }}" data-iban="{{ $wallet->iban }}" data-solde="{{ $wallet->balance_actual }}"></option>
                                @endforeach
                            </select>
                        </div>

                        <div id="personalisation" class="d-none">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <h3 class="card-title">Personnaliser mon virement</h3>
                                </div>
                                <div class="card-body">
                                    <x-form.input
                                        name="reason"
                                        type="text"
                                        label="Motif du virement" />

                                    <div class="mb-10">
                                        <label for="type" class="form-label required">Type de virement</label>
                                        <select name="type" id="type" class="form-control form-select" data-control="select2" onchange="changeTypeTransfer(this)">
                                            <option value="immediat">Immediat</option>
                                            <option value="differed">Différé</option>
                                            <option value="permanent">Permanent</option>
                                        </select>
                                    </div>

                                    <div id="differed_transfer" class="d-none">
                                        <x-form.input-date
                                            name="transfer_date"
                                            type="text"
                                            label="Date du virement" />
                                    </div>
                                    <div id="permanent_transfer" class="d-none">
                                        <x-form.input-date
                                            name="recurring_start"
                                            type="text"
                                            label="Date de début" />

                                        <x-form.input-date
                                            name="recurring_end"
                                            type="text"
                                            label="Date de Fin" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
        <div class="col-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <a href="{{ route('customer.transfer.history') }}" class="card shadow-sm mb-5">
                        <div class="card-body d-flex flex-row justify-content-between align-items-center text-hover-bank">
                            <div class="symbol symbol-50px me-5">
                                <div class="symbol-label fs-2 text-bank"><i class="fa-solid fa-file"></i> </div>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="fw-bolder">Historique des virements</div>
                                <div class="fs-6">Immédiats, différés et permanents</div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <i class="fa-solid fa-arrow-circle-right fa-lg"></i>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('customer.beneficiaire.index') }}" class="card shadow-sm">
                        <div class="card-body d-flex flex-row justify-content-between align-items-center text-hover-bank">
                            <div class="symbol symbol-50px me-5">
                                <div class="symbol-label fs-2 text-bank"><i class="fa-solid fa-users"></i> </div>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="fw-bolder">Mes Bénéficiaires</div>
                                <div class="fs-6">Ajout & Gestion</div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <i class="fa-solid fa-arrow-circle-right fa-lg"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.transfer.index")
@endsection
