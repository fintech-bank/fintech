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
            @if($state == 'refused')
                <li class="step-error">Réponse</li>
            @else
                <li class="step-active">Réponse</li>
            @endif
            <li class="step-todo">Envoie des justificatifs</li>
            <li class="step-todo">Signatures</li>
            <li class="step-todo">Terminer</li>
        </ol>
    </div>
    @if($state == 'refused')
    <div class="card shadow-sm bg-light-danger">
        <div class="card-header bg-danger">
            <h3 class="card-title text-white">Réponse à votre demande de prêt personnel</h3>
        </div>
        <form id="formSubscribePersonnalLoan" action="{{ route('customer.subscription.personnal') }}" method="POST" enctype="multipart/formdata">
            @csrf
            <input type="hidden" name="customer_id" value="{{ $info->customer_id }}">
            <input type="hidden" name="amount" value="{{ $info->amount }}">
            <input type="hidden" name="duration" value="{{ $info->duration }}">
            <input type="hidden" name="action" value="response">
            <div class="card-body">
                <div class="d-flex flex-column justify-content-center text-center">
                    <i class="fa-solid fa-xmark fa-3x text-danger mb-3"></i>
                    <div class="fs-2 fw-bolder mb-3">Votre demande de prêt personnel à été refusé</div>
                    <p>Malheureusement, votre demande de prêt personnel d'un montant de <strong>{{ eur($info->amount) }}</strong> ne peut pas être acceptée en l'état actuelle de votre dossier.</p>
                    <p>N'hésitez pas à réitéré votre demande dans les prochaines semaines ou contacter directement un conseiller.</p>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex flex-end">
                    <a href="" class="btn btn-bank">Retour à votre compte</a>
                </div>
            </div>
        </form>
    </div>
    @else
        <div class="card shadow-sm bg-light-success">
            <div class="card-header bg-success">
                <h3 class="card-title text-white">Réponse à votre demande de prêt personnel</h3>
            </div>
            <form id="formSubscribePersonnalLoan" action="{{ route('customer.subscription.personnal') }}" method="POST" enctype="multipart/formdata">
                <div class="card-body">
                    <input type="hidden" name="customer_id" value="{{ $info->customer_id }}">
                    <input type="hidden" name="amount" value="{{ $info->amount }}">
                    <input type="hidden" name="duration" value="{{ $info->duration }}">
                    <input type="hidden" name="action" value="justificatif">
                    <div class="d-flex flex-column justify-content-center text-center">
                        <i class="fa-solid fa-check-circle fa-3x text-success mb-3"></i>
                        <div class="fs-2 fw-bolder mb-3">Votre demande de prêt personnel à été pré-acceppté</div>
                        <p>Veuillez poursuivre votre demande en nous envoyant les pièces justificative afin d'étudié votre dossier de façon plus approfondie.</p>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex flex-center">
                        <x-form.button text="Continuer" class="btn btn-bank w-50" />
                    </div>
                </div>
            </form>
        </div>
    @endif
@endsection

@section("script")
    @include("customer.scripts.subscription.loan.personnalSubscribe")
@endsection
