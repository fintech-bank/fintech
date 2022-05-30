@extends("emails.layouts.app")

@section("content")
    <div class="d-flex flex-column bg-gray-300 ms-20 me-20 mt-20 mb-5 w-600px rounded">
        <!--begin::Alert-->
        <div class="alert bg-bank d-flex flex-column flex-sm-row p-5 mb-10 mt-10 rounded">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <!--begin::Content-->
                <span class="fs-2tx fw-bolder text-start">Informations sur la gestion de votre compte</span>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        @switch($status)
            @case('completed')
            <div class="alert bg-bank d-flex flex-column flex-sm-row p-5 mb-10 mt-10 rounded">
                <!--begin::Wrapper-->
                <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                    <!--begin::Content-->
                    <span class="fs-2tx fw-bolder text-start">VOTRE OUVERTURE DE COMPTE</span>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>
            @break
            @case('accepted')
            <div class="alert bg-success d-flex flex-column flex-sm-row p-5 mb-10 mt-10 rounded">
                <!--begin::Wrapper-->
                <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                    <!--begin::Content-->
                    <span class="fs-2tx fw-bolder text-start">VOTRE OUVERTURE DE COMPTE</span>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>
            @break
            @case('declined')
            <div class="alert bg-danger d-flex flex-column flex-sm-row p-5 mb-10 mt-10 rounded">
                <!--begin::Wrapper-->
                <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                    <!--begin::Content-->
                    <span class="fs-2tx fw-bolder text-start">VOTRE OUVERTURE DE COMPTE</span>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>
            @break
            @case('terminated')
            <div class="alert bg-bank d-flex flex-column flex-sm-row p-5 mb-10 mt-10 rounded">
                <!--begin::Wrapper-->
                <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                    <!--begin::Content-->
                    <span class="fs-2tx fw-bolder text-start">VOTRE OUVERTURE DE COMPTE</span>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>
            @break
            @case('suspended')
            <div class="alert bg-warning d-flex flex-column flex-sm-row p-5 mb-10 mt-10 rounded">
                <!--begin::Wrapper-->
                <div class="d-flex flex-column text-dark pe-0 pe-sm-10">
                    <!--begin::Content-->
                    <span class="fs-2tx fw-bolder text-start">VOTRE OUVERTURE DE COMPTE</span>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>
            @break
            @case('closed')
            <div class="alert bg-danger d-flex flex-column flex-sm-row p-5 mb-10 mt-10 rounded">
                <!--begin::Wrapper-->
                <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                    <!--begin::Content-->
                    <span class="fs-2tx fw-bolder text-start">VOTRE OUVERTURE DE COMPTE</span>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>
            @break
        @endswitch
        <!--end::Alert-->
        <div class="ms-10 me-10 mb-5">
            <span class="fw-bolder fs-3 mb-5">Bonjour {{ \App\Helper\CustomerHelper::getFirstname($customer) }}</span>
            @switch($status)
                @case('completed')
                    <p>
                        Votre dossier d'ouverture de compte bancaire est actuellement terminer.<br>
                        Un conseiller bancaire va étudier votre dossier et un mail vous sera envoyer avec l'acceptation ou le refus de votre demande d'ouverture de compte chez nous!
                    </p>
                    <p>Si vous n'êtes pas à l'origine de cette demande, merci de nous contacter au plus vite !</p>
                @break
                @case('accepted')
                    <p>Votre dossier d'ouverture de compte à été <strong>ACCEPTER</strong> par notre service compte bancaire.</p>
                    <p>Votre conseiller est M. MOCKELYN Maxime.<br>Vous pouvez le contacter si vous avez des questions relatives à la gestion de votre compte client.</p>
                    <p>Toutes l'équipe de {{ config('app.name') }} vous souhaitent la bienvenue parmis nous !</p>
                @break
                @case('declined')
                <p>Votre dossier d'ouverture de compte à été <strong>REFUSER</strong> par notre service compte bancaire.</p>
                <p>Nous sommes désolé de ne pouvoir donner suite à votre demande.</p>
                @break
                @case('terminated')
                <p>Votre compte personnel est maintenant OUVERT.</p>
                <p>Vous pouvez y acceder directement par l'intermédiaire de votre espace client avec les identifiants et mot de passe qui vous ont été transmis dans un email à part !</p>
                @break
                @case('suspended')
                <p>Votre compte client à été <strong>SUSPENDU</strong> par notre service compte bancaire.</p>
                <p>La raison évoqué est la suivante:</p>
                <blockquote>{{ $reason }}</blockquote>
                <p>Si vous avez des questions relative à cette raison, n'hésitez pas à contacter votre conseiller.</p>
                @break
                @case('closed')
                <p>Votre compte client à été <strong>CLOTÛRER</strong> par notre service compte bancaire.</p>
                <p>La Raison évoqué est la suivante:</p>
                <blockquote>{{ $reason }}</blockquote>
                <p>Une lettre recommandé vous à été envoyer ce jours.</p>
                <p>Si vous avez des questions relative à cette raison, n'hésitez pas à contacter votre conseiller.</p>
                @break
            @endswitch
        </div>
        @include("emails.layouts.salutation")
    </div>
@endsection

