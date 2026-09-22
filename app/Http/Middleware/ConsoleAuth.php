<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ConsoleAuth
{
    public function handle(Request $request, Closure $next)
    {
        $userId = $request->session()->get('console_user');
        $user = $userId ? User::whereKey($userId)->where('is_active', true)->first() : null;

        if (! $user) {
            $request->session()->forget('console_user');

            return redirect('/console/login');
        }

        // Peran Kabupaten hanya mengelola usulan dan pendataan RTLH.
        if ($user->role === 'kabupaten' && ! $request->is(
            'console/pendataan-rlth',
            'console/pendataan-rlth/*',
            'console/data-usulan',
            'console/data-usulan/*'
        )) {
            abort(403, 'Akun Kabupaten hanya dapat mengakses Data Usulan dan Pendataan RTLH.');
        }

        $request->attributes->set('console_user', $user);

        return $next($request);
    }
}
