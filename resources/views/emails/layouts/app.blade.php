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
    <link href="{{ config('app.url') }}/css/email.css" rel="stylesheet" type="text/css" />
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
