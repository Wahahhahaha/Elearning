@extends('layouts.main')

@section('content')
<main class="home-page dashboard-ocean">
    <div class="dashboard-ornament" aria-hidden="true">
        <span class="bubble bubble-a"></span>
        <span class="bubble bubble-b"></span>
        <span class="bubble bubble-c"></span>
    </div>

    <section class="home-shell">
        <header class="home-topbar">
            <div>
                <p class="home-tag">Dashboard Supervisor</p>
                <h1 class="home-title">Control Center Kode Android Studio</h1>
                <p class="home-subtitle">Kelola 3 kode akses dalam satu halaman dengan tampilan ringkas dan fokus.</p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </header>

        @if (session('status'))
            <div class="home-alert success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="home-alert error">{{ $errors->first() }}</div>
        @endif

        <section class="home-grid">
            <article class="panel panel-generator">
                <h2 class="panel-title">Generator Kode</h2>
                <p class="panel-subtitle">Atur panjang kode lalu klik generate untuk membuat 3 kode baru.</p>

                <form method="POST" action="{{ route('code.generate') }}" class="generator-form">
                    @csrf

                    <div class="field-group">
                        <label for="length">Panjang Kode</label>
                        <input id="length" name="length" type="number" min="4" max="24" value="{{ old('length', 10) }}" required>
                    </div>

                    <div class="field-group">
                        <label for="supervisor_link">Link Tujuan Kode Masuk Supervisor</label>
                        <input id="supervisor_link" name="supervisor_link" type="url" value="{{ old('supervisor_link', $generatedCodes['supervisor_link'] ?? '') }}" placeholder="https://domainanda.com/halaman-tujuan">
                    </div>

                    <button type="submit" class="btn-primary">Generate 3 Kode</button>
                </form>
            </article>

            <article class="panel panel-result">
                <h2 class="panel-title">Hasil Generate Terakhir</h2>
                <p class="panel-subtitle">Kode terbaru akan muncul di sini setelah proses generate berhasil.</p>

                @if (!empty($generatedCodes))
                    <div class="result-meta">Terakhir dibuat: {{ $generatedCodes['generated_at'] }}</div>

                    <section class="result-grid">
                        <div class="result-card">
                            <p class="result-label">Kode Masuk Android Studio</p>
                            <p class="result-code">{{ $generatedCodes['masuk_android_studio'] }}</p>
                        </div>

                        <div class="result-card">
                            <p class="result-label">Kode Buka Kunci Android Studio</p>
                            <p class="result-code">{{ $generatedCodes['buka_kunci_android_studio'] }}</p>
                        </div>

                        <div class="result-card">
                            <p class="result-label">Kode Keluar Aplikasi Android Studio</p>
                            <p class="result-code">{{ $generatedCodes['keluar_aplikasi_android_studio'] }}</p>
                        </div>
                    </section>

                    <div class="link-box">
                        <p class="result-label">Link Tujuan Supervisor</p>
                        <p class="link-value">{{ $generatedCodes['supervisor_link'] !== '' ? $generatedCodes['supervisor_link'] : '-' }}</p>
                    </div>
                @else
                    <div class="history-empty">Belum ada kode dibuat. Silakan isi form generator lalu klik tombol Generate 3 Kode.</div>
                @endif
            </article>
        </section>
    </section>
</main>
@endsection
