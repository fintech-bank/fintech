@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Carte Bancaire VISA {{ $card->support }} N°{{ \App\Helper\CustomerCreditCard::getCreditCard($card->number, false) }}</h1>
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
            <li class="breadcrumb-item text-dark">Carte Bancaire VISA {{ $card->support }} N°{{ \App\Helper\CustomerCreditCard::getCreditCard($card->number, false) }}</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Sidebar-->
        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
            <!--begin::Card-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::Summary-->
                    <!--begin::User Info-->
                    <div class="d-flex flex-center flex-column py-5">
                        <!--begin::Avatar-->
                        <div class="symbol symbol-100px symbol-2by3 mb-7">
                            <img src="/storage/card/{{ $card->support }}.png" alt="image">
                        </div>
                        <!--end::Avatar-->
                        <!--begin::Name-->
                        <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">{{ \App\Helper\CustomerCreditCard::getCreditCard($card->number) }}</a>
                        <!--end::Name-->
                        <!--begin::Position-->
                        <div class="mb-9">
                            <!--begin::Badge-->
                            {!! \App\Helper\CustomerCreditCard::getStatus($card->status) !!}
                            <!--begin::Badge-->
                        </div>
                        <!--end::Position-->
                    </div>
                    <!--end::User Info-->
                    <!--end::Summary-->
                    <!--begin::Details toggle-->
                    <div class="d-flex flex-stack fs-4 py-3">
                        <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="false" aria-controls="kt_user_view_details">Details
                            <span class="ms-2 rotate-180">
								<span class="svg-icon svg-icon-3">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
									</svg>
								</span>
							</span>
                        </div>
                    </div>
                    <!--end::Details toggle-->
                    <div class="separator"></div>
                    <!--begin::Details content-->
                    <div id="kt_user_view_details" class="collapse show">
                        <div class="pb-5 fs-6">
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Devise</div>
                            <div class="text-gray-600">{{ $card->currency }}</div>
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Type de carte</div>
                            <div class="text-gray-600">
                                <a href="#" class="text-gray-600 text-hover-primary">{{ \App\Helper\CustomerCreditCard::getType($card->type) }}</a>
                            </div>
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Type de débit</div>
                            <div class="text-gray-600">{{ \App\Helper\CustomerCreditCard::getDebit($card->debit) }}</div>
                            <!--begin::Details item-->
                            <!--begin::Details item-->
                            <div class="fw-bold mt-5">Expiration</div>
                            <div class="text-gray-600">{{ \App\Helper\CustomerCreditCard::getExpiration($card) }}</div>
                            <!--begin::Details item-->
                            @if($card->transactions()->where('confirmed', true)->count() != 0)
                            <div class="fw-bold mt-5">Derniers opération</div>
                            <div class="text-gray-600">
                                {{ $card->transactions()->where('confirmed', true)->orderBy('confirmed_at', 'asc')->first()->confirmed_at->format('d/m/Y à H:i') }}
                            </div>
                            @endif
                            <!--begin::Details item-->
                            @if($card->dedit == 'differed')
                                <div class="fw-bold mt-5">Plafond Différé</div>
                                <div class="text-gray-600">
                                    {{ eur($card->differed_limit) }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <!--end::Details content-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
            <!--begin::Connected Accounts-->
            <div class="card mb-5 mb-xl-8">
                <!--begin::Card header-->
                <div class="card-header border-0">
                    <div class="card-title">
                        <h3 class="fw-bold m-0">Plafond de ma carte</h3>
                    </div>
                    <div class="card-toolbar">
                        <button data-bs-toggle="modal" data-bs-target="#EditPlafond" class="btn btn-sm btn-outline btn-outline-primary text-hover-white">Modifier</button>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-2">
                    <div class="d-flex w-200px w-sm-300px flex-column mt-3">
                        <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                            <span class="fw-semibold fs-6 text-gray-400">Plafond de retrait<br><span class="text-muted fs-8">sur 7 jours glissant</span></span>
                            <span class="fw-bold fs-6">{{ eur($card->limit_retrait) }}</span>
                        </div>
                        <div class="h-5px mx-3 w-100 bg-light mb-3">
                            <div class="bg-success rounded h-5px" role="progressbar" style="width: {{ \App\Helper\CustomerCreditCard::getTransactionsMonthWithdraw($card, true) }}%;" aria-valuenow="{{ \App\Helper\CustomerCreditCard::getTransactionsMonthWithdraw($card) }}" aria-valuemin="0" aria-valuemax="{{ $card->limit_retrait }}"></div>
                        </div>
                        <div class="fw-bolder fs-4 text-left text-warning">{{ eur(\App\Helper\CustomerCreditCard::getTransactionsMonthWithdraw($card)) }}</div>
                    </div>
                    <div class="d-flex w-200px w-sm-300px flex-column mt-3">
                        <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                            <span class="fw-semibold fs-6 text-gray-400">Plafond de Paiement<br><span class="text-muted fs-8">sur 30 jours glissant</span></span>
                            <span class="fw-bold fs-6">{{ eur($card->limit_payment) }}</span>
                        </div>
                        <div class="h-5px mx-3 w-100 bg-light mb-3">
                            <div class="bg-success rounded h-5px" role="progressbar" style="width: {{ \App\Helper\CustomerCreditCard::getTransactionsMonthPayment($card, true) }}%;" aria-valuenow="{{ \App\Helper\CustomerCreditCard::getTransactionsMonthPayment($card) }}" aria-valuemin="0" aria-valuemax="{{ $card->limit_payment }}"></div>
                        </div>
                        <div class="fw-bolder fs-4 text-left text-warning">{{ eur(\App\Helper\CustomerCreditCard::getTransactionsMonthPayment($card)) }}</div>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Connected Accounts-->
        </div>
        <!--end::Sidebar-->
        <!--begin::Content-->
        <div class="flex-lg-row-fluid ms-lg-15">
            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8" role="tablist">
                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#transactions" aria-selected="true" role="tab">Historique</a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#settings" data-kt-initialized="1" aria-selected="false" tabindex="-1" role="tab">Configuration & informations</a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                @if($card->facelia == 1)
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#facelia" aria-selected="false" tabindex="-1" role="tab">Facelia</a>
                </li>
                @endif
                <!--end:::Tab item-->
                @if($card->debit == 'differed')
                    <li class="nav-item" role="presentation">
                        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#differed" aria-selected="false" tabindex="-1" role="tab">Carte Différé</a>
                    </li>
                @endif
            </ul>
            <!--end:::Tabs-->
            <!--begin:::Tab content-->
            <div class="tab-content" id="myTabContent">
                <!--begin:::Tab pane-->
                <div class="tab-pane fade show active" id="transactions" role="tabpanel">
                    <div class="card card-flush shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Historique des transactions par carte bancaire</h3>
                        </div>
                        <div class="card-body py-5">
                            <div class="card card-flush">
                                <!--begin::Card header-->
                                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                                    <!--begin::Card title-->
                                    <div class="card-title">
                                        <!--begin::Search-->
                                        <div class="d-flex align-items-center position-relative my-1">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                            <span class="svg-icon svg-icon-1 position-absolute ms-4">
														<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
															<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
														</svg>
													</span>
                                            <!--end::Svg Icon-->
                                            <input type="text" data-kt-transaction-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Rechercher une transaction" />
                                        </div>
                                        <!--end::Search-->
                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <!--end::Card header-->
                                <!--begin::Card body-->
                                <div class="card-body pt-0">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="liste_transaction">
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600">
                                        @foreach($card->transactions()->whereBetween('confirmed_at', [now()->startOfMonth(), now()->endOfMonth()])->where('confirmed', true)->orderBy('confirmed_at', 'desc')->get() as $transaction)
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
                                    <!--end::Table-->
                                </div>
                                <!--end::Card body-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--end:::Tab pane-->
                <!--begin:::Tab pane-->
                <div class="tab-pane fade" id="settings" role="tabpanel">
                    <div class="card card-flush shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Configuration de la carte bancaire</h3>
                        </div>
                        <div class="card-body py-5">
                            <div class="row">
                                <div class="col-8">
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="symbol symbol-50px symbol-circle me-5">
                                            <div class="symbol-label">
                                                @if($card->payment_internet == 1)
                                                    <i class="fa-solid fa-check-circle fa-2x text-success"></i>
                                                @else
                                                    <i class="fa-solid fa-times-circle fa-2x text-danger"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="fs-3">Paiement par internet</div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="symbol symbol-50px symbol-circle me-5">
                                            <div class="symbol-label">
                                                @if($card->payment_abroad == 1)
                                                    <i class="fa-solid fa-check-circle fa-2x text-success"></i>
                                                @else
                                                    <i class="fa-solid fa-times-circle fa-2x text-danger"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="fs-3">Paiement à l'étranger</div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="symbol symbol-50px symbol-circle me-5">
                                            <div class="symbol-label">
                                                @if($card->payment_contact == 1)
                                                    <i class="fa-solid fa-check-circle fa-2x text-success"></i>
                                                @else
                                                    <i class="fa-solid fa-times-circle fa-2x text-danger"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="fs-3">Paiement sans contact</div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="symbol symbol-50px symbol-circle me-5">
                                            <div class="symbol-label">
                                                @if($card->facelia == 1)
                                                    <i class="fa-solid fa-check-circle fa-2x text-success"></i>
                                                @else
                                                    <i class="fa-solid fa-times-circle fa-2x text-danger"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="fs-3">Option: Crédit renouvelable FACELIA</div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="symbol symbol-50px symbol-circle me-5">
                                            <div class="symbol-label">
                                                @if($card->visa_spec == 1)
                                                    <i class="fa-solid fa-check-circle fa-2x text-success"></i>
                                                @else
                                                    <i class="fa-solid fa-times-circle fa-2x text-danger"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="fs-3">Services Specifiques VISA</div>
                                    </div>
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="symbol symbol-50px symbol-circle me-5">
                                            <div class="symbol-label">
                                                @if($card->warranty == 1)
                                                    <i class="fa-solid fa-check-circle fa-2x text-success"></i>
                                                @else
                                                    <i class="fa-solid fa-times-circle fa-2x text-danger"></i>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="fs-3">Garantie d'achat</div>
                                    </div>
                                </div>
                                <div class="col-4 border p-5">
                                    <div class="fs-3 fw-bold mb-3">Configuration</div>
                                    <form action="{{ route('customer.payment.update', $card->id) }}" method="post" id="formUpdateState">
                                        @csrf
                                        <input type="hidden" name="action" value="updateState">
                                        <x-form.switches
                                            name="payment_internet"
                                            label="Paiement par internet"
                                            value="1"
                                            :check="$card->payment_internet == 1 ? 'checked' : ''" />

                                        <x-form.switches
                                            name="payment_abroad"
                                            label="Paiement à l'étranger"
                                            value="1"
                                            :check="$card->payment_abroad == 1 ? 'checked' : ''" />

                                        <x-form.switches
                                            name="payment_contact"
                                            label="Paiement sans contact"
                                            value="1"
                                            :check="$card->payment_contact == 1 ? 'checked' : ''" />

                                        <div class="d-flex flex-wrap ">
                                            <x-form.button class="btn-bank w-100"/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end:::Tab pane-->
                <div class="tab-pane fade" id="facelia" role="tabpanel">
                    <div class="card card-flush shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Information sur votre pret: Crédit Renouvelable Facelia</h3>
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-sm btn-light">
                                    Gérez mon crédit
                                </button>
                            </div>
                        </div>
                        <div class="card-body py-5">
                            <div class="card-body">
                                <div class="bg-gray-600 text-white p-5 fs-1 rounded-3 mb-5">
                                    <strong>Situation</strong> aux {{ now()->format('d/m/Y') }}
                                </div>
                                <div class="d-flex flex-row w-100">
                                    <div class="flex-column">
                                        <div class="d-flex flex-row w-400px justify-content-between align-items-center mb-5">
                                            <div class="d-flex flex-column fs-2">
                                                <div class="fw-bolder">Crédit Renouvelable</div>
                                                <div class="fs-3">N° {{ $card->facelias->reference }}</div>
                                            </div>
                                            @if($card->pret->alert == 1)
                                                <div class="symbol symbol-50px symbol-circle" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-custom-class="tooltip-dark"
                                                     title="{{ "Votre dossier présente un retard de paiement de ".eur($card->facelias->amount_du).".Pour éviter une procédure de recouvrement, il est important de régulariser votre situation." }}">
                                                    <div class="symbol-label">
                                                        <i class="fa-solid fa-exclamation-triangle fa-2x text-warning"></i>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="separator my-5 w-400px border-2"></div>
                                        <div class="d-flex flex-column w-400px">
                                            <div class="d-flex flex-row justify-content-between p-3 pb-5 fs-3 border-bottom">
                                                <div class="fw-bolder">Prochain Prélèvement</div>
                                                <div class="fs-4 text-primary fw-bold">{{ eur($card->facelias->mensuality) }}</div>
                                            </div>
                                            <div class="d-flex flex-row justify-content-between align-items-center p-3 fs-4 border-bottom">
                                                <div class="fw-bold w-50">
                                                    Vos opérations au comptant
                                                    @if(\App\Helper\CustomerFaceliaHelper::calcComptantMensuality($card->wallet) > 0)
                                                        <span class="fs-8">Prélevé le {{ $card->facelias->next_expiration->format('d/m/Y') }}</span>
                                                    @endif
                                                </div>
                                                <div class="fs-5 text-primary fw-bold text-right">{{ eur(\App\Helper\CustomerFaceliaHelper::calcComptantMensuality($card->wallet)) }}</div>
                                            </div>
                                            <div class="d-flex flex-row justify-content-between align-items-center p-3 fs-4 border-bottom border-bottom-4 border-gray-600">
                                                <div class="fw-bold w-50">
                                                    Vos opérations selon votre mensualité choisie
                                                    @if(\App\Helper\CustomerFaceliaHelper::calcOpsSepaMensuality($card->pret->wallet) > 0)
                                                        <span class="fs-8">Prélevé le {{ $card->facelias->next_expiration->format('d/m/Y') }}</span>
                                                    @endif
                                                </div>
                                                <div class="fs-5 text-primary fw-bold text-right">{{ eur(\App\Helper\CustomerFaceliaHelper::calcOpsSepaMensuality($card->pret->wallet)) }}</div>
                                            </div>
                                            <div class="d-flex flex-row justify-content-between align-items-center p-3 fs-3 border-bottom">
                                                <div class="fw-bolder w-50">
                                                    Montant Disponible
                                                </div>
                                                <div class="fs-4 text-success fw-bold text-right">{{ eur($card->facelias->amount_available) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column w-800px ms-5">
                                        <table class="table border table-striped gs-7 gy-7 gx-7 fs-4">
                                            <tbody>
                                            <tr>
                                                <td class="fw-bolder">Plafond du crédit renouvelable</td>
                                                <td>{{ eur($card->facelias->pret->amount_loan) }}</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bolder">
                                                    Montant disponible*<br>
                                                    <span class="fs-6 fw-normal">*sous réserve des opérations en cours</span>
                                                </td>
                                                <td>{{ eur($card->facelias->amount_available) }}</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bolder">Montant utilisé</td>
                                                <td>{{ eur($card->facelias->amount_du - $card->facelias->amount_available) }}</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bolder">Montant restant du</td>
                                                <td>{{ eur($card->facelias->amount_du) }}</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bolder">
                                                    Montant de vos opérations au comptant*<br>
                                                    <span class="fs-6 fw-normal">(achats différés du mois)</span>
                                                </td>
                                                <td>{{ eur(\App\Helper\CustomerFaceliaHelper::calcComptantMensuality($card->facelias->wallet)) }}</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bolder">Mensualité actuel</td>
                                                <td>{{ eur($card->facelias->mensuality) }}</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="fw-bolder">Date de prélèvement</td>
                                                <td>
                                                    @if($card->facelias->mensuality != 0)
                                                        {{ $card->facelias->nex_expiration->format('d/m/Y') }}
                                                    @else
                                                        Aucune Echéance à devoir
                                                    @endif
                                                </td>
                                                <td></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="differed" role="tabpanel">
                    <div class="card card-flush h-md-50 mb-xl-10">
                        <!--begin::Header-->
                        <div class="card-header pt-5">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column">
                                <!--begin::Info-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Amount-->
                                    <span class="fs-2hx fw-bold text-dark me-2 lh-1 ls-n2">{{ eur(\App\Helper\CustomerCreditCard::getRestantDiffered($card)) }}</span>
                                    <!--end::Amount-->
                                </div>
                                <!--end::Info-->
                                <!--begin::Subtitle-->
                                <span class="text-gray-400 pt-1 fw-semibold fs-6">Disponible au {{ now()->format('d/m/Y') }}</span>
                                <!--end::Subtitle-->
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Card body-->
                        <div class="card-body d-flex align-items-end pt-0">
                            <!--begin::Progress-->
                            <div class="d-flex align-items-center flex-column mt-3 w-100">
                                <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                    <span class="fw-bolder fs-6 text-dark">{{ eur(\App\Helper\CustomerCreditCard::getUsedDiffered($card)) }} utilisé</span>
                                    <span class="fw-bold fs-6 text-gray-400">{{ \App\Helper\CustomerCreditCard::getUsedDiffered($card, true) }}%</span>
                                </div>
                                <div class="h-8px mx-3 w-100 bg-light-success rounded">
                                    <div class="bg-success rounded h-8px" role="progressbar" style="width: {{ \App\Helper\CustomerCreditCard::getUsedDiffered($card, true) }}%;" aria-valuenow="{{ \App\Helper\CustomerCreditCard::getUsedDiffered($card, true) }}" aria-valuemin="0" aria-valuemax="{{ $card->differed_limit }}"></div>
                                </div>
                                <div class="d-flex justify-content-between w-50 mt-5 mb-2">
                                    <table class="table fs-2">
                                        <tbody>
                                            <tr>
                                                <td class="fw-bolder">Montant à payer au {{ now()->endOfMonth()->format('d/m/Y') }}</td>
                                                <td>{{ eur(\App\Helper\CustomerCreditCard::getUsedDiffered($card)) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--end::Progress-->
                        </div>
                        <!--end::Card body-->
                    </div>
                </div>
            </div>
            <!--end:::Tab content-->
        </div>
        <!--end::Content-->
    </div>
    <div class="modal fade" tabindex="-1" id="EditPlafond">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h3 class="modal-title text-white">Edition de mes plafond</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <form id="formEditPlafond" action="{{ route('customer.payment.update', $card->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="action" value="updatePlafond">

                        <x-form.input
                            name="limit_retrait"
                            type="text"
                            label="Plafond de retrait"
                            value="{{ $card->limit_retrait }}"
                            text="Limite Maximal: {{ eur(round($card->limit_retrait * 3, -2)) }}" />

                        <x-form.input
                            name="limit_payment"
                            type="text"
                            label="Plafond de paiement"
                            value="{{ $card->limit_payment }}"
                            text="Limite Maximal: {{ eur(round($card->limit_payment * 1.23, -2)) }}" />

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
    @include("customer.scripts.payment.show")
@endsection
