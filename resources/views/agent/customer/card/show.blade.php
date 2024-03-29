@extends("agent.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Clients</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.dashboard') }}"
                   class="text-muted text-hover-primary">Agence: {{ auth()->user()->agency->name }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.customer.index') }}" class="text-muted text-hover-primary">Clients</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('agent.customer.show', $customer->id) }}" class="text-muted text-hover-primary">Client: {{ \App\Helper\CustomerHelper::getName($customer) }}
                    - {{ $customer->user->identifiant }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Carte Bancaire VISA {{ \App\Helper\CustomerCreditCard::getType($card->type) }} N°{{ \App\Helper\CustomerCreditCard::getCreditCard($card->number) }}</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="container-fluid" id="viewCreditCard">
        <div class="d-flex flex-column flex-xl-row">
            <div class="flex-column flex-lg-row-auto w-100 w-xl-350px mb-10">
                <!--begin::Card-->
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Card body-->
                    <div class="card-body pt-15">
                        <!--begin::Summary-->
                        <div class="d-flex flex-center flex-column mb-5">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-100px symbol-circle mb-7">
                                <i class="fa-solid fa-credit-card fa-4x"></i>
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Name-->
                            <a href="#"
                               class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-1">{{ \App\Helper\CustomerCreditCard::getCreditCard($card->number) }}</a>
                            <!--end::Name-->
                            <!--begin::Position-->
                            <div
                                class="fs-5 fw-bold text-muted mb-6">{!! \App\Helper\CustomerCreditCard::getType($card->type) !!}</div>
                            <!--end::Position-->
                        </div>
                        <!--end::Summary-->
                        <!--begin::Details toggle-->
                        <div class="d-flex flex-stack fs-4 py-3">
                            <div class="fw-bolder rotate collapsible" data-bs-toggle="collapse"
                                 href="#kt_customer_view_details" role="button" aria-expanded="false"
                                 aria-controls="kt_customer_view_details">Details
                                <span class="ms-2 rotate-180">
									<!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
									<span class="svg-icon svg-icon-3">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
											<path
                                                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                fill="currentColor"></path>
										</svg>
									</span>
								</span>
                            </div>
                            <!--<span data-bs-toggle="tooltip" data-bs-trigger="hover" title="" data-bs-original-title="Edit customer details">
								<a href="#" class="btn btn-sm btn-light-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_update_customer">Edit</a>
							</span>-->
                        </div>
                        <!--end::Details toggle-->
                        <div class="separator separator-dashed my-3"></div>
                        <!--begin::Details content-->
                        <div id="kt_customer_view_details" class="collapse show">
                            <div class="py-5 fs-6">
                                <!--begin::Details item-->
                                <div class="fw-bolder mt-5">Expiration</div>
                                <div class="text-gray-600">{{ \App\Helper\CustomerCreditCard::getExpiration($card) }}</div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bolder mt-5">Devise</div>
                                <div class="text-gray-600">
                                    <a href="#"
                                       class="text-gray-600 text-hover-primary">{{ $card->currency }}</a>
                                </div>
                                <div class="fw-bolder mt-5">Support de la carte</div>
                                <div class="text-gray-600">
                                    <a href="#" class="text-gray-600 text-hover-primary">{{ Str::ucfirst($card->support) }}</a>
                                </div>
                                <div class="fw-bolder mt-5">Type de débit</div>
                                <div class="text-gray-600">
                                    <a href="#" class="text-gray-600 text-hover-primary">{{ \App\Helper\CustomerCreditCard::getDebit($card->debit) }}</a>
                                </div>
                                <div class="fw-bolder mt-5">Statut de la carte</div>
                                <div class="text-gray-600">
                                    {!! \App\Helper\CustomerCreditCard::getStatus($card->status) !!}
                                </div>

                                <div class="fw-bolder mt-5">Lié au compte</div>
                                <div class="text-gray-600">
                                    {!! \App\Helper\CustomerWalletHelper::getNameAccount($card->wallet) !!}
                                </div>

                                <div class="fw-bolder mt-5">Limite de paiement / Retrait</div>
                                <div class="text-gray-600">
                                    <strong>Paiement:</strong> {{ eur($card->limit_payment) }}<br>
                                    <strong>Retrait:</strong> {{ eur($card->limit_retrait) }}<br>
                                </div>

                                @if($card->debit == 'differed')
                                    <div class="fw-bolder mt-5">Limite de paiement / Retrait différé</div>
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
            </div>
            <div class="flex-lg-row-fluid ms-lg-15">
                <div class="card shadow-sm mb-10">
                    <div class="card-header">
                        <h3 class="card-title"></h3>
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-light rotate" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="30px, 30px">
                                Action
                                <i class="fa-solid fa-caret-up rotate-180 ms-3 me-0"></i>
                            </button>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-250px" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <div class="menu-content fs-6 text-dark fw-bolder px-3 py-4">Quick Actions</div>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu separator-->
                                <div class="separator mb-3 opacity-75"></div>
                                <!--end::Menu separator-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#editCard" data-bs-toggle="modal" class="menu-link px-3">
                                        Editer la carte bancaire
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                @if($card->status == 'active')
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="{{ route('agent.customer.card.inactive', [$customer->id, $card->id]) }}" class="menu-link px-3 desactive">
                                            Désactiver la carte bancaire
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                @elseif($card->status == 'inactive')
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="{{ route('agent.customer.card.active', [$customer->id, $card->id]) }}" class="menu-link px-3 actif">
                                            Activé la carte bancaire
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                @else

                                @endif

                            <!--end::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#reloadCode" data-bs-toggle="modal" class="menu-link px-3">
                                        Renvoyer le code secret
                                    </a>
                                </div>
                                @if($card->facelia == 0)
                                    <div class="menu-item px-3">
                                        <a href="#facelia" data-bs-toggle="modal" class="menu-link px-3">
                                            Liaison Facelia
                                        </a>
                                    </div>
                                @endif
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="{{ route('agent.customer.card.canceled', [$customer->id, $card->id]) }}" class="menu-link text-danger px-3 canceled">
                                        Annuler la carte bancaire
                                    </a>
                                </div>

                            </div>
                            <!--end::Menu-->
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="fw-bolder">Caractéristique de la carte bancaire</h3>
                        <div class="py-5 fs-6">
                            <div class="d-flex flex-row mb-5">
                                <div class="symbol symbol-50px me-5">
                                    @if($card->payment_internet == true)
                                        <div class="symbol-label fs-2 fw-bold text-success"><i class="fa-solid fa-check-circle"></i> </div>
                                    @else
                                        <div class="symbol-label fs-2 fw-bold text-danger"><i class="fa-solid fa-times-circle"></i> </div>
                                    @endif
                                </div>
                                <div class="">
                                    <div class="fw-bolder mt-5">Paiement par internet</div>
                                </div>
                            </div>
                            <div class="d-flex flex-row mb-5">
                                <div class="symbol symbol-50px me-5">
                                    @if($card->payment_abroad == true)
                                        <div class="symbol-label fs-2 fw-bold text-success"><i class="fa-solid fa-check-circle"></i> </div>
                                    @else
                                        <div class="symbol-label fs-2 fw-bold text-danger"><i class="fa-solid fa-times-circle"></i> </div>
                                    @endif
                                </div>
                                <div class="">
                                    <div class="fw-bolder mt-5">Paiement / Retrait à l'étranger</div>
                                </div>
                            </div>
                            <div class="d-flex flex-row mb-5">
                                <div class="symbol symbol-50px me-5">
                                    @if($card->payment_contact == true)
                                        <div class="symbol-label fs-2 fw-bold text-success"><i class="fa-solid fa-check-circle"></i> </div>
                                    @else
                                        <div class="symbol-label fs-2 fw-bold text-danger"><i class="fa-solid fa-times-circle"></i> </div>
                                    @endif
                                </div>
                                <div class="">
                                    <div class="fw-bolder mt-5">Paiement sans contact</div>
                                </div>
                            </div>
                            <div class="d-flex flex-row mb-5">
                                <div class="symbol symbol-50px me-5">
                                    @if($card->facelia == true)
                                        <div class="symbol-label fs-2 fw-bold text-success"><i class="fa-solid fa-check-circle"></i> </div>
                                    @else
                                        <div class="symbol-label fs-2 fw-bold text-danger"><i class="fa-solid fa-times-circle"></i> </div>
                                    @endif
                                </div>
                                <div class="">
                                    <div class="fw-bolder mt-5">Option: Crédit Renouvelable FACELIA</div>
                                </div>
                            </div>
                            <div class="d-flex flex-row mb-5">
                                <div class="symbol symbol-50px me-5">
                                    @if($card->visa_spec == true)
                                        <div class="symbol-label fs-2 fw-bold text-success"><i class="fa-solid fa-check-circle"></i> </div>
                                    @else
                                        <div class="symbol-label fs-2 fw-bold text-danger"><i class="fa-solid fa-times-circle"></i> </div>
                                    @endif
                                </div>
                                <div class="">
                                    <div class="fw-bolder mt-5">Service spécifique Visa</div>
                                </div>
                            </div>
                            <div class="d-flex flex-row mb-5">
                                <div class="symbol symbol-50px me-5">
                                    @if($card->warranty == true)
                                        <div class="symbol-label fs-2 fw-bold text-success"><i class="fa-solid fa-check-circle"></i> </div>
                                    @else
                                        <div class="symbol-label fs-2 fw-bold text-danger"><i class="fa-solid fa-times-circle"></i> </div>
                                    @endif
                                </div>
                                <div class="">
                                    <div class="fw-bolder mt-5">Garantie d'achat</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if($card->facelia == 1)
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Information sur votre pret: Crédit Renouvelable Facelia</h3>
                            <div class="card-toolbar">
                                <a href="{{ route('agent.customer.wallet.show', [$customer->id, $card->pret->wallet->id]) }}#pret" class="btn btn-sm btn-primary"><i class="fa-solid fa-exchange me-2"></i> Gérer le crédit</a>
                            </div>
                        </div>
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
                                            <div class="fs-4 text-primary fw-bold">{{ eur($card->facelias->amount_du) }}</div>
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
                @endif
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="editCard">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white"><i class="fa-solid fa-credit-card me-2"></i> Edition des informations de la carte bancaire</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-times text-white fa-2x"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formEditCard" action="{{ route('agent.customer.card.update', [$customer->id, $card->id]) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="debit" class="form-label required">Type de débit de la carte bancaire</label>
                            <select class="form-select" id="debit" name="debit" data-parent="#editCard" data-control="select2" data-placeholder="Selectionner un type de débit" onchange="appearDifferedField(this)">
                                <option value=""></option>
                                <option value="immediate" @if($card->debit == 'immediate') selected @endif>Débit Immédiat</option>
                                <option value="differed" @if($card->debit == 'differed') selected @endif>Débit différé</option>
                            </select>
                        </div>
                        <div id="cardDiffered" class="@if($card->debit == 'immediate') d-none @endif">
                            <div class="mb-10">
                                <label for="differed_limit" class="form-label required">Limite de paiement différé</label>
                                <select class="form-select" id="differed_limit" name="differed_limit" data-parent="#editCard" data-control="select2" data-placeholder="Selectionner une limite de paiement">
                                    <option value=""></option>
                                    <option value="0" @if($card->differed_limit == 0) selected @endif>0,00 €</option>
                                    <option value="500" @if($card->differed_limit == 500) selected @endif>500,00 €</option>
                                    <option value="1000" @if($card->differed_limit == 1000) selected @endif>1 000,00 €</option>
                                    <option value="1500" @if($card->differed_limit == 1500) selected @endif>1 500,00 €</option>
                                    <option value="2000" @if($card->differed_limit == 2000) selected @endif>2 000,00 €</option>
                                    <option value="2500" @if($card->differed_limit == 2500) selected @endif>2 500,00 €</option>
                                    <option value="3000" @if($card->differed_limit == 3000) selected @endif>3 000,00 €</option>
                                </select>
                            </div>
                        </div>

                        <h3 class="fw-bolder mb-3">Configuration de la carte </h3>
                        <div class="d-flex flex-row justify-content-between mb-3">
                            <x-form.switches
                                name="payment_internet"
                                label="Paiement par internet"
                                value="true"
                                checked="@if($card->payment_internet == true) true @else false @endif" />

                            <x-form.switches
                                name="payment_abroad"
                                label="Paiement / Retrait à l'étranger"
                                value="true"
                                checked="@if($card->payment_abroad == true)true@else false@endif" />

                            <x-form.switches
                                name="payment_contact"
                                label="Paiement sans contact"
                                value="true"
                                checked="@if($card->payment_contact == true) true @else false @endif" />
                        </div>
                    </div>

                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="reloadCode">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white"><i class="fa-solid fa-refresh me-2"></i> Réinitialisation du code de la carte bancaire</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-times text-white fa-2x"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formReloadCode" action="{{ route('agent.customer.card.code', [$customer->id, $card->id]) }}" method="GET">
                    @csrf

                    <div class="modal-body">
                        <p>La réinitialisation du code de la carte bancaire va démarré, un code va être envoyer sur le téléphone du client.</p>
                    </div>

                    <div class="modal-footer">
                        <x-form.button text="Renvoyer le code" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="facelia">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white"><i class="fa-solid fa-refresh me-2"></i> Ouverture Crédit renouvelable Facelia</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-times text-white fa-2x"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formCreateFacelia" action="{{ route('agent.customer.card.facelia', [$customer->id, $card->id]) }}" method="POST">
                    @csrf

                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="amount_available" class="form-label required">Montant du crédit renouvelable</label>
                            <select class="form-select" id="amount_available" name="amount_available" data-parent="#facelia" data-control="select2" data-placeholder="Selectionner un montant">
                                <option value=""></option>
                                <option value="500">500,00 €</option>
                                <option value="1000">1 000,00 €</option>
                                <option value="1500">1 500,00 €</option>
                                <option value="2000">2 000,00 €</option>
                                <option value="2500">2 500,00 €</option>
                                <option value="3000">3 000,00 €</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <x-form.button text="Lié la carte à Facelia" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("agent.scripts.customer.card.show")
@endsection
