<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class RulesAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
        // $idJabatan = Auth::guard("karyawan")->user()->jabatan->id_jabatan;

        // $role_access = DB::table("user_sub_menu")->join('user_access_menu', 'user_sub_menu.sub_menu_id', '=', 'user_access_menu.sub_menu_id')
        //                 ->select('user_sub_menu.url')
        //                 ->where("user_access_menu.id_jabatan", Auth::guard("karyawan")->user()->jabatan->id_jabatan)
        //                 ->where("user_sub_menu.url", "/" . request()->segment(1))
        //                 ->first();

        // if($role_access) {
        //     return $next($request);
        // }

        // return abort(404);

        // if($request->path() == "pembelian" || $request->path() == "supplier") {
        //     if($jabatan == "Staff Pembelian" || $jabatan == "Manajer Gudang" || $jabatan == "Supervisor Gudang" || $jabatan == "Admin") {
        //         return $next($request);
        //     }
        //     return abort(404);
        // }

        // if($request->path() == "dashboard") {
        //     if($jabatan == "Operator Prakitan") {
        //         return abort(404);
        //     }
        //     return $next($request);
        // }

        // if($request->path() == "penerimaan") {
        //     if($jabatan == "Staff Penerimaan" || $jabatan == "Admin" || $jabatan == "Supervisor Gudang" || $jabatan == "Manajer Gudang") {
        //         return $next($request);
        //     }
        //     return abort(404);
        // }

        // if($request->path() == "penjualan" || $request->path() == "customers") {
        //     if ($jabatan == "Staff Penjualan" || $jabatan == "Admin" || $jabatan == "Supervisor Gudang" || $jabatan == "Manajer Gudang") {
        //         return $next($request);
        //     }
        //     return abort(404);
        // }

        // if($request->path() == "prakitan") {
        //     if ($jabatan == "Operator Prakitan" || $jabatan == "Admin" || $jabatan == "Supervisor Gudang" || $jabatan == "Manajer Gudang") {
        //         return $next($request);
        //     }
        //     return abort(404);
        // }

        // if($request->path() == "users") {
        //     if ($jabatan == "Admin" || $jabatan == "Supervisor Gudang" || $jabatan == "Manajer Gudang"){
        //         return $next($request);
        //     }
        //     return abort(404);
        // }

        // return $next($request);
    }
}
