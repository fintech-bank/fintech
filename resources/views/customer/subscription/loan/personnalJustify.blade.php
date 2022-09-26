@extends("customer.layouts.app")

@section("css")
    <link rel="stylesheet" href="/css/customer.css">
@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Prêt Personnel</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('customer.dashboard') }}"
                   class="text-muted text-hover-primary">{{ \App\Helper\CustomerHelper::getName($customer) }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Souscription du pret personnel</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->

    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="mb-10">
        <ol id="progress-bar">
            <li class="step-done">Simulation</li>
            <li class="step-done">Vérification</li>
            <li class="step-done">Réponse</li>
            <li class="step-active">Envoie des justificatifs</li>
            <li class="step-todo">Signatures</li>
            <li class="step-todo">Terminer</li>
        </ol>
    </div>
   <div class="card shadow-sm">
       <div class="card-header bg-bank">
           <h3 class="card-title text-white">Envoie de vos justificatifs</h3>
       </div>
       <form id="id" action="{{ route('customer.subscription.personnal') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="loan_id" value="{{ $loan->id }}">
            <input type="hidden" name="customer_id" value="{{ $customer->id }}">
            <input type="hidden" name="action" value="signate">
           <div class="card-body">
                <x-base.underline title="Pièces d'identité" class="w-100 mb-5" />

                <div class="d-flex flex-row justify-content-center mb-10">
                    <div class="me-5">
                        <div class="fw-bolder mb-3">Recto</div>
                        <!--begin::Image input-->
                        <div class="image-input image-input-empty" id="justify_cni_recto" data-kt-image-input="true" style="background-image: url(/storage/other/id-card-solid.svg)">
                            <!--begin::Image preview wrapper-->
                            <div class="image-input-wrapper w-300px h-250px"></div>
                            <!--end::Image preview wrapper-->

                            <!--begin::Edit button-->
                            <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="change"
                            data-bs-toggle="tooltip"
                            data-bs-dismiss="click"
                            title="Change avatar">
                                <i class="bi bi-pencil-fill fs-7"></i>

                                <!--begin::Inputs-->
                                <input type="file" name="justify_cni_recto" accept=".png, .jpg, .jpeg, .pdf" required />
                                <input type="hidden" name="justify_cni_recto_remove" />
                                <!--end::Inputs-->
                            </label>
                            <!--end::Edit button-->

                            <!--begin::Cancel button-->
                            <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="cancel"
                            data-bs-toggle="tooltip"
                            data-bs-dismiss="click"
                            title="Annuler">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Cancel button-->

                            <!--begin::Remove button-->
                            <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="remove"
                            data-bs-toggle="tooltip"
                            data-bs-dismiss="click"
                            title="Supprimer">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Remove button-->
                        </div>
                        <!--end::Image input-->
                    </div>
                    <div class="">
                        <div class="fw-bolder mb-3">Verso</div>
                        <!--begin::Image input-->
                        <div class="image-input image-input-empty" id="justify_cni_verso" data-kt-image-input="true" style="background-image: url(/storage/other/id-card-solid.svg)">
                            <!--begin::Image preview wrapper-->
                            <div class="image-input-wrapper w-300px h-250px"></div>
                            <!--end::Image preview wrapper-->

                            <!--begin::Edit button-->
                            <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="change"
                            data-bs-toggle="tooltip"
                            data-bs-dismiss="click"
                            title="Change avatar">
                                <i class="bi bi-pencil-fill fs-7"></i>

                                <!--begin::Inputs-->
                                <input type="file" name="justify_cni_verso" accept=".png, .jpg, .jpeg, .pdf" required/>
                                <input type="hidden" name="justify_cni_verso_remove" />
                                <!--end::Inputs-->
                            </label>
                            <!--end::Edit button-->

                            <!--begin::Cancel button-->
                            <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="cancel"
                            data-bs-toggle="tooltip"
                            data-bs-dismiss="click"
                            title="Annuler">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Cancel button-->

                            <!--begin::Remove button-->
                            <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="remove"
                            data-bs-toggle="tooltip"
                            data-bs-dismiss="click"
                            title="Supprimer">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Remove button-->
                        </div>
                        <!--end::Image input-->
                    </div>
                </div>

                <x-base.underline title="Justificatif de revenue" class="w-100 mb-5" />

                <div class="d-flex flex-row justify-content-center mb-10">
                    <div class="me-5">
                        <div class="fw-bolder mb-3">Justificatif {{ now()->subMonths(2)->locale('fr')->monthName }}</div>
                        <!--begin::Image input-->
                        <div class="image-input image-input-empty" id="justify_revenue_one" data-kt-image-input="true" style="background-image: url(/storage/other/file-invoice-solid.svg)">
                            <!--begin::Image preview wrapper-->
                            <div class="image-input-wrapper w-300px h-250px"></div>
                            <!--end::Image preview wrapper-->

                            <!--begin::Edit button-->
                            <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="change"
                            data-bs-toggle="tooltip"
                            data-bs-dismiss="click"
                            title="Change avatar">
                                <i class="bi bi-pencil-fill fs-7"></i>

                                <!--begin::Inputs-->
                                <input type="file" name="justify_revenue_one" accept=".png, .jpg, .jpeg, .pdf" required />
                                <input type="hidden" name="justify_revenue_one_remove" />
                                <!--end::Inputs-->
                            </label>
                            <!--end::Edit button-->

                            <!--begin::Cancel button-->
                            <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="cancel"
                            data-bs-toggle="tooltip"
                            data-bs-dismiss="click"
                            title="Annuler">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Cancel button-->

                            <!--begin::Remove button-->
                            <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="remove"
                            data-bs-toggle="tooltip"
                            data-bs-dismiss="click"
                            title="Supprimer">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Remove button-->
                        </div>
                        <!--end::Image input-->
                    </div>
                    <div class="">
                        <div class="fw-bolder mb-3">Justificatif {{ now()->subMonths(1)->locale('fr')->monthName }}</div>
                        <!--begin::Image input-->
                        <div class="image-input image-input-empty" id="justify_revenue_two" data-kt-image-input="true" style="background-image: url(/storage/other/file-invoice-solid.svg)">
                            <!--begin::Image preview wrapper-->
                            <div class="image-input-wrapper w-300px h-250px"></div>
                            <!--end::Image preview wrapper-->

                            <!--begin::Edit button-->
                            <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="change"
                            data-bs-toggle="tooltip"
                            data-bs-dismiss="click"
                            title="Change avatar">
                                <i class="bi bi-pencil-fill fs-7"></i>

                                <!--begin::Inputs-->
                                <input type="file" name="justify_revenue_two" accept=".png, .jpg, .jpeg, .pdf" required />
                                <input type="hidden" name="justify_revenue_two_remove" />
                                <!--end::Inputs-->
                            </label>
                            <!--end::Edit button-->

                            <!--begin::Cancel button-->
                            <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="cancel"
                            data-bs-toggle="tooltip"
                            data-bs-dismiss="click"
                            title="Annuler">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Cancel button-->

                            <!--begin::Remove button-->
                            <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="remove"
                            data-bs-toggle="tooltip"
                            data-bs-dismiss="click"
                            title="Supprimer">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Remove button-->
                        </div>
                        <!--end::Image input-->
                    </div>
                </div>

                <x-base.underline title="Justificatif de domicile" class="w-100 mb-5" />

                <div class="d-flex flex-row justify-content-center mb-10">
                    <div class="me-5">
                        <div class="fw-bolder mb-3">Facture portant votre nom & adresse postal</div>
                        <!--begin::Image input-->
                        <div class="image-input image-input-empty" id="justify_domicile" data-kt-image-input="true" style="background-image: url(/storage/other/id-card-solid.svg)">
                            <!--begin::Image preview wrapper-->
                            <div class="image-input-wrapper w-300px h-250px"></div>
                            <!--end::Image preview wrapper-->

                            <!--begin::Edit button-->
                            <label class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="change"
                            data-bs-toggle="tooltip"
                            data-bs-dismiss="click"
                            title="Change avatar">
                                <i class="bi bi-pencil-fill fs-7"></i>

                                <!--begin::Inputs-->
                                <input type="file" name="justify_domicile" accept=".png, .jpg, .jpeg, .pdf" required />
                                <input type="hidden" name="justify_domicile_remove" />
                                <!--end::Inputs-->
                            </label>
                            <!--end::Edit button-->

                            <!--begin::Cancel button-->
                            <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="cancel"
                            data-bs-toggle="tooltip"
                            data-bs-dismiss="click"
                            title="Annuler">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Cancel button-->

                            <!--begin::Remove button-->
                            <span class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                            data-kt-image-input-action="remove"
                            data-bs-toggle="tooltip"
                            data-bs-dismiss="click"
                            title="Supprimer">
                                <i class="bi bi-x fs-2"></i>
                            </span>
                            <!--end::Remove button-->
                        </div>
                        <!--end::Image input-->
                    </div>
                </div>
           </div>
           <div class="card-footer">
               <x-form.button />
           </div>
       </form>
   </div>
@endsection

@section("script")
    @include("customer.scripts.subscription.loan.personnalSubscribe")
@endsection
