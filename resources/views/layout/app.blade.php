<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1">
    <title>Softopark Payment Gateway</title>
    {{-- <link rel="icon" href="ssl.ico" type="image/icon type> --}}
    {{-- <link href="https://www.sslcommerz.com/wp-content/uploads/2020/03/favicon.png" rel="icon"> --}}
    <link href="https://www.softopark.com/static/images/logo/Softopark_Fevicon.png" rel="icon">
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/starter-template/">
    <link href="https://getbootstrap.com/docs/4.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- Favicons -->
    <link rel="manifest" href="https://getbootstrap.com/docs/4.5/assets/img/favicons/manifest.json">
    <meta name="msapplication-config" content="/docs/4.5/assets/img/favicons/browserconfig.xml">
    <meta name="theme-color" content="#563d7c">
    <style>
        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

    </style>
    <link href="https://getbootstrap.com/docs/4.5/examples/starter-template/starter-template.css" rel="stylesheet">
</head>

<body class="bg-light">
    @include('inc.navbar')
    <div class="container">
        @yield('content')
    </div>
</body>

</html>
