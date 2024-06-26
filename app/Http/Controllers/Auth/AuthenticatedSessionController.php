<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Informasi;
use App\Models\Knowledge;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        // return view('auth.login');
        $informasi = Informasi::latest()->first();
        $pengetahuan = Knowledge::inRandomOrder()->first();
        return view('welcome', [
            'informasi' => $informasi,
            'pengetahuan' => $pengetahuan,
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $user = $request->user();
        if ($user && $user->status != 1) {
            Auth::logout();
            Session::invalidate();
            Session::regenerateToken();

            return redirect()->route('login')->with('error', 'Akun Anda belum diapprove oleh Admin');
            // throw ValidationException::withMessages([
            //     'error' => __('Akun Anda belum diapprove oleh Admin'),
            // ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
