<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | LaporBanjir BPBD</title>
    <link rel="stylesheet" href="{{ asset('css/portal-banjir.css') }}">
    @stack('styles')
</head>
<body>
    <div class="site-shell">
        <header class="site-header">
            <div class="site-header-inner">
                <a class="site-brand" href="{{ route('laporans.index') }}">BPBD Kabupaten Bandung</a>
                <nav class="site-nav" aria-label="Navigasi utama">
                    @auth
                        @php($reportsActive = request()->routeIs('home', 'laporans.index', 'laporans.show'))
                        <a href="{{ route('laporans.index') }}" @class(['is-active' => $reportsActive]) @if($reportsActive) aria-current="page" @endif>Daftar laporan</a>
                        <a href="{{ route('profile') }}" @class(['is-active' => request()->routeIs('profile')]) @if(request()->routeIs('profile')) aria-current="page" @endif>Profil Petugas</a>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="nav-button" type="submit">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" @class(['is-active' => request()->routeIs('login')])>Login</a>
                        <a href="{{ route('register') }}" @class(['is-active' => request()->routeIs('register')])>Register</a>
                    @endauth
                    <a href="{{ route('laporans.create') }}" @class(['is-active' => request()->routeIs('laporans.create')]) @if(request()->routeIs('laporans.create')) aria-current="page" @endif>Buat laporan</a>
                </nav>
            </div>
        </header>

        <main @class(['page-content', 'page-content-wide' => request()->routeIs('home', 'laporans.index')])>
            @yield('content')
        </main>

        <footer class="site-footer">
            <div class="site-footer-inner">BPBD Kabupaten Bandung <span aria-hidden="true">|</span> LaporBanjir</div>
        </footer>
    </div>
</body>
</html>
