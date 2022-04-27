<!doctype html>
<html lang="fr">
<head>
    <title>{{ $title }}</title>
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700&amp;subset=all' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
</head>
<body>
    @include('pdf.layouts.header', ["type" => $header_type])
    @yield("content")
</body>
</html>
