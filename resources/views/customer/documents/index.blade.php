@extends("customer.layouts.app")

@section("css")

@endsection

@section('toolbar')
    <!--begin::Page title-->
    <div class="page-title d-flex justify-content-center flex-column me-5">
        <!--begin::Title-->
        <h1 class="d-flex flex-column text-dark fw-bolder fs-3 mb-0">Mes Documents</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 pt-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ route('customer.dashboard') }}" class="text-muted text-hover-primary">{{ \App\Helper\CustomerHelper::getName($customer) }}</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Mes Documents</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
@endsection

@section("content")
    <div class="row">
        <div class="col-3">
            <div class="card card-flush shadow-md">
                <div class="card-body py-5">
                    <div class="d-flex flex-column align-items-center">
                        <div class="menu menu-column menu-rounded menu-state-bg menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary mb-10" id="documentCat">
                            <!--begin::Menu item-->
                            @foreach(\App\Models\Core\DocumentCategory::all() as $category)
                            <div class="menu-item mb-3" data-category="{{ $category->id }}">
                                <!--begin::Inbox-->
                                <span class="menu-link">
									<span class="menu-icon">
										<!--begin::Svg Icon | path: icons/duotune/communication/com010.svg-->
										<span class="svg-icon svg-icon-2 me-3 svg-icon-{{ random_color() }}">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path d="M10.6851 1.15337C11.5103 0.811566 12.4375 0.811566 13.2627 1.15337L18.7139 3.41133C19.5391 3.75313 20.1947 4.40875 20.5365 5.23396L22.7945 10.6851C23.1363 11.5103 23.1363 12.4375 22.7945 13.2627L20.5365 18.7139C20.1947 19.5391 19.5391 20.1947 18.7139 20.5365L13.2627 22.7945C12.4375 23.1363 11.5103 23.1363 10.6851 22.7945L5.23396 20.5365C4.40875 20.1947 3.75314 19.5391 3.41133 18.7139L1.15337 13.2627C0.811566 12.4375 0.811566 11.5103 1.15337 10.6851L3.41133 5.23396C3.75313 4.40875 4.40875 3.75314 5.23396 3.41133L10.6851 1.15337Z" fill="white" stroke="#E4E6EF"/>
                                            </svg>
										</span>
                                        <!--end::Svg Icon-->
									</span>
									<span class="menu-title fw-bold">{{ $category->name }}</span>
									<span class="badge badge-light-dark">{{ $customer->documents()->where('document_category_id', $category->id)->count() }}</span>
								</span>
                                <!--end::Inbox-->
                            </div>
                            <!--end::Menu item-->
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-9" id="documents">

        </div>
    </div>
@endsection

@section("script")
    @include("customer.scripts.documents.index")
@endsection
