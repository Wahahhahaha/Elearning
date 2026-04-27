<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        return view('home', [
            'generatedCodes' => $request->session()->get('generated_codes'),
        ]);
    }

    public function generate(Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'length' => ['required', 'integer', 'min:4', 'max:24'],
            'supervisor_link' => ['nullable', 'url', 'max:255'],
        ]);

        $length = (int) $payload['length'];
        $supervisorLink = trim((string) ($payload['supervisor_link'] ?? ''));

        $generatedCodes = [
            'masuk_android_studio' => $this->buildCode('MASUK', $length),
            'buka_kunci_android_studio' => $this->buildCode('BUKA', $length),
            'keluar_aplikasi_android_studio' => $this->buildCode('KELUAR', $length),
            'supervisor_link' => $supervisorLink,
            'generated_at' => now()->format('d M Y H:i:s'),
        ];

        $request->session()->put('generated_codes', $generatedCodes);

        return redirect()
            ->route('home')
            ->with('status', '3 kode berhasil dibuat.');
    }

    private function buildCode(string $prefix, int $length): string
    {
        $prefix = strtoupper($prefix);
        $randomLength = max(1, $length - strlen($prefix));
        $randomPart = strtoupper(substr(bin2hex(random_bytes(20)), 0, $randomLength));

        return substr($prefix . $randomPart, 0, $length);
    }
}
