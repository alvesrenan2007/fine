<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>

    <header class="header-main">
        <div class="header-main__brand">
            fine
        </div>
        <nav class="header-navigation">
            @yield('header')
        </nav>
    </header>

    @if($errors->any())
        <div class="status-bar__error">
            <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <x-status-message/>

    <main class="app-shell">
        <header class="app-shell__header">
            <div>
                <h1 class="app-shell__title"> @yield('app-shell-title') </h1>
                <p class="app-shell__subtitle"> @yield('app-shell-subtitle')</p>
            </div>
            <div class="app-shell__actions">
                @yield('action-buttons')
            </div>
        </header>

        <section class="app-shell__workspace">
            @yield('app-shell-workspace')
        </section>
        <section class="app-shell__lower-actions">
            @yield('app-shell-lower-actions')
        </section>
    </main>

    <aside class="floating-mass">
        @yield('floating-buttons')
    </aside>

</body>
</html>
