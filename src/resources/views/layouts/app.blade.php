<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')

</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/">FashionablyLate</a>
            <nav class="header__nav">
                @if (request()->is('admin*') || request()->is('search*'))
                <form class="header__form" method="POST" action="/logout">
                    @csrf
                    <button class="header__btn" type="submit">logout</button>
                </form>

                @elseif (request()->is('login'))
                <a class="header__btn" href="/register">register</a>

                @elseif (request()->is('register'))
                <a class="header__btn" href="/login">login</a>
                @endif
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>