@extends('template.template')

@section('title')
    Prakitan
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
              <div class="card-header">
                <a href="{{ url("/prakitan/tambah-prakitan") }}" class="btn btn-success"> <i class="align-middle" data-feather="plus"></i>&nbsp;Add Prakitan</a>
              </div>
              <div class="card-body pb-2">
                <div class="row mb-2">
                    <div class="col-md-5">
                        <button class="btn btn-success px-3" id="cetak_pdf">PDF</button>
                        <button class="btn btn-warning px-3" id="export_excel">Excel</button>
                    </div>
                </div>
                <div class="row input_tanggal">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal Awal <small> (Actual)</small></label>
                            <input type="date" class="form-control" id="tanggal_awal" name="awal">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal Akhir<small> (Actual)</small></label>
                            <input type="date" class="form-control" id="tanggal_akhir" name="akhir">
                        </div>
                    </div>
                </div>
                <div class="table-responsive p-2">
                  <table class="table table-striped  align-items-center mb-0 data-prakitan" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th  style="width: 15%;">No Prakitan</th>
                        <th style="width: 15%;">Kode Produk</th>
                        <th>Tanggal Rencana</th>
                        <th>Qty rencana</th>
                        <th>Tanggal Aktuan</th>
                        <th>Qty hasil</th>
                        <th>Nama Karyawan</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
@endsection


@push('script')
    <script>

$(function () {

var table = $('.data-prakitan').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url : "/prakitan",
        data : function (d) {
                        d.awal = $('#tanggal_awal').val()
                        d.akhir = $('#tanggal_akhir').val()
                    }
    },
    columns: [
        {
            "data": 'DT_RowIndex',
            orderable: false,
            searchable: false
        },
        {
            data: 'no_prakitan',
            name: 'no_prakitan'
        },
        {
            data: 'kode_produk',
            name: 'kode_produk'
        },
        {
            data: 'tanggal_rencana',
            name: 'tanggal_rencana'
        },
        {
            data: 'qty_rencana',
            name: 'qty_rencana'
        },
        {
            data: 'tanggal_actual_prakitan',
            name: 'tanggal_actual_prakitan'
        },
        {
            data: 'qty_hasil',
            name: 'qty_hasil'
        },
        {
            data: 'karyawan',
            name: 'karyawan.nama'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        },
    ],
    drawCallback: function( settings ) {
        feather.replace();
    }
});
});

function validation(path) {
            let tanggal_awal = $("#tanggal_awal").val();
            let tanggal_akhir = $("#tanggal_akhir").val();

            if((tanggal_awal == "" && tanggal_akhir == "") || (tanggal_awal != "" && tanggal_akhir != ""))  {
                    let string_query_param = "?";
                    $(".input_tanggal input").each(function () {
                        if($.trim($(this).val()) != "") {
                                string_query_param  += $.trim($(this).attr("name")) + "="  + $.trim($(this).val()) + "&";
                        }
                    });

                    let query_param = string_query_param.slice(0, -1);

                    window.location.href = path + query_param;

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'error',
                    text: 'tanggal tidak boleh salah satu saja!',
                })
                return false;
            }
        }

        $("#export_excel").on("click", function () {
            validation("/prakitan/print/export-excel");
        });

        $("#cetak_pdf").on("click", function () {
            validation("/prakitan/print/cetak-laporan");
        });


        $(".input_tanggal input").each(function (){
            $(this).on("change", function () {
                $('.data-prakitan').DataTable().ajax.reload(null, false);
            });
        });

        $("#reset").on("click", function () {
            $("#tanggal_awal").val("");
            $("#tanggal_akhir").val("");

            $('.data-kartu-stok').DataTable().ajax.reload(null, false);
        });

    </script>

@endpush
