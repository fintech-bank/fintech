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
    <footer>
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td style="width: 33%;">
                        {{ config('app.name') }} - Agence {{ $agence->name }} - {{ $agence->address }}, {{ $agence->postal }} {{ $agence->city }}
                    </td>
                    <td style="width: 33%; text-align: center">
                        {{ $title }}
                    </td>
                    <td style="width: 33%; text-align: right">
                        Page <span class="pagenum"></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </footer>
    @yield("content")

</body>
</html>
