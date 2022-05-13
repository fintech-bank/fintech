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
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Client: {{ \App\Helper\CustomerHelper::getName($customer) }}
                - {{ $customer->user->identifiant }}</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="container-fluid">
    @if($customer->info->isVerified == 0)
        <!--begin::Alert-->
            <div class="alert alert-dismissible bg-warning d-flex flex-column flex-sm-row p-5 mb-10">
                <!--begin::Icon-->
                <i class="fa-solid fa-warning fa-2x text-light me-4 mb-5 mb-sm-0"></i>
                <!--end::Icon-->

                <!--begin::Wrapper-->
                <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                    <!--begin::Title-->
                    <h4 class="mb-2 light text-light">Vérification identité</h4>
                    <!--end::Title-->

                    <!--begin::Content-->
                    <span>L'identité de ce client n'à pas été vérifier</span>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Close-->
                <a href="{{ route('agent.customer.verify.start', $customer->id) }}" id="btnVerify"
                   class="btn btn-sm btn-light-warning position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 ms-sm-auto">
                        <span class="indicator-label">
                            Vérifier
                        </span>
                    <span class="indicator-progress">
                            Veuillez Patienté... <span
                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                </a>
                <!--<button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                    <span class="svg-icon svg-icon-2x svg-icon-light">...</span>
                </button>-->
                <!--end::Close-->
            </div>
            <!--end::Alert-->
        @endif
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
                                {!! \App\Helper\UserHelper::getAvatar($customer->user->email) !!}
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Name-->
                            <a href="#"
                               class="fs-3 text-gray-800 text-hover-primary fw-bolder mb-1">{{ \App\Helper\CustomerHelper::getName($customer) }}</a>
                            <!--end::Name-->
                            <!--begin::Position-->
                            <div
                                class="fs-5 fw-bold text-muted mb-6">{!! \App\Helper\CustomerHelper::getTypeCustomer($customer->info->type, true) !!}</div>
                            <!--end::Position-->
                            <!--begin::Info-->
                            <div class="d-flex flex-wrap flex-center">
                                <!--begin::Stats-->
                                <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                    <div class="fs-4 fw-bolder text-gray-700">
                                        <span
                                            class="w-75px">{{ \App\Helper\CustomerHelper::getAmountAllDeposit($customer) }}</span>
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr066.svg-->
                                        <span class="svg-icon svg-icon-3 svg-icon-success">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
												<rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1"
                                                      transform="rotate(90 13 6)" fill="currentColor"></rect>
												<path
                                                    d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                                                    fill="currentColor"></path>
											</svg>
										</span>
                                        <!--end::Svg Icon-->
                                    </div>
                                    <div class="fw-bold text-muted">Dépots</div>
                                </div>
                                <!--end::Stats-->
                                <!--begin::Stats-->
                                <div class="border border-gray-300 border-dashed rounded py-3 px-3 mx-4 mb-3">
                                    <div class="fs-4 fw-bolder text-gray-700">
                                        <span
                                            class="w-50px">{{ \App\Helper\CustomerHelper::getAmountAllWithdraw($customer) }}</span>
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr065.svg-->
                                        <span class="svg-icon svg-icon-3 svg-icon-danger">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
												<rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1"
                                                      transform="rotate(-90 11 18)" fill="currentColor"></rect>
												<path
                                                    d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z"
                                                    fill="currentColor"></path>
											</svg>
										</span>
                                        <!--end::Svg Icon-->
                                    </div>
                                    <div class="fw-bold text-muted">Retraits</div>
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Info-->
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
                                <!--begin::Badge-->
                                <div class="badge badge-light-info d-inline" data-bs-toggle="tooltip"
                                     data-bs-trigger="hover" title="{{ eur($customer->package->price) }} / par mois">
                                    Pack {{ $customer->package->name }}</div>
                                <!--begin::Badge-->
                                <!--begin::Details item-->
                                <div class="fw-bolder mt-5">Identifiant</div>
                                <div class="text-gray-600">{{ $customer->user->identifiant }}</div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bolder mt-5">Adresse Mail</div>
                                <div class="text-gray-600">
                                    <a href="#"
                                       class="text-gray-600 text-hover-primary">{{ $customer->user->email }}</a>
                                </div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bolder mt-5">Adresse Postal</div>
                                <div class="text-gray-600">
                                    {{ $customer->info->address }}<br>
                                    @isset($customer->info->addressbis)
                                        {{ $customer->info->addressbis }}<br>
                                    @endisset
                                    {{ $customer->info->postal }} {{ $customer->info->city }}<br>
                                    {{ $customer->info->country }}
                                </div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bolder mt-5">Téléphone Portable</div>
                                <div class="text-gray-600">{{ $customer->info->mobile }}</div>
                                <!--begin::Details item-->
                                @isset($customer->info->phone)
                                    <div class="fw-bolder mt-5">Téléphone Fixe</div>
                                    <div class="text-gray-600">{{ $customer->info->phone }}</div>
                                @endisset
                            <!--begin::Details item-->
                                <div class="fw-bolder mt-5">Etat du compte</div>
                                <div
                                    class="text-gray-600">{!! \App\Helper\CustomerHelper::getStatusOpenAccount($customer->status_open_account, true) !!}</div>
                                <!--begin::Details item-->
                                <!--begin::Details item-->
                                <div class="fw-bolder mt-5">Cotation</div>
                                @if($customer->cotation == 0 && $customer->cotation <= 4)
                                    <div class="badge badge-danger" data-bs-toggle="tooltip"
                                         title="Basée sur l'ensemble des mouvements de tous les comptes">{{ $customer->cotation }}</div>
                                @elseif($customer->cotation >= 5 && $customer->cotation <= 8)
                                    <div class="badge badge-warning" data-bs-toggle="tooltip"
                                         title="Basée sur l'ensemble des mouvements de tous les comptes">{{ $customer->cotation }}</div>
                                @else
                                    <div class="badge badge-success" data-bs-toggle="tooltip"
                                         title="Basée sur l'ensemble des mouvements de tous les comptes">{{ $customer->cotation }}</div>
                            @endif
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
                <!--begin:::Tabs-->
                <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-8">
                    <!--begin:::Tab item-->
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                           href="#overview">Aperçu</a>
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
                           href="#wallets">Comptes bancaire</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab"
                           href="#files">Fichiers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab"
                           href="#simulate">Simulations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab"
                           href="#support">Supports</a>
                    </li>
                    <!--end:::Tab item-->
                    <!--begin:::Tab item-->
                    <li class="nav-item ms-auto">
                        <!--begin::Action menu-->
                        <a href="#" class="btn btn-primary ps-7" data-kt-menu-trigger="click"
                           data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">Outils
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                            <span class="svg-icon svg-icon-2 me-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <path
                                        d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>
                        </a>
                        <!--begin::Menu-->
                        <div
                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold py-4 w-250px fs-6"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <div class="menu-content text-muted pb-2 px-5 fs-7 text-uppercase">Générale</div>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="#updateStatus" data-bs-toggle="modal" class="menu-link px-5">Changer l'état du
                                    compte client</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="#updateAccount" data-bs-toggle="modal" class="menu-link px-5">Changer le type
                                    de compte</a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                        <!--end::Menu-->
                    </li>
                    <!--end:::Tab item-->
                    <li class="nav-item ms-3">
                        <a href="#" class="btn btn-circle btn-primary btn-icon" data-kt-menu-trigger="hover" data-kt-menu-placement="bottom-start">
                            <i class="fa-solid fa-headset"></i>
                        </a>
                        <!--begin::Menu-->
                        <div
                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold py-4 w-250px fs-6"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-5">
                                <a href="tel:{{ $customer->info->phone }}" class="menu-link px-5"><i class="fa-solid fa-phone me-3"></i> Téléphone Fixe</a>
                            </div>
                            <!--end::Menu item-->
                            <div class="menu-item px-5">
                                <a href="tel:{{ $customer->info->mobile }}" class="menu-link px-5"><i class="fa-solid fa-mobile me-3"></i> Téléphone Mobile</a>
                            </div>
                            <!--end::Menu item-->
                            <div class="menu-item px-5">
                                <a href="#write-sms" data-bs-toggle="modal" class="menu-link px-5"><i class="fa-solid fa-comment-sms me-3"></i> Envoyer un sms</a>
                            </div>
                            <div class="menu-item px-5">
                                <a href="#write-mail" data-bs-toggle="modal" class="menu-link px-5"><i class="fa-solid fa-envelope me-3"></i> Envoyer un Email</a>
                            </div>
                        </div>
                        <!--end::Menu-->
                    </li>
                </ul>
                <!--end:::Tabs-->
                <!--begin:::Tab content-->
                <div class="tab-content" id="myTabContent">
                    <!--begin:::Tab pane-->
                    <div class="tab-pane fade show active" id="overview" role="tabpanel">
                        <div class="row g-5 g-xl-8">
                            <div class="col-xl-3">
                                <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                                        <span class="svg-icon svg-icon-success svg-icon-3x ms-n1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M13 9.59998V21C13 21.6 12.6 22 12 22C11.4 22 11 21.6 11 21V9.59998H13Z"
                                                fill="currentColor"/>
                                            <path opacity="0.3"
                                                  d="M4 9.60002H20L12.7 2.3C12.3 1.9 11.7 1.9 11.3 2.3L4 9.60002Z"
                                                  fill="currentColor"/>
                                            </svg>
										</span>
                                        <!--end::Svg Icon-->
                                        <div
                                            class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">{{ \App\Helper\CustomerHelper::getAmountAllDeposit($customer) }}</div>
                                        <div class="fw-bold text-gray-400">Total déposé</div>
                                    </div>
                                    <!--end::Body-->
                                </a>
                            </div>
                            <div class="col-xl-3">
                                <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                                        <span class="svg-icon svg-icon-danger svg-icon-3x ms-n1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.5"
                                                  d="M13 14.4V3.00003C13 2.40003 12.6 2.00003 12 2.00003C11.4 2.00003 11 2.40003 11 3.00003V14.4H13Z"
                                                  fill="currentColor"/>
                                            <path
                                                d="M5.7071 16.1071C5.07714 15.4771 5.52331 14.4 6.41421 14.4H17.5858C18.4767 14.4 18.9229 15.4771 18.2929 16.1071L12.7 21.7C12.3 22.1 11.7 22.1 11.3 21.7L5.7071 16.1071Z"
                                                fill="currentColor"/>
                                            </svg>
										</span>
                                        <!--end::Svg Icon-->
                                        <div
                                            class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">{{ \App\Helper\CustomerHelper::getAmountAllWithdraw($customer) }}</div>
                                        <div class="fw-bold text-gray-400">Total Retiré</div>
                                    </div>
                                    <!--end::Body-->
                                </a>
                            </div>
                            <div class="col-xl-3">
                                <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                                        <span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M7 6.59998V20C7 20.6 7.4 21 8 21C8.6 21 9 20.6 9 20V6.59998H7ZM15 17.4V4C15 3.4 15.4 3 16 3C16.6 3 17 3.4 17 4V17.4H15Z"
                                                fill="currentColor"/>
                                            <path opacity="0.3"
                                                  d="M3 6.59999H13L8.7 2.3C8.3 1.9 7.7 1.9 7.3 2.3L3 6.59999ZM11 17.4H21L16.7 21.7C16.3 22.1 15.7 22.1 15.3 21.7L11 17.4Z"
                                                  fill="currentColor"/>
                                            </svg>
										</span>
                                        <!--end::Svg Icon-->
                                        <div
                                            class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">{{ \App\Helper\CustomerHelper::getAmountAllTransfers($customer) }}</div>
                                        <div class="fw-bold text-gray-400">Total Transféré</div>
                                    </div>
                                    <!--end::Body-->
                                </a>
                            </div>
                            <div class="col-xl-3">
                                <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                                        <span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3"
                                                  d="M3.20001 5.91897L16.9 3.01895C17.4 2.91895 18 3.219 18.1 3.819L19.2 9.01895L3.20001 5.91897Z"
                                                  fill="currentColor"/>
                                            <path opacity="0.3"
                                                  d="M13 13.9189C13 12.2189 14.3 10.9189 16 10.9189H21C21.6 10.9189 22 11.3189 22 11.9189V15.9189C22 16.5189 21.6 16.9189 21 16.9189H16C14.3 16.9189 13 15.6189 13 13.9189ZM16 12.4189C15.2 12.4189 14.5 13.1189 14.5 13.9189C14.5 14.7189 15.2 15.4189 16 15.4189C16.8 15.4189 17.5 14.7189 17.5 13.9189C17.5 13.1189 16.8 12.4189 16 12.4189Z"
                                                  fill="currentColor"/>
                                            <path
                                                d="M13 13.9189C13 12.2189 14.3 10.9189 16 10.9189H21V7.91895C21 6.81895 20.1 5.91895 19 5.91895H3C2.4 5.91895 2 6.31895 2 6.91895V20.9189C2 21.5189 2.4 21.9189 3 21.9189H19C20.1 21.9189 21 21.0189 21 19.9189V16.9189H16C14.3 16.9189 13 15.6189 13 13.9189Z"
                                                fill="currentColor"/>
                                            </svg>
										</span>
                                        <!--end::Svg Icon-->
                                        <div
                                            class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">{{ \App\Helper\CustomerHelper::getAmountAllTransactions($customer) }}</div>
                                        <div class="fw-bold text-gray-400">Transactions</div>
                                    </div>
                                    <!--end::Body-->
                                </a>
                            </div>
                            <div class="col-xl-3">
                                <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                                        <span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3"
                                                  d="M15.8 11.4H6C5.4 11.4 5 11 5 10.4C5 9.80002 5.4 9.40002 6 9.40002H15.8C16.4 9.40002 16.8 9.80002 16.8 10.4C16.8 11 16.3 11.4 15.8 11.4ZM15.7 13.7999C15.7 13.1999 15.3 12.7999 14.7 12.7999H6C5.4 12.7999 5 13.1999 5 13.7999C5 14.3999 5.4 14.7999 6 14.7999H14.8C15.3 14.7999 15.7 14.2999 15.7 13.7999Z"
                                                  fill="currentColor"/>
                                            <path
                                                d="M18.8 15.5C18.9 15.7 19 15.9 19.1 16.1C19.2 16.7 18.7 17.2 18.4 17.6C17.9 18.1 17.3 18.4999 16.6 18.7999C15.9 19.0999 15 19.2999 14.1 19.2999C13.4 19.2999 12.7 19.2 12.1 19.1C11.5 19 11 18.7 10.5 18.5C10 18.2 9.60001 17.7999 9.20001 17.2999C8.80001 16.8999 8.49999 16.3999 8.29999 15.7999C8.09999 15.1999 7.80001 14.7 7.70001 14.1C7.60001 13.5 7.5 12.8 7.5 12.2C7.5 11.1 7.7 10.1 8 9.19995C8.3 8.29995 8.79999 7.60002 9.39999 6.90002C9.99999 6.30002 10.7 5.8 11.5 5.5C12.3 5.2 13.2 5 14.1 5C15.2 5 16.2 5.19995 17.1 5.69995C17.8 6.09995 18.7 6.6 18.8 7.5C18.8 7.9 18.6 8.29998 18.3 8.59998C18.2 8.69998 18.1 8.69993 18 8.79993C17.7 8.89993 17.4 8.79995 17.2 8.69995C16.7 8.49995 16.5 7.99995 16 7.69995C15.5 7.39995 14.9 7.19995 14.2 7.19995C13.1 7.19995 12.1 7.6 11.5 8.5C10.9 9.4 10.5 10.6 10.5 12.2C10.5 13.3 10.7 14.2 11 14.9C11.3 15.6 11.7 16.1 12.3 16.5C12.9 16.9 13.5 17 14.2 17C15 17 15.7 16.8 16.2 16.4C16.8 16 17.2 15.2 17.9 15.1C18 15 18.5 15.2 18.8 15.5Z"
                                                fill="currentColor"/>
                                            </svg>
										</span>
                                        <!--end::Svg Icon-->
                                        <div
                                            class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">{{ \App\Helper\CustomerHelper::getCountAllLoan($customer) }}</div>
                                        <div class="fw-bold text-gray-400">Prets</div>
                                    </div>
                                    <!--end::Body-->
                                </a>
                            </div>
                            <div class="col-xl-4">
                                <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                                        <span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M6 20C6 20.6 5.6 21 5 21C4.4 21 4 20.6 4 20H6ZM18 20C18 20.6 18.4 21 19 21C19.6 21 20 20.6 20 20H18Z"
                                                fill="currentColor"/>
                                            <path opacity="0.3"
                                                  d="M21 20H3C2.4 20 2 19.6 2 19V3C2 2.4 2.4 2 3 2H21C21.6 2 22 2.4 22 3V19C22 19.6 21.6 20 21 20ZM12 10H10.7C10.5 9.7 10.3 9.50005 10 9.30005V8C10 7.4 9.6 7 9 7C8.4 7 8 7.4 8 8V9.30005C7.7 9.50005 7.5 9.7 7.3 10H6C5.4 10 5 10.4 5 11C5 11.6 5.4 12 6 12H7.3C7.5 12.3 7.7 12.5 8 12.7V14C8 14.6 8.4 15 9 15C9.6 15 10 14.6 10 14V12.7C10.3 12.5 10.5 12.3 10.7 12H12C12.6 12 13 11.6 13 11C13 10.4 12.6 10 12 10Z"
                                                  fill="currentColor"/>
                                            <path
                                                d="M18.5 11C18.5 10.2 17.8 9.5 17 9.5C16.2 9.5 15.5 10.2 15.5 11C15.5 11.4 15.7 11.8 16 12.1V13C16 13.6 16.4 14 17 14C17.6 14 18 13.6 18 13V12.1C18.3 11.8 18.5 11.4 18.5 11Z"
                                                fill="currentColor"/>
                                            </svg>
										</span>
                                        <!--end::Svg Icon-->
                                        <div
                                            class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">{{ \App\Helper\CustomerHelper::getCoutAllEpargnes($customer) }}</div>
                                        <div class="fw-bold text-gray-400">Epargnes</div>
                                    </div>
                                    <!--end::Body-->
                                </a>
                            </div>
                            <div class="col-xl-5">
                                <a href="#" class="card bg-body hoverable card-xl-stretch mb-xl-8">
                                    <!--begin::Body-->
                                    <div class="card-body">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                                        <span class="svg-icon svg-icon-primary svg-icon-3x ms-n1">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M16.0173 9H15.3945C14.2833 9 13.263 9.61425 12.7431 10.5963L12.154 11.7091C12.0645 11.8781 12.1072 12.0868 12.2559 12.2071L12.6402 12.5183C13.2631 13.0225 13.7556 13.6691 14.0764 14.4035L14.2321 14.7601C14.2957 14.9058 14.4396 15 14.5987 15H18.6747C19.7297 15 20.4057 13.8774 19.912 12.945L18.6686 10.5963C18.1487 9.61425 17.1285 9 16.0173 9Z"
                                                fill="currentColor"/>
                                            <rect opacity="0.3" x="14" y="4" width="4" height="4" rx="2"
                                                  fill="currentColor"/>
                                            <path
                                                d="M4.65486 14.8559C5.40389 13.1224 7.11161 12 9 12C10.8884 12 12.5961 13.1224 13.3451 14.8559L14.793 18.2067C15.3636 19.5271 14.3955 21 12.9571 21H5.04292C3.60453 21 2.63644 19.5271 3.20698 18.2067L4.65486 14.8559Z"
                                                fill="currentColor"/>
                                            <rect opacity="0.3" x="6" y="5" width="6" height="6" rx="3"
                                                  fill="currentColor"/>
                                            </svg>
										</span>
                                        <!--end::Svg Icon-->
                                        <div
                                            class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">{{ \App\Helper\CustomerHelper::getCountAllBeneficiaires($customer) }}</div>
                                        <div class="fw-bold text-gray-400">Bénéficiaires</div>
                                    </div>
                                    <!--end::Body-->
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--end:::Tab pane-->
                    <!--begin:::Tab pane-->
                    <div class="tab-pane fade" id="infos" role="tabpanel">
                        <!--begin::Accordion-->
                        <div class="accordion" id="kt_accordion_1">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="kt_accordion_1_header_1">
                                    <button class="accordion-button fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_1" aria-expanded="true" aria-controls="kt_accordion_1_body_1">
                                        <i class="fa-solid fa-house me-3"></i> Adresse Postal
                                    </button>
                                </h2>
                                <div id="kt_accordion_1_body_1" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_1" data-bs-parent="#kt_accordion_1">
                                    <div class="accordion-body">
                                        <form action="{{ route('agent.customer.update', $customer->id) }}" method="post">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="control" value="address">
                                            <x-form.input
                                                name="address"
                                                type="text"
                                                label="Adresse Postal"
                                                required="true"
                                                value="{{ $customer->info->address }}" />
                                            <x-form.input
                                                name="addressbis"
                                                type="text"
                                                label="Complément d'adresse"
                                                value="{{ $customer->info->addressbis }}"/>

                                            <div class="row">
                                                <div class="col-4">
                                                    <x-form.input
                                                        name="postal"
                                                        type="text"
                                                        label="Code Postal"
                                                        required="true"
                                                        value="{{ $customer->info->postal }}"/>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-10" id="divCity"></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-10">
                                                        <label for="country" class="required form-label">
                                                            Pays de résidence
                                                        </label>
                                                        <select id="country" class="form-select form-select-solid" data-placeholder="Selectionnez un pays" name="country">
                                                            <option value=""></option>
                                                            @foreach(\App\Helper\GeoHelper::getAllCountries() as $data)
                                                                <option value="{{ $data->name }}" @if($customer->info->country == $data->name) selected @endif data-kt-select2-country="{{ $data->flag }}">{{ $data->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <x-form.button />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="kt_accordion_1_header_2">
                                    <button class="accordion-button fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_2" aria-expanded="false" aria-controls="kt_accordion_1_body_2">
                                        <i class="fa-solid fa-phone me-3"></i> Coordonnées
                                    </button>
                                </h2>
                                <div id="kt_accordion_1_body_2" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_2" data-bs-parent="#kt_accordion_1">
                                    <div class="accordion-body">
                                        <form action="{{ route('agent.customer.update', $customer->id) }}" method="post">
                                            @csrf
                                            @method("put")
                                            <input type="hidden" name="control" value="coordonnee">
                                            <x-form.input-group
                                                name="phone"
                                                label="Numéro de téléphone fixe"
                                                symbol="<i class='fa-solid fa-phone'></i>"
                                                placement="left"
                                                value="{{ $customer->info->phone }}" />

                                            <x-form.input-group
                                                name="mobile"
                                                label="Numéro de téléphone Portable"
                                                symbol="<i class='fa-solid fa-mobile'></i>"
                                                placement="left"
                                                value="{{ $customer->info->mobile }}" />

                                            <x-form.input-group
                                                name="email"
                                                label="Adresse Mail"
                                                symbol="<i class='fa-solid fa-envelope'></i>"
                                                placement="left"
                                                value="{{ $customer->user->email }}" />

                                            <div class="d-flex justify-content-end">
                                                <x-form.button />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="kt_accordion_1_header_3">
                                    <button class="accordion-button fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_3" aria-expanded="false" aria-controls="kt_accordion_1_body_3">
                                        <i class="fa-solid fa-user me-3"></i> Situation
                                    </button>
                                </h2>
                                <div id="kt_accordion_1_body_3" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_3" data-bs-parent="#kt_accordion_1">
                                    <div class="accordion-body">
                                        <form action="{{ route('agent.customer.update', $customer->id) }}" method="post">
                                            @csrf
                                            @method("put")
                                            <input type="hidden" name="control" value="situation">

                                            <x-base.underline title="Situation Personnel" size="3" sizeText="fs-1" color="bank" />
                                            <div class="row">
                                                <div class="col-6">
                                                    <x-form.select
                                                        name="legal_capacity"
                                                        :datas="\App\Helper\CustomerSituationHelper::dataLegalCapacity()"
                                                        label="Capacité Juridique" required="false"/>
                                                </div>
                                                <div class="col-6">
                                                    <x-form.select
                                                        name="family_situation"
                                                        :datas="\App\Helper\CustomerSituationHelper::dataFamilySituation()"
                                                        label="Situation Familiale" required="false"/>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <x-form.select
                                                        name="logement"
                                                        :datas="\App\Helper\CustomerSituationHelper::dataLogement()"
                                                        label="Dans votre logement, vous êtes" required="false"/>
                                                </div>
                                                <div class="col-6">
                                                    <x-form.input-date
                                                        name="logement_at"
                                                        type="text"
                                                        label="Depuis le"
                                                        value="{{ $customer->situation->logement_at }}" />
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <x-form.input-dialer
                                                        name="child"
                                                        label="Nombre d'enfant"
                                                        min="0"
                                                        max="99"
                                                        step="1"
                                                        value="{{ $customer->situation->nb_child }}" />
                                                </div>
                                                <div class="col-6">
                                                    <x-form.input-dialer
                                                        name="person_charged"
                                                        label="Nombre de personne à charge"
                                                        min="0"
                                                        max="99"
                                                        step="1"
                                                        value="{{ $customer->situation->person_charged }}" />
                                                </div>
                                            </div>
                                            <x-base.underline title="Situation Professionnel" size="3" sizeText="fs-1" color="bank" />
                                            <x-form.select
                                                name="pro_category"
                                                :datas="\App\Helper\CustomerSituationHelper::dataProCategories()"
                                                label="Catégorie sociaux Professionnel" />

                                            <x-form.input
                                                name="pro_profession"
                                                type="text"
                                                label="Profession"
                                            value="{{ $customer->situation->pro_profession }}"/>

                                            <x-base.underline title="Revenue" size="3" sizeText="fs-1" color="bank" />
                                            <div class="row">
                                                <div class="col-6">
                                                    <x-form.input-group
                                                        name="pro_incoming"
                                                        label="Revenue Professionnel"
                                                        placement="left"
                                                        symbol="€"
                                                        value="{{ $customer->income->pro_incoming }}" />
                                                </div>
                                                <div class="col-6">
                                                    <x-form.input-group
                                                        name="patrimoine"
                                                        label="Patrimoine"
                                                        placement="left"
                                                        symbol="€"
                                                        value="{{ $customer->income->patrimoine }}" />
                                                </div>
                                            </div>
                                            <x-base.underline title="Charges" size="3" sizeText="fs-1" color="bank" />
                                            <div class="row">
                                                <div class="col-6">
                                                    <x-form.input-group
                                                        name="rent"
                                                        label="Loyer, mensualité crédit immobilier"
                                                        placement="left"
                                                        symbol="€"
                                                        value="{{ $customer->charge->rent }}"/>
                                                </div>
                                                <div class="col-6">
                                                    <x-form.input-group
                                                        name="divers"
                                                        label="Charges Divers (pension, etc...)"
                                                        placement="left"
                                                        symbol="€"
                                                        value="{{ $customer->charge->divers }}"/>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <x-form.input
                                                        name="nb_credit"
                                                        type="text"
                                                        label="Nombre de crédit (Crédit Personnel, Renouvelable, etc...)"
                                                        value="{{ $customer->charge->nb_credit }}"/>
                                                </div>
                                                <div class="col-6">
                                                    <x-form.input-group
                                                        name="credit"
                                                        label="Mensualité de vos crédits"
                                                        placement="left"
                                                        symbol="€"
                                                        value="{{ $customer->charge->credit }}"/>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-end">
                                                <x-form.button />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="kt_accordion_1_header_4">
                                    <button class="accordion-button fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_4" aria-expanded="false" aria-controls="kt_accordion_1_body_3">
                                        <i class="fa-solid fa-message me-3"></i> Communication
                                    </button>
                                </h2>
                                <div id="kt_accordion_1_body_4" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_4" data-bs-parent="#kt_accordion_1">
                                    <div class="accordion-body">
                                        <form action="{{ route('agent.customer.update', $customer->id) }}" method="post">
                                            @csrf
                                            @method("put")
                                            <input type="hidden" name="control" value="communication">
                                            <x-form.checkbox
                                                name="notif_sms"
                                                label="Notification commercial SMS"
                                                value="{{ $customer->setting->notif_sms }}" />

                                            <x-form.checkbox
                                                name="notif_app"
                                                label="Notification commercial Application"
                                                value="{{ $customer->setting->notif_app }}" />

                                            <x-form.checkbox
                                                name="notif_mail"
                                                label="Notification commercial EMAIL"
                                                value="{{ $customer->setting->notif_mail }}" />

                                            <div class="d-flex justify-content-end">
                                                <x-form.button />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header " id="kt_accordion_1_header_5">
                                    <button class="accordion-button bg-light-danger text-hover-danger text-active-danger fs-4 fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kt_accordion_1_body_5" aria-expanded="false" aria-controls="kt_accordion_1_body_3">
                                        <i class="fa-solid fa-user-shield me-3"></i> Sécurité
                                    </button>
                                </h2>
                                <div id="kt_accordion_1_body_5" class="accordion-collapse collapse" aria-labelledby="kt_accordion_1_header_5" data-bs-parent="#kt_accordion_1">
                                    <div class="accordion-body">
                                        <x-form.button id="btnPass" text="Réinitialiser le mot de passe" :dataset="[
                                            [
                                            'name' => 'customer',
                                            'value' => $customer->id,
                                            ]
                                        ]"/>
                                        <x-form.button id="btnCode" text="Réinitialiser le code SECURIPASS" data-customer="{{ $customer->id }}" :dataset="[
                                            [
                                            'name' => 'customer',
                                            'value' => $customer->id,
                                            ]
                                        ]"/>
                                        @isset($customer->user->two_factor_secret)
                                        <x-form.button id="btnAuth" text="Réinitialiser l'authentification Double Facteur" data-customer="{{ $customer->id }}" :dataset="[
                                            [
                                            'name' => 'customer',
                                            'value' => $customer->id,
                                            ]
                                        ]"/>
                                        @endisset
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Accordion-->
                    </div>
                    <!--end:::Tab pane-->
                    <!--begin:::Tab pane-->
                    <div class="tab-pane fade" id="wallets" role="tabpanel">
                        <div class="card">
                            <!--begin::Card header-->
                            <div class="card-header border-0 pt-6">
                                <!--begin::Card title-->
                                <div class="card-title">
                                    <!--begin::Search-->
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                                <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                        <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Rechercher un compte" />
                                    </div>
                                    <!--end::Search-->
                                </div>
                                <!--begin::Card title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <!--begin::Toolbar-->
                                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                        <!--begin::Filter-->
                                        <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="black" />
                                                </svg>
                                            </span>
                                            Filtrer
                                        </button>
                                        <!--begin::Menu 1-->
                                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="kt-toolbar-filter">
                                            <!--begin::Header-->
                                            <div class="px-7 py-5">
                                                <div class="fs-4 text-dark fw-bolder">Options de filtre</div>
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Separator-->
                                            <div class="separator border-gray-200"></div>
                                            <!--end::Separator-->
                                            <!--begin::Content-->
                                            <div class="px-7 py-5">
                                                <!--begin::Input group-->
                                                <div class="mb-10">
                                                    <!--begin::Label-->
                                                    <label class="form-label fs-5 fw-bold mb-3">Type de compte:</label>
                                                    <!--end::Label-->
                                                    <!--begin::Options-->
                                                    <div class="d-flex flex-column flex-wrap fw-bold" data-kt-customer-table-filter="type_wallet">
                                                        <!--begin::Option-->
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                            <input class="form-check-input" type="radio" name="type_wallet" value="all" checked="checked" />
                                                            <span class="form-check-label text-gray-600">Tous</span>
                                                        </label>
                                                        <!--end::Option-->
                                                        <!--begin::Option-->
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                            <input class="form-check-input" type="radio" name="type_wallet" value="compte" />
                                                            <span class="form-check-label text-gray-600">Compte Courant</span>
                                                        </label>
                                                        <!--end::Option-->
                                                        <!--begin::Option-->
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                            <input class="form-check-input" type="radio" name="type_wallet" value="pret" />
                                                            <span class="form-check-label text-gray-600">Pret Bancaire</span>
                                                        </label>
                                                        <!--end::Option-->
                                                        <!--begin::Option-->
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                            <input class="form-check-input" type="radio" name="type_wallet" value="epargne" />
                                                            <span class="form-check-label text-gray-600">Compte Epargne</span>
                                                        </label>
                                                        <!--end::Option-->
                                                    </div>
                                                    <!--end::Options-->
                                                </div>
                                                <div class="mb-10">
                                                    <!--begin::Label-->
                                                    <label class="form-label fs-5 fw-bold mb-3">Type de client:</label>
                                                    <!--end::Label-->
                                                    <!--begin::Options-->
                                                    <div class="d-flex flex-column flex-wrap fw-bold" data-kt-customer-table-filter="status_wallet">
                                                        <!--begin::Option-->
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                            <input class="form-check-input" type="radio" name="status_wallet" value="all" checked="checked" />
                                                            <span class="form-check-label text-gray-600">Tous</span>
                                                        </label>
                                                        <!--end::Option-->
                                                        <!--begin::Option-->
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                            <input class="form-check-input" type="radio" name="status_wallet" value="pending" />
                                                            <span class="form-check-label text-gray-600">En attente</span>
                                                        </label>
                                                        <!--end::Option-->

                                                        <!--begin::Option-->
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                            <input class="form-check-input" type="radio" name="status_wallet" value="active" />
                                                            <span class="form-check-label text-gray-600">Actif</span>
                                                        </label>
                                                        <!--end::Option-->

                                                        <!--begin::Option-->
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                            <input class="form-check-input" type="radio" name="status_wallet" value="suspended" />
                                                            <span class="form-check-label text-gray-600">Suspendue</span>
                                                        </label>
                                                        <!--end::Option-->

                                                        <!--begin::Option-->
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                            <input class="form-check-input" type="radio" name="status_wallet" value="closed" />
                                                            <span class="form-check-label text-gray-600">Clotûrer</span>
                                                        </label>
                                                        <!--end::Option-->
                                                    </div>
                                                    <!--end::Options-->
                                                </div>
                                                <!--begin::Actions-->
                                                <div class="d-flex justify-content-end">
                                                    <button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset">Réinitialiser</button>
                                                    <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-customer-table-filter="filter">Appliquer</button>
                                                </div>
                                                <!--end::Actions-->
                                            </div>
                                            <!--end::Content-->
                                        </div>
                                        <!--end::Menu 1-->
                                        <!--end::Filter-->
                                        <!--begin::Add customer-->
                                        <a id="btnCreateWallet" class="btn btn-bank" data-customer="{{ $customer->id }}"><i class="fa-solid fa-plus me-2"></i> Nouveau compte</a>
                                        <!--end::Add customer-->
                                    </div>
                                    <!--end::Toolbar-->
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="liste_wallet">
                                    <!--begin::Table head-->
                                    <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-125px">Compte</th>
                                        <th class="min-w-125px">Type de compte</th>
                                        <th class="min-w-125px">Etat du compte</th>
                                        <th class="min-w-125px">Balance</th>
                                        <th class="text-end min-w-70px">Actions</th>
                                    </tr>
                                    <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                    @foreach($customer->wallets as $wallet)
                                        <tr>
                                            <!--begin::Name=-->
                                            <td>
                                                {{ $wallet->number_account }}
                                            </td>
                                            <!--end::Name=-->
                                            <!--begin::Email=-->
                                            <td data-filter="{{ $wallet->type }}">
                                                {!! \App\Helper\CustomerWalletHelper::getTypeWallet($wallet->type, true) !!}
                                            </td>

                                            <td data-filter="{{ $wallet->status }}">
                                                {!! \App\Helper\CustomerWalletHelper::getStatusWallet($wallet->status, true) !!}
                                            </td>

                                            <td>
                                                <strong>Balance Actuel:</strong> {{ eur($wallet->balance_actual) }}<br>
                                                @if($wallet->balance_coming != 0)
                                                    <strong class="text-muted">A venir:</strong> {{ eur($wallet->balance_coming) }}<br>
                                                @endif
                                            </td>
                                            <!--end::Email=-->
                                            <!--begin::Action=-->
                                            <td class="text-end">
                                                <a href="{{ route('agent.customer.wallet.show', [$customer->id, $wallet->id]) }}" class="btn btn-sm btn-circle btn-icon btn-bank" data-bs-toggle="tooltip" data-bs-placement="left" title="Détail"><i class="fa fa-desktop"></i> </a>
                                            </td>
                                            <!--end::Action=-->
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
    <div class="modal fade" tabindex="-1" id="updateStatus">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Mise à jour du status du compte client</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <i class="fas fa-times fa-2x text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formUpdateStatus" action="{{ route('agent.customer.updateStatus', $customer->id) }}"
                      method="post">
                    @csrf
                    @method("put")
                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="status_open_account" class="form-label">Etat du compte</label>
                            <select id="status_open_account" name="status_open_account" class="form-control"
                                    data-control="select2">
                                <option value="open" @if($customer->status_open_account == 'open') selected @endif>
                                    Ouverture en cours
                                </option>
                                <option value="completed"
                                        @if($customer->status_open_account == 'completed') selected @endif>Dossier
                                    Complet
                                </option>
                                <option value="accepted"
                                        @if($customer->status_open_account == 'accepted') selected @endif>Dossier
                                    Accepter
                                </option>
                                <option value="declined"
                                        @if($customer->status_open_account == 'declined') selected @endif>Dossier
                                    Refuser
                                </option>
                                <option value="terminated"
                                        @if($customer->status_open_account == 'terminated') selected @endif>Compte actif
                                </option>
                                <option value="suspended"
                                        @if($customer->status_open_account == 'suspended') selected @endif>Compte
                                    suspendue
                                </option>
                                <option value="closed" @if($customer->status_open_account == 'closed') selected @endif>
                                    Compte clotûrer
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <x-form.button/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="updateAccount">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Changement de type de compte</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <i class="fas fa-times fa-2x text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formUpdateAccount" action="{{ route('agent.customer.updateTypeAccount', $customer->id) }}"
                      method="post">
                    @csrf
                    @method("put")
                    <div class="modal-body">
                        <div class="mb-10">
                            <label for="package_id" class="form-label">Type de compte</label>
                            <select id="package_id" name="package_id" class="form-control" data-control="select2">
                                @foreach(\App\Models\Core\Package::all() as $package)
                                    <option value="{{ $package->id }}"
                                            @if($customer->package_id == $package->id) selected @endif>{{ $package->name }}
                                        ({{ eur($package->price) }} / par mois)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <x-form.button/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="write-sms">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Ecrire un sms</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <i class="fas fa-times fa-2x text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formWriteSms" action="{{ route('agent.customer.writeSms', $customer->id) }}"
                      method="post">
                    @csrf
                    <div class="modal-body">
                        <x-form.textarea name="message" label="Message" required="true" />
                    </div>

                    <div class="modal-footer">
                        <x-form.button/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="write-mail">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Ecrire un Email</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <i class="fas fa-times fa-2x text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formWriteMail" action="{{ route('agent.customer.writeMail', $customer->id) }}"
                      method="post">
                    @csrf
                    <div class="modal-body">
                        <x-form.textarea name="message" label="Message" required="true" />
                    </div>

                    <div class="modal-footer">
                        <x-form.button/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="createWallet">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-bank">
                    <h5 class="modal-title text-white">Nouveau compte bancaire</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <i class="fas fa-times fa-2x text-white"></i>
                    </div>
                    <!--end::Close-->
                </div>

                <form id="formCreateWallet" action="{{ route('agent.customer.wallet.store', $customer->id) }}"
                      method="post">
                    @csrf
                    <div class="modal-body">
                        <x-base.underline
                            title="Choix de la carte bancaire" sizeText="fs-2" size="1"/>
                        <div class="mb-10">
                            <label for="card_support" class="required form-label">
                                Type de carte bancaire
                            </label>
                            <select id="card_support" class="form-select form-select-solid" data-placeholder="Selectionner un type de carte" name="card_support" required>
                                <option value=""></option>
                                <option value="classic" data-card-img="/storage/card/classic.png">Visa Classic</option>
                                <option value="premium" data-card-img="/storage/card/premium.png">Visa Gold</option>
                                <option value="infinite" data-card-img="/storage/card/infinite.png">Visa Infinity</option>
                            </select>
                        </div>
                        <div class="mb-10">
                            <label for="card_debit" class="required form-label">
                                Type de débit
                            </label>
                            <select id="card_debit" class="form-select form-select-solid" data-control="select2" data-placeholder="Selectionner un type de débit" name="card_debit" required>
                                <option value=""></option>
                                <option value="immediate">Débit immédiat</option>
                                <option value="differed">Débit Différé</option>
                            </select>
                        </div>
                        <x-base.underline
                            title="Découvert" sizeText="fs-2" size="1"/>
                        <div id="outstanding"></div>

                    </div>

                    <div class="modal-footer">
                        <x-form.button/>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section("script")
    @include("agent.scripts.customer.show")
@endsection
