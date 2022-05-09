@if(session()->has('error'))
    <div class="alert alert-dismissible bg-danger d-flex flex-column flex-sm-row w-100 p-5 mb-10">
        <!--begin::Icon-->
        <!--begin::Svg Icon | path: icons/duotune/communication/com003.svg-->
        <i class="fa fa-times-circle text-white fa-2x"></i>
        <!--end::Svg Icon-->
        <!--end::Icon-->
        <!--begin::Content-->
        <div class="d-flex flex-column text-light pe-0 pe-sm-10">
            <h4 class="mb-2 text-light">Erreur</h4>
            <span>{!! session()->get('error') !!}</span>
        </div>
        <!--end::Content-->
    </div>
@endif

@if(session()->has('info'))
    <div class="alert alert-dismissible bg-bank d-flex flex-column flex-sm-row w-100 p-5 mb-10">
        <!--begin::Icon-->
        <!--begin::Svg Icon | path: icons/duotune/communication/com003.svg-->
        <i class="fa fa-info-circle text-white fa-2x"></i>
        <!--end::Svg Icon-->
        <!--end::Icon-->
        <!--begin::Content-->
        <div class="d-flex flex-column text-light pe-0 pe-sm-10">
            <h4 class="mb-2 text-light">Information</h4>
            <span>{!! session()->get('info') !!}</span>
        </div>
        <!--end::Content-->
    </div>
@endif

@if(session()->has('warning'))
    <div class="alert alert-dismissible bg-warning d-flex flex-column flex-sm-row w-100 p-5 mb-10">
        <!--begin::Icon-->
        <!--begin::Svg Icon | path: icons/duotune/communication/com003.svg-->
        <i class="fa fa-exclamation-triangle text-white fa-2x"></i>
        <!--end::Svg Icon-->
        <!--end::Icon-->
        <!--begin::Content-->
        <div class="d-flex flex-column text-light pe-0 pe-sm-10">
            <h4 class="mb-2 text-light">Attention</h4>
            <span>{!! session()->get('warning') !!}</span>
        </div>
        <!--end::Content-->
    </div>
@endif

@if(session()->has('success'))
    <div class="alert alert-dismissible bg-success d-flex flex-column flex-sm-row w-100 p-5 mb-10">
        <!--begin::Icon-->
        <!--begin::Svg Icon | path: icons/duotune/communication/com003.svg-->
        <i class="fa fa-check-circle text-white fa-2x"></i>
        <!--end::Svg Icon-->
        <!--end::Icon-->
        <!--begin::Content-->
        <div class="d-flex flex-column text-light pe-0 pe-sm-10">
            <h4 class="mb-2 text-light">Succès</h4>
            <span>{!! session()->get('success') !!}</span>
        </div>
        <!--end::Content-->
    </div>
@endif


@if ($errors->any())
    <div class="alert alert-dismissible bg-danger d-flex flex-column flex-sm-row w-100 p-5 mb-10">
        <!--begin::Icon-->
        <!--begin::Svg Icon | path: icons/duotune/communication/com003.svg-->
        <i class="fa fa-times-circle text-white fa-2x"></i>
        <!--end::Svg Icon-->
        <!--end::Icon-->
        <!--begin::Content-->
        <div class="d-flex flex-column text-light pe-0 pe-sm-10">
            <h4 class="mb-2 text-light">Erreur</h4>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
        </div>
        <!--end::Content-->
    </div>
@endif
