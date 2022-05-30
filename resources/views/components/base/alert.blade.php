@if($type == 'basic')
    <!--begin::Alert-->
    <div class="alert alert-{{ $color }}">
        <!--begin::Icon-->
        <i class="fa-solid fa-{{ $icon }} fa-2x text-{{ $color }} me-3"></i>
        <!--end::Icon-->

        <!--begin::Wrapper-->
        <div class="d-flex flex-column">
            <!--begin::Title-->
            <h4 class="mb-1 text-dark">{{ $title }}</h4>
            <!--end::Title-->
            <!--begin::Content-->
            <span>{{ $content }}</span>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Alert-->
@elseif($type == 'solid')

    <!--begin::Alert-->
    <div class="alert alert-dismissible bg-{{ $color }} d-flex flex-column flex-sm-row p-5 mb-10">
        <!--begin::Icon-->
        <i class="fa-solid fa-{{ $icon }} fa-2x text-{{ $color }} me-3"></i>
        <!--end::Icon-->

        <!--begin::Wrapper-->
        <div class="d-flex flex-column text-light pe-0 pe-sm-10">
            <!--begin::Title-->
            <h4 class="mb-2 light">{{ $title }}</h4>
            <!--end::Title-->

            <!--begin::Content-->
            <span>{{ $content }}</span>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->

        <!--begin::Close-->
        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="fa-solid fa-times fa-2x text-light"></i>
        </button>
        <!--end::Close-->
    </div>
    <!--end::Alert-->

@elseif($type == 'light')
    <!--begin::Alert-->
    <div class="alert alert-dismissible bg-light-{{ $color }} d-flex flex-column flex-sm-row p-5 mb-10">
        <!--begin::Icon-->
        <i class="fa-solid fa-{{ $icon }} fa-2x text-{{ $color }} me-3"></i>
        <!--end::Icon-->

        <!--begin::Wrapper-->
        <div class="d-flex flex-column text-light pe-0 pe-sm-10">
            <!--begin::Title-->
            <h4 class="mb-2 light">{{ $title }}</h4>
            <!--end::Title-->

            <!--begin::Content-->
            <span class="text-muted">{{ $content }}</span>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->

        <!--begin::Close-->
        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="fa-solid fa-times fa-2x text-light"></i>
        </button>
        <!--end::Close-->
    </div>
    <!--end::Alert-->
@else
    <!--begin::Alert-->
    <div class="alert alert-dismissible bg-{{ $color }} d-flex flex-center flex-column py-10 px-10 px-lg-20 mb-10">
        <!--begin::Close-->
        <button type="button" class="position-absolute top-0 end-0 m-2 btn btn-icon btn-icon-{{ $color }}" data-bs-dismiss="alert">
            <i class="fa-solid fa-times fa-lg"></i>
        </button>
        <!--end::Close-->

        <!--begin::Icon-->
        <i class="fa-solid fa-{{ $icon }} fa-5x text-{{ $color }} mb-5"></i>
        <!--end::Icon-->

        <!--begin::Wrapper-->
        <div class="text-center">
            <!--begin::Title-->
            <h1 class="fw-bolder mb-5">{{ $title }}</h1>
            <!--end::Title-->

            <!--begin::Separator-->
            <div class="separator separator-dashed border-danger opacity-25 mb-5"></div>
            <!--end::Separator-->

            <!--begin::Content-->
            <div class="mb-9 text-dark">
                {!! $content !!}
            </div>
            <!--end::Content-->

            <!--begin::Buttons-->
            @isset($buttons)
            <div class="d-flex flex-center flex-wrap">
                @foreach($buttons as $button)
                    {{ $button }}
                @endforeach
            </div>
            @endisset
            <!--end::Buttons-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Alert-->
@endif
