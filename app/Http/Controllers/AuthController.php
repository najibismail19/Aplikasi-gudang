<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Service\LoginService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    private LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function login() : Response
    {
        return response()->view("auth.login");
    }

    public function doLogin(Request $request) : RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::guard('karyawan')->attempt($credentials)) {
            $request->session()->regenerate();

            $this->loginService->login();

            if(Auth::guard("karyawan")->user()->jabatan->nama_jabatan == "Operator Prakitan") {
                return redirect()->intended('/profile');
            }
            return redirect()->intended('/dashboard');
        };

        return back();
    }

    // public function register() : Response
    // {
    //     return response()->view("auth.register");
    // }

    // public function doRegister(Request $request) : RedirectResponse
    // {
    //     $karyawan = $request->validate([
    //         'nik' => 'required|unique:karyawan',
    //         'nama' => 'required',
    //         'email' => 'required|unique:karyawan',
    //         'password' => 'required',
    //     ]);
    //     $karyawan["password"] = Hash::make($request->input('password'));
    //     $karyawan["id_jabatan"] = "J001";
    //     $karyawan["id_gudang"] = "G001";
    //     $query = Karyawan::insert($karyawan);
    //     if($query) {
    //         return redirect("/auth/login")->withSuccess('You have signed-in');
    //     }
    // }

    public function logout(Request $request)
    {
        $this->loginService->logout();

        Auth::guard('karyawan')->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/auth/login');
    }
}
