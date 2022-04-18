@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Plan des prêts</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">Administration</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Gestion des plans des prêts bancaires</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <div class="d-flex align-items-center position-relative my-1">
                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                <span class="svg-icon svg-icon-1 position-absolute ms-6">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
						<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"></rect>
						<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"></path>
					</svg>
				</span>
                <!--end::Svg Icon-->
                <input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Rechercher une banque">
            </div>
        </div>
        <div class="card-toolbar">
            <button class="btn btn-bank" data-bs-toggle="modal" data-bs-target="#add_plan"><i class="fa-solid fa-plus"></i> Nouveau Plan</button>
        </div>
    </div>
    <div class="card-body">
        <table id="liste_plan" class="table table-row-bordered gy-5">
            <thead>
            <tr class="fw-bold fs-6 text-muted">
                <th>Nom du plan</th>
                <th>Montant</th>
                <th>Durée</th>
                <th>Interet</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach(\App\Models\Core\LoanPlan::all() as $plan)
                <tr>
                    <td>
                        {{ $plan->name }}
                    </td>
                    <td>De {{ eur($plan->min) }} à {{ eur($plan->max) }}</td>
                    <td>{{ $plan->duration }} Mois ({{ $plan->duration / 12 }} ans)</td>
                    <td>
                        <ul>
                        @foreach($plan->interests as $interest)
                            <li>{{ $interest->interest }} % sur {{ $interest->duration }} Mois</li>
                        @endforeach
                        </ul>
                    </td>
                    <td>
                        <button class="btn btn-icon btn-circle btn-outline btn-outline-dashed btn-outline-primary rotate" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="-30px, 20px">
                            <i class="fa-solid fa-ellipsis rotate-90"></i>
                        </button>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px" data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <div class="menu-content fs-6 text-dark fw-bolder px-3 py-4">Actions</div>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu separator-->
                            <div class="separator mb-3 opacity-75"></div>
                            <!--end::Menu separator-->

                            <!--begin::Menu item-->
                            <div class="menu-item px-3 py-3">
                                <a href="#" class="menu-link px-3 text-danger delete" data-plan="{{ $plan->id }}">
                                    Supprimer
                                </a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="add_plan">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-bank">
                <h5 class="modal-title text-white">Nouveau Plan de pret</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark text-white"></i>
                </div>
                <!--end::Close-->
            </div>

            <form id="formAddPlan" action="{{ route('prets.store') }}" method="post" novalidate>
                <div class="modal-body">
                    <x-form.input
                        name="name"
                        type="text"
                        label="Nom du plan"
                        required="true" />

                    <div class="row">
                        <div class="col-4">
                            <x-form.input
                                name="min"
                                type="text"
                                label="Montant minimum"
                                required="true" />
                        </div>
                        <div class="col-4">
                            <x-form.input
                                name="max"
                                type="text"
                                label="Montant maximum"
                                required="true" />
                        </div>
                        <div class="col-4">
                            <x-form.input
                                name="duration"
                                type="text"
                                label="Durée Maximum"
                                required="true"
                                text="Durée en mois" />
                        </div>
                    </div>

                    <div id="repeat_form_interest">
                        <div class="form-group">
                            <div data-repeater-list="repeat_form_interest">
                                <div data-repeater-item>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label for="" class="form-label">Interet</label>
                                            <input type="text" name="interest[]" class="form-control" />
                                        </div>
                                        <div class="col-4">
                                            <label for="" class="form-label">Durée</label>
                                            <input type="text" name="duration[]" class="form-control" />
                                            <p class="text-muted">En Mois</p>
                                        </div>
                                        <div class="col-4">
                                            <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8">
                                                <i class="la la-trash-o"></i> Supprimer
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-5">
                            <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                                <i class="la la-plus"></i> Ajouter
                            </a>
                        </div>
                    </div>

                    <x-form.textarea
                        name="instruction"
                        label="Instruction" />

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
    <script src="/assets/plugins/custom/tinymce/tinymce.bundle.js"></script>
    <script src="/assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    @include("admin.scripts.prets.index")
@endsection
