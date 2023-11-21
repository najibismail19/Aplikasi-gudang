<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

    function generateNo($code, $table)
    {
        $time = explode("-", date("Y-m-d"));
        $time = implode($time);
        $time = substr($time, 2, 6);
        $result = DB::table($table)
             ->select(DB::raw('substr(no_'. $table .', 4, 6) as no, no_' . $table))
             ->where(DB::raw('substr(no_' . $table . ', 4, 6)'), "=", $time)
             ->orderBy("create_at", "desc")
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

    function getIdGudang() {
        return Auth::guard("karyawan")->user()->id_gudang;
    }

    function getNamaKaryawan(){
        return Auth::guard("karyawan")->user()->nama;
    }

    function getNik(){
        return Auth::guard("karyawan")->user()->nik;
    }

    function downloadExcel(array $columns, $callback, $nameFile) {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getDefaultRowDimension()->setRowHeight(20);
        $highestColumn = $sheet->getHighestColumn();


        foreach($columns as $colum => $name_colum) {
            $spreadsheet->getActiveSheet()->getColumnDimension($colum)->setWidth(20);

            $sheet->setCellValue($colum . '1', $name_colum);
        }


        $alignment_center = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER;

        foreach($sheet->getRowIterator() as $row) {
            foreach($row->getCellIterator() as $cell) {
                $cellCoordinate = $cell->getCoordinate();
                $sheet->getStyle($cellCoordinate)->getAlignment()->setHorizontal($alignment_center);
            }
        }

        $raws = 2;
        $callback($raws, $sheet);

        $fileName = "emp.xls";
        $writer = new Xls($spreadsheet);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. $nameFile .'".xls"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }


    function checkUrl($subMenu) {
        foreach($subMenu as $m) {
        $urlFull = $m->url;
        $arrUrl = explode('/', $urlFull);
        if(request()->segment(1) == $arrUrl[1]) {
        return "menu-open";
        }
    }
    }
?>
