@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Moyen de paiement</h1>
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
            <li class="breadcrumb-item text-dark">Moyen de paiement</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="card pt-4 mb-6 mb-xl-9">
        <!--begin::Card header-->
        <div class="card-header border-0">
            <!--begin::Card title-->
            <div class="card-title">
                <h2 class="fw-bolder mb-0">MES CARTES</h2>
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <a href="#" class="btn btn-sm btn-flex btn-light-primary" data-bs-toggle="modal" data-bs-target="#AddCard"><i class="fa-solid fa-plus-circle fa-lg me-2"></i> Commander une carte bancaire</a>
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div id="kt_customer_view_payment_method" class="card-body pt-0">
            @foreach($customer->wallets as $wallet)
                @foreach($wallet->cards as $card)
                    <!--begin::Option-->
                        <div class="py-0" data-kt-customer-payment-method="row">
                            <!--begin::Header-->
                            <div class="py-3 d-flex flex-stack flex-wrap">
                                <!--begin::Toggle-->
                                <div class="d-flex align-items-center collapsible rotate collapsed" data-bs-toggle="collapse" href="#kt_customer_view_payment_method_{{ $card->id }}" role="button" aria-expanded="false" aria-controls="kt_customer_view_payment_method_{{ $card->id }}">
                                    <!--begin::Arrow-->
                                    <div class="me-3 rotate-90">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
                                        <span class="svg-icon svg-icon-3">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
												<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="black" />
											</svg>
										</span>
                                        <!--end::Svg Icon-->
                                    </div>
                                    <!--end::Arrow-->
                                    <!--begin::Logo-->
                                    <img src="/storage/card/{{ $card->support }}.png" class="w-40px me-3" alt="" />
                                    <!--end::Logo-->
                                    <!--begin::Summary-->
                                    <div class="me-3">
                                        <div class="d-flex align-items-center">
                                            <div class="text-gray-800 fw-bolder me-2">VISA {{ $card->support }}</div>
                                            {!! \App\Helper\CustomerCreditCard::getStatus($card->status) !!}
                                        </div>
                                        <div class="text-muted">{{ \App\Helper\CustomerHelper::getName($wallet->customer) }}</div>
                                    </div>
                                    <!--end::Summary-->
                                </div>
                                <!--end::Toggle-->
                                <!--begin::Toolbar-->
                                <div class="d-flex my-3 ms-9">
                                    <!--begin::Edit-->
                                    <a href="{{ route('customer.payment.show', $card->id) }}" class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_new_card">
										<span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Voir la carte">
											<i class="fa-solid fa-eye"></i>
										</span>
                                    </a>
                                    <!--end::Edit-->
                                </div>
                                <!--end::Toolbar-->
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div id="kt_customer_view_payment_method_{{ $card->id }}" class="collapse fs-6 ps-10" data-bs-parent="#kt_customer_view_payment_method">
                                <!--begin::Details-->
                                <div class="d-flex flex-wrap py-5">
                                    <!--begin::Col-->
                                    <div class="flex-equal me-5">
                                        <table class="table table-flush fw-bold gy-1">
                                            <tr>
                                                <td class="text-muted min-w-125px w-125px">Type</td>
                                                <td class="text-gray-800">Carte Bancaire {{ \App\Helper\CustomerCreditCard::getType($card->type) }} - Visa {{ $card->support }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted min-w-125px w-125px">Numéro</td>
                                                <td class="text-gray-800">{{ \App\Helper\CustomerCreditCard::getCreditCard($card->number) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted min-w-125px w-125px">Date d'expiration</td>
                                                <td class="text-gray-800">{{ \App\Helper\CustomerCreditCard::getExpiration($card) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted min-w-125px w-125px">Type de débit</td>
                                                <td class="text-gray-800">{{ \App\Helper\CustomerCreditCard::getDebit($card->debit) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="flex-equal">
                                        <table class="table table-flush fw-bold gy-1">
                                            <tr>
                                                <td class="text-muted min-w-125px w-125px">Sans Contact</td>
                                                <td class="text-gray-800">{{ \App\Helper\CustomerCreditCard::getContact($card->contact) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted min-w-125px w-125px">Limite de Paiement</td>
                                                <td class="text-gray-800">{{ eur($card->limit_payment) }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-muted min-w-125px w-125px">Limite de Retrait</td>
                                                <td class="text-gray-800">{{ eur($card->limit_retrait) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Body-->
                        </div>
                @endforeach
            @endforeach
        </div>
        <!--end::Card body-->
    </div>
    <div class="modal fade" tabindex="-1" id="AddCard">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Commande d'une nouvelle carte bancaire</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark fa-2x text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formAddCard" action="{{ route('customer.payment.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!--begin::Radio group-->
                        <div class="btn-group d-flex flex-wrap mb-10" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                            <!--begin::Radio-->
                            <label class="btn btn-outline-secondary text-muted text-hover-white text-active-white btn-outline btn-active-success active" data-kt-button="true">
                                <!--begin::Input-->
                                <input class="btn-check" type="radio" name="type" checked="checked" value="physique" onchange="showPhysique()" />
                                <!--end::Input-->
                                Carte Physique
                            </label>
                            <!--end::Radio-->

                            <!--begin::Radio-->
                            <label class="btn btn-outline-secondary text-muted text-hover-white text-active-white btn-outline btn-active-success" data-kt-button="true">
                                <!--begin::Input-->
                                <input class="btn-check" type="radio" name="type" value="virtuel" onchange="showPhysique()" />
                                <!--end::Input-->
                                Carte Virtuel
                            </label>
                            <!--end::Radio-->
                        </div>
                        <!--end::Radio group-->
                        <div id="physique">
                            <div class="mb-10">
                                <label for="support" class="form-label">Type de carte</label>
                                <select id="support" class="form-select" name="support" data-control="select2" data-dropdown-parent="#AddCard" data-placebolder="Selectionner un type de carte" onchange="showDiffered(this)">
                                    <option value=""></option>
                                    <option value="classic" data-img="/storage/card/classic.png">Carte Bancaire Visa Classic</option>
                                    <option value="premium" data-img="/storage/card/premium.png">Carte Bancaire Visa Premium</option>
                                    <option value="infinite" data-img="/storage/card/infinite.png">Carte Bancaire Visa Infinite</option>
                                </select>
                            </div>
                            <div id="differed" class="d-none">
                                <div class="mb-10">
                                    <label for="debit" class="form-label">Type de débit</label>
                                    <select id="debit" class="form-select" name="debit" data-control="select2" data-dropdown-parent="#AddCard" data-placebolder="Selectionner un type de débit">
                                        <option value=""></option>
                                        <option value="immediate" data-img="/storage/card/classic.png">Débit Immédiat</option>
                                        <option value="differed" data-img="/storage/card/premium.png">Débit Différé</option>
                                    </select>
                                </div>

                                <x-form.checkbox
                                    name="facelia"
                                    label="Demander un crédit renouvelable facelia"
                                    value="1" />

                            </div>
                        </div>
                        <div id="virtuel" class="d-none">
                            <x-form.input
                                name="amount"
                                type="text"
                                label="Montant de la carte virtuel" />
                        </div>
                        <div class="mb-10">
                            <label for="wallet_id" class="form-label">Compte affilié</label>
                            <select id="wallet_id" class="form-select" name="wallet_id" data-control="select2" data-dropdown-parent="#AddCard" data-placebolder="Selectionner un compte bancaire">
                                <option value=""></option>
                                @foreach($customer->wallets()->where('type', 'compte')->get() as $wallet)
                                    <option value="{{ $wallet->id }}">{{ \App\Helper\CustomerWalletHelper::getNameAccount($wallet) }}</option>
                                @endforeach
                            </select>
                        </div>
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
    @include("customer.scripts.payment.index")
@endsection
