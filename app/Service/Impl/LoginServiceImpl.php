<?php
namespace App\Service\Impl;

use App\Models\Login;
use Illuminate\Support\Facades\Auth;
use App\Service\LoginService;
use Carbon\Carbon;

Class LoginServiceImpl implements LoginService {
    public function login()
    {
        $nik = Auth::guard('karyawan')->user()->nik;

        $newLogin = new Login();
        $newLogin->tanggal_login = Carbon::now();
        $newLogin->nik = $nik;
        $newLogin->ip = request()->ip();
        $newLogin->device = request()->header('User-Agent');
        $newLogin->save();
    }

    public function logout()
    {
        $nik = Auth::guard('karyawan')->user()->nik;

        $login = Login::where("nik", $nik)->orderBy("create_at", "desc")->first();
        $login->tanggal_logout = Carbon::now();
        $login->update();
    }
}
