@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Gestion des Catégories</h1>
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
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">CMS</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Gestion des catégories</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Liste des catégories</h3>
        <div class="card-toolbar">
            <a href="#add_category" class="btn btn-bank" data-bs-toggle="modal"><i class="fa-solid fa-plus me-2"></i> Nouvelle catégorie</a>
        </div>
    </div>
    <div class="card-body">
        <table class="table align-middle table-row-dashed fs-6 gy-4" id="liste_categories">
            <thead>
                <tr>
                    <th>Désignation</th>
                    <th class="text-end"></th>
                </tr>
            </thead>
            <tbody class="fw-bolder text-gray-600">
                @foreach(\App\Models\Cms\CmsCategory::all() as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
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

                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3 sub" data-category="{{ $category->id }}">
                                        Sous-catégorie
                                    </a>
                                </div>

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3 edit" data-category="{{ $category->id }}">
                                        Editer
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3 py-3">
                                    <a href="#" class="menu-link px-3 text-danger delete" data-category="{{ $category->id }}">
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
<div class="modal bg-white fade" tabindex="-1" id="show_subcategory">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content shadow-none">
            <div class="modal-header bg-bank">
                <h5 class="modal-title text-white">Sous Catégorie</h5>

                <!--begin::Close-->
                <button class="btn btn-outline btn-outline-bank" data-bs-toggle="modal" data-bs-target="#add_subcategory"><i class="fa-solid fa-plus-circle me-2"></i> Nouvelle sous catégorie</button>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <table class="table align-middle table-row-dashed fs-6 gy-4">
                    <thead>
                        <tr>
                            <th>Désignation</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="table_subcategory">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="add_category">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-bank">
                <h5 class="modal-title text-white">Nouvelle Catégorie</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark text-white"></i>
                </div>
                <!--end::Close-->
            </div>

            <form id="formAddCategory" action="{{ route('category.store') }}" method="post" novalidate>
                <div class="modal-body">
                    <x-form.input
                        name="name"
                        type="text"
                        label="Nom de la catégorie"
                        required="true" />

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
    @include('admin.scripts.cms.category.index')
@endsection
