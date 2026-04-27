@extends('layouts.main')

@section('content')
<main class="login-page ocean-login">
    <div class="ocean-sky" aria-hidden="true">
        <span class="star star-a"></span>
        <span class="star star-b"></span>
        <span class="star star-c"></span>
        <span class="star star-d"></span>
        <span class="star star-e"></span>
        <span class="star star-f"></span>
    </div>

    <div class="ocean-floor" aria-hidden="true">
        <div class="shell shell-left"></div>
        <div class="shell shell-right"></div>

        <svg class="wave wave-back" viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path fill="rgba(48, 142, 216, 0.58)" d="M0,288L48,261.3C96,235,192,181,288,181.3C384,181,480,235,576,261.3C672,288,768,288,864,261.3C960,235,1056,181,1152,154.7C1248,128,1344,128,1392,128L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
        <svg class="wave wave-front" viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path fill="rgba(16, 95, 174, 0.92)" d="M0,224L34.3,202.7C68.6,181,137,139,206,149.3C274.3,160,343,224,411,245.3C480,267,549,245,617,218.7C685.7,192,754,160,823,160C891.4,160,960,192,1029,213.3C1097.1,235,1166,245,1234,229.3C1302.9,213,1371,171,1406,149.3L1440,128L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
        </svg>
    </div>

    <section class="login-stage">
        <section class="login-card">
            <h2 class="login-title">Supervisor Login</h2>
            <p class="login-subtitle">Masuk menggunakan username dan password.</p>

            @if ($errors->any())
                <div class="login-alert">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}" class="login-form">
                @csrf

                <div class="field-group">
                    <label for="username">Username</label>
                    <input id="username" name="username" type="text" value="{{ old('username') }}" required autofocus>
                </div>

                <div class="field-group">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" required>
                </div>

                <button type="submit" class="btn-login">Masuk</button>
            </form>
        </section>
    </section>
</main>
@endsection
