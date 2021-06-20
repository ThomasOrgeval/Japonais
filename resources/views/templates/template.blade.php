<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
    <title>{{ $title ?? 'Lexique Japonais' }}</title>
    <link rel="shortcut icon" type="image" href="{{ asset('images/sakura.webp') }}">

    <meta property="og:title" content="Lexique Japonais">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://lexiquejaponais.fr">
    <meta property="og:image" content="https://lexiquejaponais.fr/resources/images/sakura.webp">
    <meta property="og:description"
          content="Lexique japonais permet de s’exercer chaque jour, se lancer des défis, défier des amis, le tout dans la langue de ごく (Goku) ! Lexique japonais contient tout ce que vous recherchez sur la langue japonaise.">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css" rel="stylesheet"/>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<header>
    @include('templates.navbar')
</header>
<main style="margin-top: 58px">
    @include('templates.modal')
    <div class="container pt-4">
        @include('flash::message')
        @yield('content')
    </div>

    <footer>
        @include('templates.footer')
    </footer>
</main>

<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>

<!-- Chart JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.2.1/dist/chart.min.js"></script>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
