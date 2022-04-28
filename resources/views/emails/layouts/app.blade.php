<!DOCTYPE html>
<!--
Author: Keenthemes
Product Name: Metronic - Bootstrap 5 HTML, VueJS, React, Angular & Laravel Admin Dashboard Theme
Purchase: https://1.envato.market/EA4JP
Website: http://www.keenthemes.com
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
<!--begin::Head-->
<head>
    <base href="">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="{{ config('app.url') }}/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

    <style>
        body {
            font-family: Poppins, Arial, 'Helvetica Neue', sans-serif;
            font-size: 14px;
        }
        .page-break {
            page-break-after: always;
        }
        .body.white {
            background-color: #ffffff;
        }
        .bg-dark {
            background-color: #000 !important;
        }
        .bg-danger {
            background-color: #d50000 !important;
        }
        .bg-success {
            background-color: #39d500 !important;
        }
        .text-danger {
            color: #d50000 !important;
        }
        .text-success {
            color: #39d500 !important;
        }
        .body {
            background-color: #dfe0e0;
            border-bottom-right-radius: 5px;
            border-bottom-left-radius-radius: 5px;
        }
        .flex-center {
            justify-content: center;
            align-items: center;
        }
        .fs-5 {
            font-size: 1.15rem !important;
        }
        .fs-8 {
            font-size: 0.55rem !important;
        }
        .m-15 {
            margin: 3.75rem !important;
        }
        .d-flex {
            display: flex !important;
        }
        .justify-content-lg-between {
            justify-content: space-between !important;
        }
        .align-items-center {
            align-items: center !important;
        }
        .flex-row {
            flex-direction: row !important;
        }
        .w-600px {
            width: 600px !important;
        }
        .text-start {
            text-align: left !important;
        }
        img {
            vertical-align: middle;
            border-style: none;
        }
        .fs-1 {
            font-size: calc(1.3rem + 0.6vw) !important;
            text-align: center;
        }
        .fw-bolder {
            font-weight: 600 !important;
        }
        .fw-normal {
            font-weight: 400 !important;
        }
        .fs-6 {
            font-size: 1.075rem !important;
        }
        .bg-gray-300 {
            background-color: #E4E6EF;
        }
        .ms-10 {
            margin-left: 2.5rem !important;
        }
        .ms-20 {
            margin-left: 5rem !important;
        }
        .mb-5 {
            margin-bottom: 1.25rem !important;
        }
        .me-10 {
            margin-right: 2.5rem !important;
        }
        .me-20 {
            margin-right: 5rem !important;
        }
        .mt-20 {
            margin-top: 5rem !important;
        }
        .flex-column {
            flex-direction: column !important;
        }
        .mb-5, .my-5 {
            margin-bottom: 3rem!important;
        }
        .bg-bank {
            background-color: #0c27a3 !important;
        }
        .alert {
            width: 90%;
            margin: 0 auto;
            padding: 20px;
            background-color: #ff9d00;
            text-align: center;
        }
        .flex-sm-row {
            flex-direction: row !important;
        }
        .p-5 {
            padding: 1.25rem !important;
        }
        .mb-10 {
            margin-bottom: 2.5rem !important;
        }
        .mt-10 {
            margin-top: 2.5rem !important;
        }
        .text-light {
            color: #F5F8FA !important;
        }
        .pe-sm-10 {
            padding-right: 2.5rem !important;
        }
        .pe-0 {
            padding-right: 0 !important;
        }
        .fs-2tx {
            font-size: calc(1.4rem + 1.8vw) !important;
        }
        .fs-3 {
            font-size: calc(1.26rem + 0.12vw) !important;
        }
        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        .rounded {
            border-radius: 0.654rem;
        }

        .rounded-2 {
            border-radius: 1.230rem;
        }
    </style>
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->
<body class="body white m-15 fs-5 d-flex flex-center flex-column">
    <div class="d-flex flex-row justify-content-lg-between align-items-center w-600px">
        <img src="{{ asset('/storage/logo/logo_carre_80.png') }}" alt="" class="text-start">
        <div class="fs-1 fw-bolder">{{ config('app.name') }} <span class="fw-normal fs-6">vous informe</span></div>
    </div>
    @yield("content")
    <div class="d-flex flex-column align-items-center w-600px">
        <!--begin::Alert-->
        <div class="alert bg-dark d-flex flex-column flex-sm-row p-5 mb-10 mt-10 rounded">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <!--begin::Content-->
                <span class="fs-1 fw-bolder text-start">Vous avez des questions ?</span>
                <p class="text-start">Contactez notre conseiller par chat 24/7 sur {{ config('app.url') }}. Si besoin, un expert
                    {{ config('app.name') }} prend le relais.</p>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Alert-->
        <p class="fs-8">Pour des raisons de sécurité, {{ config('app.name') }} ne vous demandera jamais de vous connecter à votre espace client en cliquant sur un lien direct depuis un email. Vous devrez toujours vous rendre sur votre application ou sur
            {{ config('app.url') }}</p>
        <p class="fs-8">Merci de ne pas répondre à cet email, votre demande ne pourrait pas aboutir.</p>
        <p class="fs-8">Conformément à la réglementation relative à la protection des données personnelles, vous bénéficiez d'un droit d'accès, de rectification, d'effacement et de portabilité de vos informations personnelles. Pour toutes questions : c'est par ici.</p>
        <p class="fs-8">{{ config('app.name') }} - SAS au capital variable de 300 250 300€ - 4 Rue du Coudray - 44025 Nantes Cedex - 521 809 061 RCS Nantes - Orias n°07 006 369</p>
    </div>
</body>
<!--end::Body-->
</html>
