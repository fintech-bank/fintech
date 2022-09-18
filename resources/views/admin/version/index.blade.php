@extends("admin.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Version</h1>
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
            <li class="breadcrumb-item text-dark">Gestion des versions de l'application</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="card shadow-lg">
        <div class="card-header">
            <h3 class="card-title">Liste des version</h3>
            <div class="card-toolbar">
                <a href="{{ route('admin.version.create') }}" class="btn btn-bank"><i class="fa-solid fa-plus me-2 fw-bold"></i> Nouvelle version </a>
            </div>
        </div>
        <div class="card-body">
            <table id="liste_version" class="table table-row-bordered gy-5">
                <thead>
                <tr class="fw-bold fs-6 text-muted">
                    <th>Version</th>
                    <th>Types</th>
                    <th>Etat</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($versions as $version)
                <tr>
                    <td>{{ $version->name }}</td>
                    <td>
                        @foreach($version->types as $type)
                            <span class="badge text-white" style="background-color: {{ $type->color }}">{{ $type->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        @if($version->publish)
                            <span class="badge badge-success">Publier</span>
                        @else
                            <span class="badge badge-danger">Brouillon</span>
                        @endif
                    </td>
                    <td>
                        @if($version->publish)
                            <button class="btn btn-sm btn-danger unpublish" data-id="{{ $version->id }}">Dépublier </button>
                        @else
                            <button class="btn btn-sm btn-success publish" data-id="{{ $version->id }}">Publier </button>
                            <a class="btn btn-sm btn-primary edit" href="">Editer </a>
                            <a class="btn btn-sm btn-primary delete" href="">Supprimer </a>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section("script")
    @include('admin.scripts.version.index')
@endsection
