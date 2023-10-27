<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Login;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{

    public function profile() : Response | JsonResponse
    {
        $user = Auth::guard('karyawan')->user();

        if(request()->ajax()) {
            return response()->json([
                "data" => $user
            ]);
        };

        return response()->view("users.profile", [
            "user" =>  $user,
            "usia" => ($user->tanggal_lahir) ? Carbon::parse($user->tanggal_lahir)->age : "-",
            "tanggal_lahir" => ($user->tanggal_lahir) ? Carbon::parse($user->tanggal_lahir)->isoFormat('D MMMM Y') : "-"
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
                        $btn = $login->tanggal_logout ?? "-";
                        return $btn;
                    })
                    ->rawColumns(['tanggal_logout'])
                    ->make(true);
        }

        return response()->view("users.log-authentication", [
            "title" => "Log Authentication"
        ]);
    }

    // public function usersActivity(Request $request)
    // {
    //     if($request->ajax())
    //     {

    //         $logins = Login::select('nik')->distinct()->get();

    //         $users = new Collection;
    //             foreach($logins as $login ) {
    //                 $query = Login::select("*")
    //                                     ->with(["karyawan"])
    //                                     ->where("nik", $login->nik)
    //                                     ->orderBy("create_at", 'desc')
    //                                     ->first();
    //                 $users->push([
    //                     "nama" => $query->karyawan->nama,
    //                     "gudang" => Gudang::find($query->karyawan->id_gudang)->nama_gudang,
    //                     "alamat" => $query->karyawan->alamat,
    //                     "kontak" => $query->karyawan->kontak,
    //                     "tanggal_logout" => $query->tanggal_logout,
    //                 ]);
    //             }

    //             return Datatables::of($users)
    //                     ->addIndexColumn()
    //                     ->addColumn('tanggal_logout', function($login){
    //                         $btn = "";
    //                         if($login["tanggal_logout"] == null) {
    //                             $btn  = $btn . "<a class='btn btn-success btn-sm mx-1'>Sedang Aktif</a>";
    //                         } else {
    //                             $btn  = $btn . "<a class='btn btn-danger btn-sm mx-1'>Sedang Off</a>";
    //                         }
    //                         return $btn;
    //                     })
    //                     ->rawColumns(['tanggal_logout'])
    //                     ->make(true);
    //     }

    //     return response()->view("users.users-activity", [
    //     ]);
    // }

    public function listUsers()
    {
        $users = Karyawan::with(["gudang", "jabatan"])->latest()->get();
        if(request()->ajax()) {
            $data = [];
            $no = 1 ;
            foreach($users as $s) {
                $data[] = [
                    "number" => $no++,
                    "nik" => $s->nik,
                    "nama" => $s->nama,
                    "gudang" => $s->gudang->nama_gudang,
                    "alamat" => $s->alamat ?? "-",
                    "kontak" => $s->kontak ?? "-",
                    "jabatan" => $s->jabatan->nama_jabatan,
                ];
            }

            return response()->json([
                "data" => $data
            ]);
        }

        return response()->view("users.list-users", [
            "users" => $users,
            "jabatan" => Jabatan::all(),
            "gudang" => Gudang::all()
        ]);
    }

    public function store(Request $request)
    {
        try{
        $validation = $request->validate([
            "nik" => "required|unique:karyawan",
            "nama" => "required|unique:karyawan",
            "email" => "required|email|unique:karyawan",
            "kontak" => "required|numeric",
            "id_gudang" => "required",
            "id_jabatan" => "required",
            "alamat" => "nullable|max:200",
            "gender" => "required",
            "tanggal_lahir" => "required"
        ]);

        $validation["password"] = Hash::make($request->input('nik'));
        $query = Karyawan::insert($validation);

        if($query) {
            return response()->json([
                "success" => "Data User Berhasil Ditambahkan"
            ]);
        }

    } catch (ValidationException $exception) {

        $errors = $exception->validator->errors()->toArray();

        return response()->json([
            "error" => $errors
        ]);

    }
    }

    public function update(Request $request)
    {
        $user = Karyawan::find($request->input("nik"));
        if($user == null || $user->nik != getNik()) abort(404);

        try {
            $validation = $request->validate([
                'nik' => 'required',
                'nama' => 'required',
                'alamat' => 'nullable',
                'kontak' => 'required|numeric',
                'email' => 'required',
                'gambar_profile' => "image|mimes:jpeg,png,jpg,gif,svg|max:2048",
                'tanggal_lahir' => "required"
            ]);
            // Not Upload Image
            if($request->hasFile("gambar_profile")) {
                $inputFile  = $request->file("gambar_profile");
                  $fileName = $inputFile->getClientOriginalName();
                    if($fileName != $user->gambar_profile) {



                        $imagePath = public_path('storage/profiles/' . $user->gambar_profile);
                        // Memeriksa apakah file ada sebelum dihapus
                        if (File::exists($imagePath) && $user->gambar_profile != "default.png") {
                            // Menghapus file
                            File::delete($imagePath);
                        }

                        $padth = public_path('storage/profiles/' . $fileName);

                        $resizedImage = Image::make($inputFile)->fit(300, 300);

                        $resizedImage->save($padth);

                        $validation["gambar_profile"] = $fileName;
                    } else {
                        // Old Image
                        $validation["gambar_profile"] = $user->gambar_profile;
                    }
                } else {
                    $validation["gambar_profile"] = "default.png";

                    $imagePath = public_path('storage/profiles/' . $user->gambar_profile);
                    // Memeriksa apakah file ada sebelum dihapus
                    if (File::exists($imagePath) && $user->gambar_profile != "default.png") {
                        // Menghapus file
                        File::delete($imagePath);
                    }

                }

                    $user->fill($validation);
                    $user->update();
                if ($user) {
                    return response()->json(["success" => "Success Update {$user->nama}"]);
                }
            } catch (ValidationException $exception) {
                $response = $exception->validator->errors()->toArray();
                return response()->json(["error" => $response]);
            }
    }
}
