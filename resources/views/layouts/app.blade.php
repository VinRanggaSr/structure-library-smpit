<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Perpustakaan SMP IT' }}</title>

    {{-- Inter 400 / 500 / 600 --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @if ($polos)
        {{ $slot }}
    @else
        <x-ui.header :nav="$nav" />

        <div class="ui-main-margin">
            <main class="ui-main">
                {{ $slot }}
            </main>
        </div>
    @endif
</body>
</html>
