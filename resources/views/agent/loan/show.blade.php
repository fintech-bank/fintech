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
                <a href="{{ route('agent.loan.all') }}" class="text-muted text-hover-primary">Pret Bancaire</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">{{ $loan->reference }} - {{ $loan->plan->name }}</li>
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
                                <i class="fa-solid fa-building fa-4x"></i>
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Name-->
                            <a href="#"
                               class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-1">{{ $loan->reference }}</a>
                            <!--end::Name-->
                            <!--begin::Position-->
                            <div
                                class="fs-5 fw-bold text-muted mb-6">{{ $loan->plan->name }}</div>
                            <!--end::Position-->
                            {!! \App\Helper\CustomerLoanHelper::getStatusLoan($loan->status) !!}
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
                                <div class="fw-bolder mt-5">Montant demander</div>
                                <div class="text-gray-600">{{ eur($loan->amount_loan) }}</div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bolder mt-5">Montant du</div>
                                <div class="text-gray-600">{{ eur($loan->amount_du) }}</div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bolder mt-5">Mensualité</div>
                                <div class="text-gray-600">{{ eur($loan->mensuality) }} / par mois</div>
                                <!--begin::Details item-->

                                <!--begin::Details item-->
                                <div class="fw-bolder mt-5">Durée</div>
                                <div class="text-gray-600">{{ $loan->duration }} mois</div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bolder mt-5">Jours de prélèvement</div>
                                <div class="text-gray-600">{{ $loan->prlv_day }} de chaque mois</div>

                                <div class="fw-bolder mt-5">Client</div>
                                <div class="d-flex align-items-center mb-7">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-50px me-5">
                                        <div class="symbol-label fs-2 fw-bold text-{{ random_color() }}">{{ Str::limit($loan->customer->info->firstname, 2, '') }}</div>
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Text-->
                                    <div class="flex-grow-1">
                                        <a href="{{ route('agent.customer.show', $loan->customer->id) }}" class="text-dark fw-bolder text-hover-primary fs-6">{{ \App\Helper\CustomerHelper::getName($loan->customer) }}</a>
                                        <span class="text-muted d-block fw-bold">{!! \App\Helper\CustomerHelper::getTypeCustomer($loan->customer->info->type, true) !!}</span>
                                    </div>
                                    <!--end::Text-->
                                </div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bolder mt-5">Compte de prélèvement</div>
                                <a href="{{ route('agent.customer.wallet.show', [$loan->customer->id, $loan->payment->id]) }}" class="text-gray-600">{{ $loan->payment->number_account }}</a>
                                <!--begin::Details item-->
                            </div>
                        </div>
                        <!--end::Details content-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->
            </div>
            <div class="flex-lg-row-fluid ms-lg-15">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">Pret bancaire N°{{ $loan->reference }}</h3>
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-light">
                                Action
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="liste_transaction">
                            <!--begin::Table head-->
                            <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">Date</th>
                                <th class="min-w-125px">Libellée</th>
                                <th class="min-w-125px">Débit</th>
                                <th class="min-w-125px">Crédit</th>
                            </tr>
                            <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-bold text-gray-600">
                            @foreach($loan->wallet->transactions()->where('type', 'sepa')->where('type', 'facelia')->get() as $transaction)
                                <tr>
                                    <td>{{ $transaction->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $transaction->designation }}</td>
                                    <td>
                                        @if($transaction->amount < 0)
                                            {{ eur($transaction->amount) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaction->amount > 0)
                                            {{ eur($transaction->amount) }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                    <div class="card-footer">
                        Footer
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("agent.scripts.loan.show")
@endsection
