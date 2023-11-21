<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Repository\ManajementMenuRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ManajementMenuController extends Controller
{

    private ManajementMenuRepository $manajementMenu;

    public function __construct(ManajementMenuRepository $manajementMenu)
    {
        $this->manajementMenu = $manajementMenu;
    }

    // Menu
    public function menu() : Response
    {
        return response()->view("manajement-menu.menu.menu", [
            "title" => "Menu | Manajement"
        ]);
    }

    public function getDataMenu(Request $request)
    {
        if($request->ajax()) {
            return $this->manajementMenu->getDatatablesMenu();
        }
    }
   
    // SubMenu
    public function subMenu() : Response
    {
        return response()->view("manajement-menu.sub-menu.sub-menu", [
            "title" => "Sub Menu | Manajement"
        ]);
    }

    public function getDataSubMenu(Request $request)
    {
        if($request->ajax()) {
            return $this->manajementMenu->getDatatablesSubMenu();
        }
    }

    // UserAccessMenu
    public function userAccessMenu() : Response
    {
        return response()->view("manajement-menu.user-access-menu.user-access-menu", [
            "jabatan" => Jabatan::all()
        ]);
    }

    public function showUserAccessMenu($id_jabatan) : Response
    {
        return response()->view("manajement-menu.user-access-menu.show-user-access-menu", [
            "jabatan" => Jabatan::find($id_jabatan),
            "sub_menu" => $this->manajementMenu->getAllSubMenu()
        ]);
    }
    
    public function storeUserAccessMenu(Request $request)
    {
        if($request->ajax()) {
            if(!$request->has("id_jabatan") || !$request->has("sub_menu_id")) {
                return response()->json([
                    "failed" => "Gagal Meng Update Data Aksess User"
                ]);
            }
            $this->manajementMenu->insertUserAccessMenu([
                "id_jabatan" => $request->input("id_jabatan"),
                "sub_menu_id" => $request->input("sub_menu_id")
            ]);

            return response()->json([
                "success" => "Success Menambahkan Akses User"
            ]);
        }
    }
    
    public function removeUserAccessMenu(Request $request)
    {
        if($request->ajax()) {
            if(!$request->has("id_jabatan") || !$request->has("sub_menu_id")) {
                return response()->json([
                    "failed" => "Gagal Meng Update Data Aksess User"
                ]);
            }
            $removeAkses = $this->manajementMenu->removeUserAccessMenuBySubAndJabatan($request->input("sub_menu_id"), $request->input("id_jabatan"));
            if(!$removeAkses) {
                return response()->json([
                    "failed" => "Gagal Meng Update Data Aksess User"
                ]);
            }
            return response()->json([
                "success" => "Success Menghapus Akses User"
            ]);
        }
    }
}
