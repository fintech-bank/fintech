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
                            <div class="fw-bold mt-5">Derniers opération</div>
                            <div class="text-gray-600">
                                {{ $card->transactions()->where('confirmed', true)->orderBy('confirmed_at', 'asc')->first()->confirmed_at->format('d/m/Y à H:i') }}
                            </div>
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
                        <button class="btn btn-sm btn-outline btn-outline-primary text-hover-white">Modifier</button>
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
                    <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#settings" data-kt-initialized="1" aria-selected="false" tabindex="-1" role="tab">Configuration</a>
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
                            <div class="card-toolbar">
                                <button type="button" class="btn btn-sm btn-light">
                                    Action
                                </button>
                            </div>
                        </div>
                        <div class="card-body py-5">

                        </div>
                    </div>
                </div>
                <!--end:::Tab pane-->
                <!--begin:::Tab pane-->
                <div class="tab-pane fade" id="settings" role="tabpanel">

                </div>
                <!--end:::Tab pane-->
            </div>
            <!--end:::Tab content-->
        </div>
        <!--end::Content-->
    </div>
@endsection

@section("script")
    @include("customer.scripts.payment.show")
@endsection
