<?php
namespace App\Repository;

use Illuminate\Http\JsonResponse;

interface ManajementMenuRepository {

    // Menu
    public function getDatatablesMenu(): JsonResponse;

    public function getAllMenu();

    public function findUserMenu($menu_id);

    public function updateUserMenu($menu_id, array $data);

    public function insertMenu(array $data);

    // SubMenu
    public function getDatatablesSubMenu(): JsonResponse;

    public function getAllSubMenu();
    
    public function findUserSubMenu($sub_menu_id);
    
    public function updateUserSubMenu($sub_menu_id, array $data);
    
    public function insertSubMenu(array $data);

    // User Access Menu
    public function insertUserAccessMenu(array $data);

    public function findUserAccessMenuBySubAndJabatan($sub_menu_id, $id_jabatan);

    public function removeUserAccessMenuBySubAndJabatan($sub_menu_id, $id_jabatan);
}