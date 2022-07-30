@extends("front.layouts.layout")

@section("css")

@endsection

@section("content")
    <div class="mb-n10 mb-lg-n20 z-index-2">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Stepper-->
            <div class="stepper stepper-pills" id="kt_stepper_example_basic">
                <!--begin::Nav-->
                <div class="stepper-nav flex-center flex-wrap mb-10">
                    <!--begin::Step 1-->
                    <div class="stepper-item mx-8 my-4 completed" data-kt-stepper-element="nav">
                        <!--begin::Wrapper-->
                        <div class="stepper-wrapper d-flex align-items-center">
                            <!--begin::Icon-->
                            <div class="stepper-icon w-40px h-40px">
                                <i class="stepper-check fas fa-check"></i>
                                <span class="stepper-number">1</span>
                            </div>
                            <!--end::Icon-->

                            <!--begin::Label-->
                            <div class="stepper-label">
                                <h3 class="stepper-title">
                                    Choix de l'offre
                                </h3>
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Line-->
                        <div class="stepper-line h-40px"></div>
                        <!--end::Line-->
                    </div>
                    <!--end::Step 1-->

                    <!--begin::Step 2-->
                    <div class="stepper-item mx-8 my-4 completed" data-kt-stepper-element="nav">
                        <!--begin::Wrapper-->
                        <div class="stepper-wrapper d-flex align-items-center">
                            <!--begin::Icon-->
                            <div class="stepper-icon w-40px h-40px">
                                <i class="stepper-check fas fa-check"></i>
                                <span class="stepper-number">2</span>
                            </div>
                            <!--begin::Icon-->

                            <!--begin::Label-->
                            <div class="stepper-label">
                                <h3 class="stepper-title">
                                    Information Personnel
                                </h3>
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Line-->
                        <div class="stepper-line h-40px"></div>
                        <!--end::Line-->
                    </div>
                    <!--end::Step 2-->

                    <!--begin::Step 3-->
                    <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
                        <!--begin::Wrapper-->
                        <div class="stepper-wrapper d-flex align-items-center">
                            <!--begin::Icon-->
                            <div class="stepper-icon w-40px h-40px">
                                <i class="stepper-check fas fa-check"></i>
                                <span class="stepper-number">3</span>
                            </div>
                            <!--begin::Icon-->

                            <!--begin::Label-->
                            <div class="stepper-label">
                                <h3 class="stepper-title">
                                    Signature du contrat
                                </h3>
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Line-->
                        <div class="stepper-line h-40px"></div>
                        <!--end::Line-->
                    </div>
                    <!--end::Step 3-->

                    <!--begin::Step 4-->
                    <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                        <!--begin::Wrapper-->
                        <div class="stepper-wrapper d-flex align-items-center">
                            <!--begin::Icon-->
                            <div class="stepper-icon w-40px h-40px">
                                <i class="stepper-check fas fa-check"></i>
                                <span class="stepper-number">4</span>
                            </div>
                            <!--begin::Icon-->

                            <!--begin::Label-->
                            <div class="stepper-label">
                                <h3 class="stepper-title">
                                    Vérification d'identité
                                </h3>
                            </div>
                            <!--end::Label-->
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Line-->
                        <div class="stepper-line h-40px"></div>
                        <!--end::Line-->
                    </div>
                    <!--end::Step 4-->
                </div>
                <!--end::Nav-->
            </div>
            <!--end::Stepper-->
            <form action="{{ route('register.identity-init', ["user" => $user]) }}" method="get" class="w-100 mx-auto">
                @csrf
                <x-base.underline title="Signature éléctronique de vos contrats" size="3" sizeText="fs-1" color="bank" class="w-100 mb-10"/>

                <table class="table border gy-7 gx-7">
                    <tbody>
                        @foreach($documents as $document)
                        <tr>
                            <td><a href="/storage/gdd/{{ $document->customer->id }}/3/{{ $document->name }}.pdf" target="_blank">{{ $document->name }}</a></td>
                            <td>
                                @if($document->signed_by_client == 0)
                                    <button type="button" class="btn btn-outline btn-sm btn-outline-danger btn-icon signate" data-bs-toggle="tooltip" title="Signez le document" data-doc="{{ $document->id }}"><i class="fa-solid fa-signature"></i> </button>
                                @else
                                    <span class="fw-bolder text-success">Document Signé le {{ $document->signed_at->format('d/m/Y à H:i') }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="separator border-primary my-5"></div>

                <div class="mb-10">
                    <div class="d-flex flex-row justify-content-between">
                        <a href="{{ route('register.perso-pro') }}"
                           class="btn btn-lg btn-outline btn-outline-bank btn-disabled" disabled="true">Précédent</a>
                        <button type="submit" class="btn btn-lg btn-bank ">Suivant</button>
                    </div>
                </div>
            </form>

        </div>
        <!--end::Container-->
    </div>
    <!--begin::Heading-->
@endsection

@section("script")
    <script type="text/javascript">
        document.querySelectorAll(".signate").forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault()
                console.log(e.target)
                Swal.fire({
                    title: 'Tapez votre code SECURPASS',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Valider',
                    showLoaderOnConfirm: true,
                    preConfirm: (code) => {
                        $.ajax({
                            url: '/api/customer/verifSecure/'+code,
                            method: 'POST',
                            data: {'customer_id': {{ $user->customers->id }}},
                            success: data => {
                                console.log(data)
                                $.ajax({
                                    url: '{{ route('register.signate') }}',
                                    method: 'POST',
                                    data: {'user': {{$user->id}}, 'document': e.target.dataset.doc},
                                    success: data => {
                                        toastr.success(`Le document à été signé`, null, {
                                            "positionClass": "toastr-bottom-right",
                                        })

                                        setTimeout(() => {
                                            window.location.reload()
                                        }, 1000)
                                    },
                                    error: err => {
                                        const errors = err.responseJSON.errors

                                        Object.keys(errors).forEach(key => {
                                            toastr.error(errors[key][0], "Champs: "+key, {
                                                "positionClass": "toastr-bottom-right",
                                            })
                                        })
                                    }
                                })
                            },
                            error: err => {
                                const errors = err.responseJSON.errors

                                Object.keys(errors).forEach(key => {
                                    toastr.error(errors[key], null, {
                                        "positionClass": "toastr-bottom-right",
                                    })
                                })
                            }
                        })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    console.log(result)
                })
            })
        })
    </script>
@endsection
