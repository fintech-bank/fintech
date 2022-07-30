@extends("front.layouts.layout")

@section("css")

@endsection

@section("content")

    <div class="text-center mb-17">
        <!--begin::Title-->
        <h3 class="fs-2hx text-dark mb-5" id="how-it-works" data-kt-scroll-offset="{default: 100, lg: 150}">How it Works</h3>
        <!--end::Title-->
        <!--begin::Text-->
        <div class="fs-5 text-muted fw-bold">Save thousands to millions of bucks by using single tool
            <br />for different amazing and great useful admin</div>
        <!--end::Text-->
    </div>
    <!--end::Heading-->
    <!--begin::Row-->
    <div class="row w-100 gy-10 mb-md-20">
        <!--begin::Col-->
        <div class="col-md-4 px-5">
            <!--begin::Story-->
            <div class="text-center mb-10 mb-md-0">
                <!--begin::Illustration-->
                <img src="assets/media/illustrations/sketchy-1/2.png" class="mh-125px mb-9" alt="" />
                <!--end::Illustration-->
                <!--begin::Heading-->
                <div class="d-flex flex-center mb-5">
                    <!--begin::Badge-->
                    <span class="badge badge-circle badge-light-success fw-bold p-5 me-3 fs-3">1</span>
                    <!--end::Badge-->
                    <!--begin::Title-->
                    <div class="fs-5 fs-lg-3 fw-bold text-dark">Jane Miller</div>
                    <!--end::Title-->
                </div>
                <!--end::Heading-->
                <!--begin::Description-->
                <div class="fw-semibold fs-6 fs-lg-4 text-muted">Save thousands to millions of bucks
                    <br />by using single tool for different
                    <br />amazing and great</div>
                <!--end::Description-->
            </div>
            <!--end::Story-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-4 px-5">
            <!--begin::Story-->
            <div class="text-center mb-10 mb-md-0">
                <!--begin::Illustration-->
                <img src="assets/media/illustrations/sketchy-1/8.png" class="mh-125px mb-9" alt="" />
                <!--end::Illustration-->
                <!--begin::Heading-->
                <div class="d-flex flex-center mb-5">
                    <!--begin::Badge-->
                    <span class="badge badge-circle badge-light-success fw-bold p-5 me-3 fs-3">2</span>
                    <!--end::Badge-->
                    <!--begin::Title-->
                    <div class="fs-5 fs-lg-3 fw-bold text-dark">Setup Your App</div>
                    <!--end::Title-->
                </div>
                <!--end::Heading-->
                <!--begin::Description-->
                <div class="fw-semibold fs-6 fs-lg-4 text-muted">Save thousands to millions of bucks
                    <br />by using single tool for different
                    <br />amazing and great</div>
                <!--end::Description-->
            </div>
            <!--end::Story-->
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-md-4 px-5">
            <!--begin::Story-->
            <div class="text-center mb-10 mb-md-0">
                <!--begin::Illustration-->
                <img src="assets/media/illustrations/sketchy-1/12.png" class="mh-125px mb-9" alt="" />
                <!--end::Illustration-->
                <!--begin::Heading-->
                <div class="d-flex flex-center mb-5">
                    <!--begin::Badge-->
                    <span class="badge badge-circle badge-light-success fw-bold p-5 me-3 fs-3">3</span>
                    <!--end::Badge-->
                    <!--begin::Title-->
                    <div class="fs-5 fs-lg-3 fw-bold text-dark">Enjoy Nautica App</div>
                    <!--end::Title-->
                </div>
                <!--end::Heading-->
                <!--begin::Description-->
                <div class="fw-semibold fs-6 fs-lg-4 text-muted">Save thousands to millions of bucks
                    <br />by using single tool for different
                    <br />amazing and great</div>
                <!--end::Description-->
            </div>
            <!--end::Story-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
    <!--begin::Product slider-->
    <div class="tns tns-default">
        <!--begin::Slider-->
        <div data-tns="true" data-tns-loop="true" data-tns-swipe-angle="false" data-tns-speed="2000" data-tns-autoplay="true" data-tns-autoplay-timeout="18000" data-tns-controls="true" data-tns-nav="false" data-tns-items="1" data-tns-center="false" data-tns-dots="false" data-tns-prev-button="#kt_team_slider_prev1" data-tns-next-button="#kt_team_slider_next1">
            <!--begin::Item-->
            <div class="text-center px-5 pt-5 pt-lg-10 px-lg-10">
                <img src="assets/media/product-demos/demo1.png" class="card-rounded shadow mw-100" alt="" />
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="text-center px-5 pt-5 pt-lg-10 px-lg-10">
                <img src="assets/media/product-demos/demo2.png" class="card-rounded shadow mw-100" alt="" />
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="text-center px-5 pt-5 pt-lg-10 px-lg-10">
                <img src="assets/media/product-demos/demo4.png" class="card-rounded shadow mw-100" alt="" />
            </div>
            <!--end::Item-->
            <!--begin::Item-->
            <div class="text-center px-5 pt-5 pt-lg-10 px-lg-10">
                <img src="assets/media/product-demos/demo5.png" class="card-rounded shadow mw-100" alt="" />
            </div>
            <!--end::Item-->
        </div>
        <!--end::Slider-->
        <!--begin::Slider button-->
        <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_prev1">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr074.svg-->
            <span class="svg-icon svg-icon-3x">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M11.2657 11.4343L15.45 7.25C15.8642 6.83579 15.8642 6.16421 15.45 5.75C15.0358 5.33579 14.3642 5.33579 13.95 5.75L8.40712 11.2929C8.01659 11.6834 8.01659 12.3166 8.40712 12.7071L13.95 18.25C14.3642 18.6642 15.0358 18.6642 15.45 18.25C15.8642 17.8358 15.8642 17.1642 15.45 16.75L11.2657 12.5657C10.9533 12.2533 10.9533 11.7467 11.2657 11.4343Z" fill="currentColor" />
								</svg>
							</span>
            <!--end::Svg Icon-->
        </button>
        <!--end::Slider button-->
        <!--begin::Slider button-->
        <button class="btn btn-icon btn-active-color-primary" id="kt_team_slider_next1">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr071.svg-->
            <span class="svg-icon svg-icon-3x">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="currentColor" />
								</svg>
							</span>
            <!--end::Svg Icon-->
        </button>
        <!--end::Slider button-->
    </div>
    <!--end::Product slider-->
@endsection

@section("script")

@endsection
