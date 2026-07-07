<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function (Request $request, Closure $next) {
            $user = $request->session()->get('auth_user');

            if (! $user) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
            }

            if (($user['role'] ?? 'user') !== 'admin') {
                abort(403, 'Akses admin ditolak.');
            }

            return $next($request);
        });
    }
}
