@extends("front.layouts.layout")

@section("css")

@endsection

@section("content")
    <div class="mb-n10 mb-lg-n20 z-index-2">
        <!--begin::Container-->
        <div class="container">
            <div class="d-flex flex-row mb-10">
                <div class="d-flex flex-column">
                    @if($user->customers->status_open_account == 'open')
                        <div class="d-flex align-items-center p-5 rounded mb-7 w-75 bg-gray-300">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label fs-2 bg-light-success">1</span>
                                <span class="symbol-badge badge badge-circle bg-success top-100 start-100"><i class="fa-solid fa-check text-white"></i></span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Text-->
                            <div class="d-flex flex-column">
                                <a href="#" class="text-dark text-hover-primary fs-6 fw-bold">Ouverture de votre compte</a>
                                <span class="text-muted fw-bold">Votre demande initial d'ouverture de compte à été transmis</span>
                            </div>
                            <!--end::Text-->
                        </div>
                        <div class="d-flex align-items-center mb-7 w-75">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label fs-2 bg-light-danger">2</span>
                                <span class="symbol-badge badge badge-circle bg-danger top-100 start-100"><i class="fa-solid fa-xmark text-white"></i></span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Text-->
                            <div class="d-flex flex-column">
                                <a href="#" class="text-dark text-hover-primary fs-6 fw-bold">Dossier complet</a>
                                <span class="text-muted fw-bold">Votre compte à été approvisionner par votre compte principal</span>
                            </div>
                            <!--end::Text-->
                        </div>
                        <div class="d-flex align-items-center mb-7 w-75">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label fs-2 bg-light-danger">3</span>
                                <span class="symbol-badge badge badge-circle bg-danger top-100 start-100"><i class="fa-solid fa-xmark text-white"></i></span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Text-->
                            <div class="d-flex flex-column">
                                <a href="#" class="text-dark text-hover-primary fs-6 fw-bold">Ouverture de compte terminé</a>
                                <span class="text-muted fw-bold">Votre demande à été accepté par notre équipe financier</span>
                            </div>
                            <!--end::Text-->
                        </div>
                    @endif
                    @if($user->customers->status_open_account == 'completed')
                        <div class="d-flex align-items-center p-5 rounded mb-7 w-75">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label fs-2 bg-light-success">1</span>
                                <span class="symbol-badge badge badge-circle bg-success top-100 start-100"><i class="fa-solid fa-check text-white"></i></span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Text-->
                            <div class="d-flex flex-column">
                                <a href="#" class="text-dark text-hover-primary fs-6 fw-bold">Ouverture de votre compte</a>
                                <span class="text-muted fw-bold">Votre demande initial d'ouverture de compte à été transmis</span>
                            </div>
                            <!--end::Text-->
                        </div>
                        <div class="d-flex align-items-center p-5 rounded mb-7 w-75 bg-gray-300">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label fs-2 bg-light-success">2</span>
                                <span class="symbol-badge badge badge-circle bg-success top-100 start-100"><i class="fa-solid fa-check text-white"></i></span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Text-->
                            <div class="d-flex flex-column">
                                <a href="#" class="text-dark text-hover-primary fs-6 fw-bold">Dossier complet</a>
                                <span class="text-muted fw-bold">Votre compte à été approvisionner par votre compte principal</span>
                            </div>
                            <!--end::Text-->
                        </div>
                        <div class="d-flex align-items-center p-5 rounded mb-7 w-75">
                            <!--begin::Symbol-->
                            <div class="symbol symbol-50px me-5">
                                <span class="symbol-label fs-2 bg-light-danger">3</span>
                                <span class="symbol-badge badge badge-circle bg-danger top-100 start-100"><i class="fa-solid fa-xmark text-white"></i></span>
                            </div>
                            <!--end::Symbol-->
                            <!--begin::Text-->
                            <div class="d-flex flex-column">
                                <a href="#" class="text-dark text-hover-primary fs-6 fw-bold">Ouverture de compte terminé</a>
                                <span class="text-muted fw-bold">Votre demande à été accepté par notre équipe financier</span>
                            </div>
                            <!--end::Text-->
                        </div>
                    @endif
                        @if($user->customers->status_open_account == 'accepted')
                            <div class="d-flex align-items-center p-5 rounded mb-7 w-75">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-50px me-5">
                                    <span class="symbol-label fs-2 bg-light-success">1</span>
                                    <span class="symbol-badge badge badge-circle bg-success top-100 start-100"><i class="fa-solid fa-check text-white"></i></span>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Text-->
                                <div class="d-flex flex-column">
                                    <a href="#" class="text-dark text-hover-primary fs-6 fw-bold">Ouverture de votre compte</a>
                                    <span class="text-muted fw-bold">Votre demande initial d'ouverture de compte à été transmis</span>
                                </div>
                                <!--end::Text-->
                            </div>
                            <div class="d-flex align-items-center p-5 rounded mb-7 w-75">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-50px me-5">
                                    <span class="symbol-label fs-2 bg-light-success">2</span>
                                    <span class="symbol-badge badge badge-circle bg-success top-100 start-100"><i class="fa-solid fa-check text-white"></i></span>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Text-->
                                <div class="d-flex flex-column">
                                    <a href="#" class="text-dark text-hover-primary fs-6 fw-bold">Dossier complet</a>
                                    <span class="text-muted fw-bold">Votre compte à été approvisionner par votre compte principal</span>
                                </div>
                                <!--end::Text-->
                            </div>
                            <div class="d-flex align-items-center p-5 rounded mb-7 w-75 bg-gray-300">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-50px me-5">
                                    <span class="symbol-label fs-2 bg-light-success">3</span>
                                    <span class="symbol-badge badge badge-circle bg-success top-100 start-100"><i class="fa-solid fa-check text-white"></i></span>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Text-->
                                <div class="d-flex flex-column">
                                    <a href="#" class="text-dark text-hover-primary fs-6 fw-bold">Ouverture de compte terminé</a>
                                    <span class="text-muted fw-bold">Votre demande à été accepté ou refusé par notre équipe financier</span>
                                </div>
                                <!--end::Text-->
                            </div>
                        @endif
                </div>
                @if($user->customers->status_open_account == 'open')
                <div class="card card-flush shadow-lg w-100">
                    <div class="card-header bg-bank">
                        <h3 class="card-title text-white">Ouverture de compte terminer</h3>
                    </div>
                    <div class="card-body py-5">
                        <div class="fw-bolder fs-2">Votre dossier à été accepter.</div>
                        <p>L'ouverture de votre compte à été effectuer, afin de terminer son ouverture, veuillez approvisionner votre compte du montant de <strong>20,00 €</strong>.</p>
                        <form id="payment-form">
                            <div id="payment-element" class="mb-10">
                                <!--Stripe.js injects the Payment Element-->
                            </div>
                            <div class="d-flex flex-wrap">
                                <x-form.button text="Approvisionner mon compte" id="submit" class="w-100 btn-bank"/>
                                <div id="payment-message" class="hidden"></div>
                                <div id="payment-error" class="text-danger hidden"></div>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
                @if($user->customers->status_open_account == 'completed')
                <div class="card card-flush shadow-lg w-100">
                    <div class="card-header bg-bank">
                        <h3 class="card-title text-white">Dossier complet</h3>
                    </div>
                    <div class="card-body py-5">
                        <div class="fw-bolder fs-2">Votre dossier est à présent complet</div>
                        <p>Le montant de 20,00 € à été crédité sur votre nouveau compte bancaire {{ config('app.name') }}.<br>Un conseiller {{ config('app.name') }} va étudier votre dossier et vous serez alerté de l'avancement de l'ouverture de votre compte (24h - 48h).</p>
                    </div>
                </div>
                @endif
                @if($user->customers->status_open_account == 'accepted')
                <div class="card card-flush shadow-lg w-100">
                    <div class="card-header bg-bank">
                        <h3 class="card-title text-white">Dossier accepter</h3>
                    </div>
                    <div class="card-body py-5">
                        <div class="fw-bolder fs-2">Votre dossier d'ouverture de compte à été accepter</div>
                        <p>Votre dossier d'ouverture de compte à été <strong>ACCEPTER</strong> par notre service compte bancaire.</p>
                        <p>Dans quelque jours, vous allez recevoir un email concernant l'ouverture définitive de votre compte bancaire.</p>
                        <p>Votre conseiller est M. MOCKELYN Maxime.<br>Vous pouvez le contacter si vous avez des questions relatives à la gestion de votre compte client.</p>
                        <p>Toutes l'équipe de {{ config('app.name') }} vous souhaitent la bienvenue parmis nous !</p>
                    </div>
                </div>
                @endif
                @if($user->customers->status_open_account == 'refused')
                <div class="card card-flush shadow-lg w-100">
                    <div class="card-header bg-bank">
                        <h3 class="card-title text-white">Dossier refusé</h3>
                    </div>
                    <div class="card-body py-5">
                        <div class="fw-bolder fs-2">Votre dossier d'ouverture de compte à été refusé</div>
                        <p>Votre dossier d'ouverture de compte à été <strong>REFUSER</strong> par notre service compte bancaire.</p>
                        <p>Nous sommes désolé de ne pouvoir donner suite à votre demande.</p>
                        <p>Le montant de 20,00 € à été recréditer sur votre compte bancaire</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--begin::Heading-->
@endsection

@section("script")
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        @isset($client_secret)
        let stripe = Stripe('{{ config('services.stripe.api_key') }}')

        const options = {
            clientSecret: '{{ $client_secret }}',
            // Fully customizable with appearance API.
        };

        const elements = stripe.elements(options);

        // Create and mount the Payment Element
        const paymentElement = elements.create('payment');
        paymentElement.mount('#payment-element');

        const form = document.getElementById('payment-form');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const {error} = await stripe.confirmPayment({
                //`Elements` instance that was used to create the Payment Element
                elements,
                confirmParams: {
                    return_url: 'https://fintech.io/register/terminate?payment=success',
                },
            });

            if (error) {
                // This point will only be reached if there is an immediate error when
                // confirming the payment. Show error to your customer (for example, payment
                // details incomplete)
                const messageContainer = document.querySelector('#error-message');
                messageContainer.textContent = error.message;
            } else {
                // Your customer will be redirected to your `return_url`. For some payment
                // methods like iDEAL, your customer will be redirected to an intermediate
                // site first to authorize the payment, then redirected to the `return_url`.
            }
        });
        @endisset

    </script>
@endsection
