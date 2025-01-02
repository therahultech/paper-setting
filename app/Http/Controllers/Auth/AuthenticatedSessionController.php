<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\LoginLog;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent; // Install via "composer require jenssegers/agent"

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $user = Auth::attempt($request->only('email', 'password'));

        $agent = new Agent();

        if ($user) {
            $loginUser = Auth::user();

            LoginLog::create([
                'user_id' => $loginUser->id,
                'ip_address' => $request->ip(),
                'client_ip_address' => $this->getClientIp($request),
                'user_agent' => $request->header('User-Agent'),
                'device' => $agent->device(),
                'browser' => $agent->browser(),
                'os' => $agent->platform(),
                'location' => $this->getLocationFromIP($request->ip()), // Optional, uses a geo IP API
                'status' => 'success',
            ]);

            $request->session()->regenerate();

            return redirect()->intended(RouteServiceProvider::HOME);
        } else {
            LoginLog::create([
                'user_id' => null,
                'ip_address' => $request->ip(),
                'client_ip_address' => $this->getClientIp($request),
                'user_agent' => $request->header('User-Agent'),
                'device' => $agent->device(),
                'browser' => $agent->browser(),
                'os' => $agent->platform(),
                'location' => $this->getLocationFromIP($request->ip()), // Optional
                'status' => 'failed',
            ]);

            return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
        }
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function getLocationFromIP($ip)
    {
        try {
            $response = @file_get_contents("http://ip-api.com/json/{$ip}");
            $data = json_decode($response, true);

            return $data['city'] . ', ' . $data['country'] ?? 'Unknown';
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }

    /**
     * Get the client IP address.
     */
    private function getClientIp(Request $request)
    {
        $ip = $request->header('X-Forwarded-For');
        if ($ip) {
            return explode(',', $ip)[0]; // Get the first IP from the list
        }

        return $request->ip();
    }
}
