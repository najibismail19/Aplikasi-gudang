<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\Karyawan;
use App\Models\Login;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function profile() : Response
    {
        return response()->view("users.profile", [
            "user" =>  Auth::guard('karyawan')->user()
        ]);
    }

    public function logAuthentication(Request $request) : Response | JsonResponse
    {
        if ($request->ajax()) {
            $data = Login::select("*")->with(['karyawan'])->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('nama_karyawan', function (Login $login) {
                        $karyawan =  $login->karyawan;
                        return $karyawan->nama;
                    })
                    ->addColumn('tanggal_logout', function($login){
                        $btn = "";
                        if($login->tanggal_logout == null) {
                            $btn  = $btn . "<p>Sedang Aktif</p>";
                        } else {
                            $btn  = $btn . "<p>$login->tanggal_logout</p>";
                        }
                        return $btn;
                    })
                    ->rawColumns(['tanggal_logout'])
                    ->make(true);
        }

        return response()->view("users.log-authentication", [
            "title" => "Log Authentication"
        ]);
    }

    public function usersActivity(Request $request)
    {
        if($request->ajax())
        {

            $logins = Login::select('nik')->distinct()->get();

            $users = new Collection;
                foreach($logins as $login ) {
                    $query = Login::select("*")
                                        ->with(["karyawan"])
                                        ->where("nik", $login->nik)
                                        ->orderBy("create_at", 'desc')
                                        ->first();
                    $users->push([
                        "nama" => $query->karyawan->nama,
                        "gudang" => Gudang::find($query->karyawan->id_gudang)->nama_gudang,
                        "alamat" => $query->karyawan->alamat,
                        "kontak" => $query->karyawan->kontak,
                        "tanggal_logout" => $query->tanggal_logout,
                    ]);
                }

                return Datatables::of($users)
                        ->addIndexColumn()
                        ->addColumn('tanggal_logout', function($login){
                            $btn = "";
                            if($login["tanggal_logout"] == null) {
                                $btn  = $btn . "<a class='btn btn-success btn-sm mx-1'>Sedang Aktif</a>";
                            } else {
                                $btn  = $btn . "<a class='btn btn-danger btn-sm mx-1'>Sedang Off</a>";
                            }
                            return $btn;
                        })
                        ->rawColumns(['tanggal_logout'])
                        ->make(true);
        }

        return response()->view("users.users-activity", [
        ]);
    }
}
