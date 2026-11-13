<?php

namespace App\Http\Middleware;

use App\Support\ContohData;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Tahap visual belum punya login sungguhan, tapi header memakai auth()->user().
 * Middleware ini mengisi pengguna contoh sesuai peran halaman supaya Blade tidak
 * perlu diubah saat autentikasi asli masuk — cukup hapus middleware-nya.
 */
class MasukSebagaiContoh
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        Auth::setUser(ContohData::penggunaBerperan($role));

        return $next($request);
    }
}
