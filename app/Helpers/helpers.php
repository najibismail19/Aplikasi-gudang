<?php

use Illuminate\Support\Facades\DB;

    function generateNo($code, $table)
    {
        $time = explode("-", date("Y-m-d"));
        $time = implode($time);
        $time = substr($time, 2, 6);
        $result = DB::table($table)
             ->select(DB::raw('substr(no_'. $table .', 4, 6) as no, no_' . $table))
             ->where(DB::raw('substr(no_' . $table . ', 4, 6)'), "=", $time)
             ->first();
        if($result != null) {
            $get_colum = "no_" . $table;
            $no = (int) substr($result->$get_colum, 9, 4);
            $no++;
            $generateNO = $code . $time .  sprintf("%04s", $no);
        } else {
            $generateNO = $code . $time . "0001";
        }
        return $generateNO;
    }
?>
