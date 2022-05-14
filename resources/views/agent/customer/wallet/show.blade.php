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
                <a href="{{ route('agent.customer.show', $wallet->customer->id) }}" class="text-muted text-hover-primary">Client: {{ \App\Helper\CustomerHelper::getName($wallet->customer) }}
                    - {{ $wallet->customer->user->identifiant }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">{{ \App\Helper\CustomerWalletHelper::getTypeWallet($wallet->type, false) }} N°{{ $wallet->number_account }}</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="container-fluid">
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
                                <i class="fa-solid fa-wallet fa-4x"></i>
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Name-->
                            <a href="#"
                               class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-1">{{ $wallet->number_account }}</a>
                            <!--end::Name-->
                            <!--begin::Position-->
                            <div
                                class="fs-5 fw-bold text-muted mb-6">{!! \App\Helper\CustomerWalletHelper::getTypeWallet($wallet->type, true) !!}</div>
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
                                <div class="fw-bolder mt-5">Numéro de compte</div>
                                <div class="text-gray-600">{{ $wallet->number_account }}</div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bolder mt-5">Iban</div>
                                <div class="text-gray-600">
                                    <a href="#"
                                       class="text-gray-600 text-hover-primary">{{ $wallet->iban }}</a>
                                </div>
                            </div>
                        </div>
                        <!--end::Details content-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <div class="flex-lg-row-fluid ms-lg-15">
                <!--begin:::Tabs-->
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                           href="#transactions">Transactions</a>
                    </li>
                    <!--end:::Tab item-->
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#infos">Informations</a>
                    </li>
                    <!--end:::Tab item-->
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab"
                           href="#transfers">Virements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab"
                           href="#sepas">Prélèvements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab"
                           href="#checks">Chèques</a>
                    </li>
                    @if($wallet->type == 'pret')
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab"
                           href="#prets">Pret</a>
                    </li>
                    @endif
                    @if($wallet->type == 'epargne')
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab"
                               href="#epargnes">Epargne</a>
                        </li>
                    @endif
                    <!--end:::Tab item-->
                </ul>
                <!--end:::Tabs-->
                <!--begin:::Tab content-->
                <div class="tab-content" id="myTabContent">
                    <!--begin:::Tab pane-->
                    <div class="tab-pane fade show active" id="transactions" role="tabpanel">
                        @if($wallet->balance_coming > 0)
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="#" class="card @if($wallet->balance_actual <= 0) bg-danger @else bg-success @endif hoverable card-xl-stretch mb-xl-8">
                                        <!--begin::Body-->
                                        <div class="card-body">
                                            <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm008.svg-->
                                            <span class="svg-icon svg-icon-gray-100 svg-icon-3x ms-n1">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<path opacity="0.3" d="M18 21.6C16.3 21.6 15 20.3 15 18.6V2.50001C15 2.20001 14.6 1.99996 14.3 2.19996L13 3.59999L11.7 2.3C11.3 1.9 10.7 1.9 10.3 2.3L9 3.59999L7.70001 2.3C7.30001 1.9 6.69999 1.9 6.29999 2.3L5 3.59999L3.70001 2.3C3.50001 2.1 3 2.20001 3 3.50001V18.6C3 20.3 4.3 21.6 6 21.6H18Z" fill="currentColor"></path>
										<path d="M12 12.6H11C10.4 12.6 10 12.2 10 11.6C10 11 10.4 10.6 11 10.6H12C12.6 10.6 13 11 13 11.6C13 12.2 12.6 12.6 12 12.6ZM9 11.6C9 11 8.6 10.6 8 10.6H6C5.4 10.6 5 11 5 11.6C5 12.2 5.4 12.6 6 12.6H8C8.6 12.6 9 12.2 9 11.6ZM9 7.59998C9 6.99998 8.6 6.59998 8 6.59998H6C5.4 6.59998 5 6.99998 5 7.59998C5 8.19998 5.4 8.59998 6 8.59998H8C8.6 8.59998 9 8.19998 9 7.59998ZM13 7.59998C13 6.99998 12.6 6.59998 12 6.59998H11C10.4 6.59998 10 6.99998 10 7.59998C10 8.19998 10.4 8.59998 11 8.59998H12C12.6 8.59998 13 8.19998 13 7.59998ZM13 15.6C13 15 12.6 14.6 12 14.6H10C9.4 14.6 9 15 9 15.6C9 16.2 9.4 16.6 10 16.6H12C12.6 16.6 13 16.2 13 15.6Z" fill="currentColor"></path>
										<path d="M15 18.6C15 20.3 16.3 21.6 18 21.6C19.7 21.6 21 20.3 21 18.6V12.5C21 12.2 20.6 12 20.3 12.2L19 13.6L17.7 12.3C17.3 11.9 16.7 11.9 16.3 12.3L15 13.6V18.6Z" fill="currentColor"></path>
									</svg>
								</span>
                                            <!--end::Svg Icon-->
                                            <div class="text-gray-100 fw-bolder fs-2 mb-2 mt-5">{{ eur($wallet->balance_actual) }}</div>
                                            <div class="fw-bold text-gray-100">Solde du compte</div>
                                        </div>
                                        <!--end::Body-->
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="#" class="card bg-bank hoverable card-xl-stretch mb-xl-8">
                                        <!--begin::Body-->
                                        <div class="card-body">
                                            <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm008.svg-->
                                            <span class="svg-icon svg-icon-gray-100 svg-icon-3x ms-n1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M18 21.6C16.3 21.6 15 20.3 15 18.6V2.50001C15 2.20001 14.6 1.99996 14.3 2.19996L13 3.59999L11.7 2.3C11.3 1.9 10.7 1.9 10.3 2.3L9 3.59999L7.70001 2.3C7.30001 1.9 6.69999 1.9 6.29999 2.3L5 3.59999L3.70001 2.3C3.50001 2.1 3 2.20001 3 3.50001V18.6C3 20.3 4.3 21.6 6 21.6H18Z" fill="currentColor"></path>
                                                    <path d="M12 12.6H11C10.4 12.6 10 12.2 10 11.6C10 11 10.4 10.6 11 10.6H12C12.6 10.6 13 11 13 11.6C13 12.2 12.6 12.6 12 12.6ZM9 11.6C9 11 8.6 10.6 8 10.6H6C5.4 10.6 5 11 5 11.6C5 12.2 5.4 12.6 6 12.6H8C8.6 12.6 9 12.2 9 11.6ZM9 7.59998C9 6.99998 8.6 6.59998 8 6.59998H6C5.4 6.59998 5 6.99998 5 7.59998C5 8.19998 5.4 8.59998 6 8.59998H8C8.6 8.59998 9 8.19998 9 7.59998ZM13 7.59998C13 6.99998 12.6 6.59998 12 6.59998H11C10.4 6.59998 10 6.99998 10 7.59998C10 8.19998 10.4 8.59998 11 8.59998H12C12.6 8.59998 13 8.19998 13 7.59998ZM13 15.6C13 15 12.6 14.6 12 14.6H10C9.4 14.6 9 15 9 15.6C9 16.2 9.4 16.6 10 16.6H12C12.6 16.6 13 16.2 13 15.6Z" fill="currentColor"></path>
                                                    <path d="M15 18.6C15 20.3 16.3 21.6 18 21.6C19.7 21.6 21 20.3 21 18.6V12.5C21 12.2 20.6 12 20.3 12.2L19 13.6L17.7 12.3C17.3 11.9 16.7 11.9 16.3 12.3L15 13.6V18.6Z" fill="currentColor"></path>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            <div class="text-gray-100 fw-bolder fs-2 mb-2 mt-5">{{ eur($wallet->balance_coming) }}</div>
                                            <div class="fw-bold text-gray-100">A Venir</div>
                                        </div>
                                        <!--end::Body-->
                                    </a>
                                </div>
                            </div>
                        @else
                            <a href="#" class="card @if($wallet->balance_actual <= 0) bg-danger @else bg-success @endif hoverable card-xl-stretch mb-xl-8">
                                <!--begin::Body-->
                                <div class="card-body">
                                    <!--begin::Svg Icon | path: icons/duotune/ecommerce/ecm008.svg-->
                                    <span class="svg-icon svg-icon-gray-100 svg-icon-3x ms-n1">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
										<path opacity="0.3" d="M18 21.6C16.3 21.6 15 20.3 15 18.6V2.50001C15 2.20001 14.6 1.99996 14.3 2.19996L13 3.59999L11.7 2.3C11.3 1.9 10.7 1.9 10.3 2.3L9 3.59999L7.70001 2.3C7.30001 1.9 6.69999 1.9 6.29999 2.3L5 3.59999L3.70001 2.3C3.50001 2.1 3 2.20001 3 3.50001V18.6C3 20.3 4.3 21.6 6 21.6H18Z" fill="currentColor"></path>
										<path d="M12 12.6H11C10.4 12.6 10 12.2 10 11.6C10 11 10.4 10.6 11 10.6H12C12.6 10.6 13 11 13 11.6C13 12.2 12.6 12.6 12 12.6ZM9 11.6C9 11 8.6 10.6 8 10.6H6C5.4 10.6 5 11 5 11.6C5 12.2 5.4 12.6 6 12.6H8C8.6 12.6 9 12.2 9 11.6ZM9 7.59998C9 6.99998 8.6 6.59998 8 6.59998H6C5.4 6.59998 5 6.99998 5 7.59998C5 8.19998 5.4 8.59998 6 8.59998H8C8.6 8.59998 9 8.19998 9 7.59998ZM13 7.59998C13 6.99998 12.6 6.59998 12 6.59998H11C10.4 6.59998 10 6.99998 10 7.59998C10 8.19998 10.4 8.59998 11 8.59998H12C12.6 8.59998 13 8.19998 13 7.59998ZM13 15.6C13 15 12.6 14.6 12 14.6H10C9.4 14.6 9 15 9 15.6C9 16.2 9.4 16.6 10 16.6H12C12.6 16.6 13 16.2 13 15.6Z" fill="currentColor"></path>
										<path d="M15 18.6C15 20.3 16.3 21.6 18 21.6C19.7 21.6 21 20.3 21 18.6V12.5C21 12.2 20.6 12 20.3 12.2L19 13.6L17.7 12.3C17.3 11.9 16.7 11.9 16.3 12.3L15 13.6V18.6Z" fill="currentColor"></path>
									</svg>
								</span>
                                    <!--end::Svg Icon-->
                                    <div class="text-gray-100 fw-bolder fs-2 mb-2 mt-5">{{ eur($wallet->balance_actual) }}</div>
                                    <div class="fw-bold text-gray-100">Solde du compte</div>
                                </div>
                                <!--end::Body-->
                            </a>
                        @endif
                        <div class="card card-flush">
                            <!--begin::Card header-->
                            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-4">
												<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
													<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
													<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
												</svg>
											</span>
                                        <!--end::Svg Icon-->
                                        <input type="text" data-kt-ecommerce-order-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Rechercher une transaction" />
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <!--end::Card title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                    <!--begin::Flatpickr-->
                                    <div class="input-group w-250px">
                                        <input class="form-control form-control-solid rounded rounded-end-0" placeholder="Date des mouvement" id="date_transaction" />
                                        <button class="btn btn-icon btn-light" id="date_transaction_clear">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr088.svg-->
                                            <span class="svg-icon svg-icon-2">
													<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
														<rect opacity="0.5" x="7.05025" y="15.5356" width="12" height="2" rx="1" transform="rotate(-45 7.05025 15.5356)" fill="black" />
														<rect x="8.46447" y="7.05029" width="12" height="2" rx="1" transform="rotate(45 8.46447 7.05029)" fill="black" />
													</svg>
												</span>
                                            <!--end::Svg Icon-->
                                        </button>
                                    </div>
                                    <!--end::Flatpickr-->
                                    <div class="w-100 mw-150px">
                                        <!--begin::Select2-->
                                        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Type de mouvement" data-kt-ecommerce-order-filter="type">
                                            <option></option>
                                            <option value="all">All</option>
                                            <option value="depot">Dépot</option>
                                            <option value="retrait">Retrait</option>
                                            <option value="payment">Paiement CB</option>
                                            <option value="virement">Virement Bancaire</option>
                                            <option value="sepa">Prélèvement Bancaire</option>
                                            <option value="frais">Frais Bancaire</option>
                                            <option value="souscription">Souscription</option>
                                            <option value="autre">Autre</option>
                                        </select>
                                        <!--end::Select2-->
                                    </div>
                                    <!--begin::Add product-->
                                    <a href="#add_mouvement" class="btn btn-primary" data-bs-toggle="modal">Nouveau Mouvement</a>
                                    <!--end::Add product-->
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="liste_transactions">
                                    <!--begin::Table head-->
                                    <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-100px"></th>
                                        <th class="min-w-175px">Date Opération</th>
                                        <th class="min-w-100px">Opération</th>
                                        <th class="text-end min-w-100px">Montant</th>
                                        <th class="text-end min-w-100px">Actions</th>
                                    </tr>
                                    <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                    <!--begin::Table row-->
                                    @foreach($wallet->transactions()->orderBy('created_at', 'desc')->get() as $transaction)
                                    <tr>
                                        <td data-order="{{ $transaction->type }}">
                                            {!! \App\Helper\CustomerTransactionHelper::getTypeTransaction($transaction->type, false, true) !!}
                                        </td>
                                        <td class="text-start" data-order="{{ $transaction->created_at->format('Y-m-d') }}">
                                            <span class="fw-bolder">{{ $transaction->created_at->format('d/m/Y') }}</span>
                                        </td>
                                        <td>{{ $transaction->designation }}</td>
                                        <td class="text-end">
                                            @if($transaction->amount >= 0)
                                                <span class="text-success fw-bolder">+ {{ eur($transaction->amount) }}</span>
                                            @else
                                                <span class="text-danger fw-bolder">{{ eur($transaction->amount) }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if($transaction->confirmed == false)
                                                <button class="btn btn-icon btn-sm btn-circle btn-bank btnConfirm" data-bs-toggle="tooltip" title="Confirmé l'écriture" data-transaction="{{ $transaction->id }}">
                                                    <span class="indicator-label" data-transaction="{{ $transaction->id }}">
                                                        <i class="fas fa-check" data-transaction="{{ $transaction->id }}"></i>
                                                    </span>
                                                    <span class="indicator-progress">
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                    </span>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                    <!--end::Table row-->
                                    @endforeach
                                    <!--end::Table row-->
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Card body-->
                        </div>
                    </div>
                    <!--end:::Tab pane-->
                    <!--begin:::Tab pane-->
                    <div class="tab-pane fade" id="infos" role="tabpanel">
                        <div class="card shadow-lg">
                            <div class="card-header bg-bank">
                                <h3 class="card-title text-white">Information sur le compte {{ $wallet->number_account }}</h3>
                                <div class="card-toolbar">
                                    <button type="button" class="btn btn-sm btn-light rotate" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-offset="30px, 30px">
                                        Action
                                        <i class="fa-solid fa-caret-down ms-2"></i>
                                    </button>
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px" data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content fs-6 text-dark fw-bolder px-3 py-4">Outils</div>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu separator-->
                                        <div class="separator mb-3 opacity-75"></div>
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{ route('agent.customer.wallet.showRib', [$wallet->customer_id, $wallet->id]) }}" class="menu-link px-3">
                                                Afficher le RIB
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                        @if($wallet->decouvert == false)
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3 mb-2">
                                                <a href="#" id="btnDecouvertRequest" class="menu-link px-3">
                                                    Demander un découvert
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                        @endif


                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="chart_summary" class="mb-10" style="height: 350px;"></div>
                                <div class="row mb-5">
                                    <div class="col-4">
                                        <div class="fw-bolder mt-5">Numéro de compte</div>
                                        <div class="text-gray-600">{{ $wallet->number_account }}</div>
                                    </div>
                                    <div class="col-4">
                                        <div class="fw-bolder mt-5">IBAN</div>
                                        <div class="text-gray-600">{{ $wallet->iban }}</div>
                                    </div>
                                    <div class="col-4">
                                        <div class="fw-bolder mt-5">Type</div>
                                        <div class="text-gray-600">{{ Str::ucfirst($wallet->type) }}</div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-5">
                                        <h3 class="fw-bolder text-center mb-3">Paiements</h3>
                                        <div class="d-flex flex-row justify-content-between bg-gray-200 p-5 rounded">
                                            <div class="d-flex flex-column flex-center">
                                                <i class="fa-solid fa-money-check-dollar fa-3x"></i>
                                                <span class="fw-bolder fs-3">Chèques</span>
                                                <span class="fw-bolder fs-2">0</span>
                                                <span class="fs-6">0,00 €</span>
                                                <div class="text-muted">en moyenne</div>
                                            </div>
                                            <div class="d-flex flex-column flex-center">
                                                <i class="fa-solid fa-credit-card fa-3x"></i>
                                                <span class="fw-bolder fs-3">Achat CB</span>
                                                <span class="fw-bolder fs-2">{{ \App\Models\Customer\CustomerTransaction::where('customer_wallet_id', $wallet->id)->where('type', 'payment')->get()->count() }}</span>
                                                <span class="fs-6">{{ eur(\App\Models\Customer\CustomerTransaction::where('customer_wallet_id', $wallet->id)->where('type', 'payment')->avg('amount')) }}</span>
                                                <div class="text-muted">en moyenne</div>
                                            </div>
                                            <div class="d-flex flex-column flex-center">
                                                <i class="fa-solid fa-money-bill-transfer fa-3x"></i>
                                                <span class="fw-bolder fs-3">Prélèvements</span>
                                                <span class="fw-bolder fs-2">{{ \App\Models\Customer\CustomerTransaction::where('customer_wallet_id', $wallet->id)->where('type', 'sepa')->get()->count() }}</span>
                                                <span class="fs-6">{{ eur(\App\Models\Customer\CustomerTransaction::where('customer_wallet_id', $wallet->id)->where('type', 'sepa')->avg('amount')) }}</span>
                                                <div class="text-muted">en moyenne</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <h3 class="fw-bolder text-center mb-3">Retraits</h3>
                                        <div class="d-flex flex-row justify-content-between bg-gray-200 p-5 rounded">
                                            <div class="d-flex flex-column flex-center">
                                                <i class="fa-solid fa-building fa-3x"></i>
                                                <span class="fw-bolder fs-3">Guichet</span>
                                                <span class="fw-bolder fs-2">0</span>
                                                <span class="fs-6">0,00 €</span>
                                                <div class="text-muted">en moyenne</div>
                                            </div>
                                            <div class="d-flex flex-column flex-center">
                                                <i class="fa-solid fa-money-bill fa-3x"></i>
                                                <span class="fw-bolder fs-3">Retrait DAB</span>
                                                <span class="fw-bolder fs-2">0</span>
                                                <span class="fs-6">0,00 €</span>
                                                <div class="text-muted">en moyenne</div>
                                            </div>
                                            <div class="d-flex flex-column flex-center">
                                                <i class="fa-solid fa-money-bill fa-3x"></i>
                                                <span class="fw-bolder fs-3">Retrait DABV</span>
                                                <span class="fw-bolder fs-2">0</span>
                                                <span class="fs-6">0,00 €</span>
                                                <div class="text-muted">en moyenne</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="d-flex flex-column">
                                            <div class="d-flex flex-column flex-center bg-light-success p-5 rounded text-center mb-3">
                                                <span class="fw-bolder fs-2">0,00 €</span>
                                                <div class="fs-6">Recette Moyenne</div>
                                            </div>
                                            <div class="d-flex flex-column flex-center bg-light-danger p-5 rounded text-center mb-3">
                                                <span class="fw-bolder fs-2">0,00 €</span>
                                                <div class="fs-6">Débit Moyen</div>
                                            </div>
                                            <div class="d-flex flex-column flex-center bg-light-info p-5 rounded text-center mb-3">
                                                <span class="fw-bolder fs-2">0,00 €</span>
                                                <div class="fs-6">Découvert Autorisé</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end:::Tab pane-->
                    <!--begin:::Tab pane-->
                    <div class="tab-pane fade" id="wallets" role="tabpanel">

                    </div>
                    <!--end:::Tab pane-->
                    <!--begin:::Tab pane-->
                    <div class="tab-pane fade" id="files" role="tabpanel">

                    </div>
                    <!--end:::Tab pane-->
                    <!--begin:::Tab pane-->
                    <div class="tab-pane fade" id="simulate" role="tabpanel">

                    </div>
                    <!--end:::Tab pane-->
                    <!--begin:::Tab pane-->
                    <div class="tab-pane fade" id="support" role="tabpanel">

                    </div>
                    <!--end:::Tab pane-->
                </div>
                <!--end:::Tab content-->
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="add_mouvement">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Nouveau mouvement sur le compte</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formAddTransaction" action="{{ route('customer.wallet.transaction.store', [$wallet->customer_id, $wallet->id]) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="service" class="form-label">Service Associé</label>
                            <select class="form-select form-select-solid" id="service" name="service" data-control="select2" data-dropdown-parent="#add_mouvement" data-placeholder="Services" data-allow-clear="true" onchange="selectedService(this)">
                                <option></option>
                                @foreach(\App\Models\Core\Service::all() as $service)
                                    <option value="{{ $service->name }}" data-price="{{ $service->price }}">{{ $service->name }} ({{ eur($service->price) }})</option>
                                @endforeach
                            </select>
                        </div>
                        <x-form.input
                            name="designation"
                            type="text"
                            label="Désignation"
                            required="true" />

                        <x-form.input
                            name="description"
                            type="text"
                            label="Description" />

                        <x-form.input-group
                            name="amount"
                            label="Montant de la transaction"
                            symbol="€"
                            placement="left"
                            required="true" />

                        <x-form.checkbox
                            name="confirmed"
                            label="Confirmé"
                            value="true"
                            checked="true" />
                    </div>

                    <div class="modal-footer">
                        <x-form.button />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="decouvert_request">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Demande de découvert pour le compte {{ $wallet->number_account }}</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formRequestDecouvert" action="{{ route('agent.customer.wallet.requestDecouvert', [$wallet->customer_id, $wallet->id]) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div id="outstanding"></div>
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
    @include("agent.scripts.customer.wallet.show")
@endsection
