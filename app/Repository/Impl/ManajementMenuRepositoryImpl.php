<?php
namespace App\Repository\Impl;

use App\Models\UserAccessMenu;
use App\Models\UserMenu;
use App\Models\UserSubMenu;
use App\Repository\ManajementMenuRepository;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

Class ManajementMenuRepositoryImpl implements ManajementMenuRepository {


    // User Menu 
    public function getDatatablesMenu(): JsonResponse
    {
        return DataTables::of($this->getAllMenu())
                ->addIndexColumn()
                ->addColumn('action', function($menu){
                    
                 return "<a id='' class='hapusProduk btn btn-danger mx-2'><i class='fas fa-trash'></i></a>" . "<a id='' class='hapusProduk btn btn-primary'><i class='fas fa-edit'></i></a>";



                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function getAllMenu()
    {
        return UserMenu::all();
    }

    public function findUserMenu($menu_id)
    {
        $menu = UserMenu::find($menu_id);
        if($menu) {
            return $menu;
        }
        return null;
    }

    public function updateUserMenu($menu_id, array $data)
    {
        $menu = $this->findUserMenu($menu_id);
        
        $menu->fill($data);

        $menu->update();
    }

    public function insertMenu(array $data)
    {
        UserMenu::insert($data);
    }

    // UserSubMenu
    public function getDatatablesSubMenu(): JsonResponse
    {
        return DataTables::of($this->getAllSubMenu())
                ->addIndexColumn()
                ->editColumn('menu', function (UserSubMenu $subMenu) {

                    return $subMenu->menu->nama;

                })
                ->addColumn('is_active', function (UserSubMenu $subMenu) {

                    if($subMenu->is_active) {
                        return '<a class="btn btn-success">Active</a>';
                    }
                    return '<a class="btn btn-danger">Not Active</a>';

                })
                ->addColumn('action', function($sub){
                    
                 return "<a id='' class='hapusProduk btn btn-danger mx-2'><i class='fas fa-trash'></i></a>" . "<a id='' class='hapusProduk btn btn-primary'><i class='fas fa-edit'></i></a>" ;



                })
                ->rawColumns(['action', 'is_active'])
                ->make(true);
    }


    public function getAllSubMenu()
    {
        return UserSubMenu::all();
    }

    public function findUserSubMenu($sub_menu_id)
    {
        $sub_menu = UserSubMenu::find($sub_menu_id);
        if($sub_menu) {
            return $sub_menu;
        }
        return null;
    }

    public function updateUserSubMenu($sub_menu_id, array $data)
    {
        $sub_menu = $this->findUserMenu($sub_menu_id);
        
        $sub_menu->fill($data);

        $sub_menu->update();
    }

    public function insertSubMenu(array $data)
    {
        UserSubMenu::insert($data);
    }

    // UserAccessMenu
    public function insertUserAccessMenu(array $data) 
    {
        UserAccessMenu::insert($data);
    }

    public function findUserAccessMenuBySubAndJabatan($sub_menu_id, $id_jabatan)
    {
        return UserAccessMenu::where("sub_menu_id", $sub_menu_id)->where("id_jabatan", $id_jabatan)->first();
    }

    public function removeUserAccessMenuBySubAndJabatan($sub_menu_id, $id_jabatan)
    {
        $akses = $this->findUserAccessMenuBySubAndJabatan($sub_menu_id, $id_jabatan);
        if($akses) {
            $akses->delete();
            return true;
        }
        return null;
    }
}