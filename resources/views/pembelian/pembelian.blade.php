@extends('template.template')

@section('title')
    Pembelian
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
              <div class="card-header">
                <a href="{{ url("/pembelian/tambah-pembelian") }}" class="btn btn-success" style="float: right;"> <i class="align-middle" data-feather="plus"></i>&nbsp;Add Pembelian</a>
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
                            <label for="exampleInputEmail1">Tanggal Awal</label>
                            <input type="date" class="form-control" id="tanggal_awal" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="tanggal_akhir" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                    </div>
                    <div class="col-md-3" style="margin-top: 1.9rem;">
                        <button class="btn btn-secondary" id="reset">Reset</button>
                        <button class="btn btn-primary" id="serachPembelian">Search</button>
                    </div>
                </div>
                <div class="table-responsive p-2">
                  <table class="table table-striped  align-items-center mb-0 data-pembelian" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th  style="width: 15%;">No Pembelian</th>
                        <th style="width: 15%;">Supplier</th>
                        <th>Tanggal</th>
                        <th>Jumlah Produk</th>
                        <th>Total harga</th>
                        <th>Karywan Input</th>
                        <th style="width: 12%; float:center;">Action</th>
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

            var table = $('.data-pembelian').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url : "/pembelian",
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
                        data: 'no_pembelian',
                        name: 'no_pembelian'
                    },
                    {
                        data: 'supplier',
                        name: 'supplier.nama'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'total_produk',
                        name: 'total_produk'
                    },
                    {
                        data: 'total_keseluruhan',
                        name: 'total_keseluruhan'
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

        function validation(path = null, action = null, callback) {
            let tanggal_awal = $("#tanggal_awal").val();
            let tanggal_akhir = $("#tanggal_akhir").val();

            if((tanggal_awal == "" && tanggal_akhir == "") || (tanggal_awal != "" && tanggal_akhir != ""))  {
                if(action != "search") {
                    if(tanggal_awal == "" && tanggal_akhir == "") {
                        window.location.href = path;
                    } else {
                        window.location.href = path + "?awal=" + tanggal_awal + "&akhir=" + tanggal_akhir;
                    }
                }

                callback();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'error',
                    text: 'tanggal tidak boleh salah satu saja!',
                })
                return false;
            }
        }

        $("#cetak_pdf").on("click", function () {
            validation("/pembelian/print/cetak-laporan");
        });

        $("#export_excel").on("click", function() {
            validation("/pembelian/print/export-excel");
        });

        $("#serachPembelian").on("click", function () {
            validation(null, "search", function() {
                $('.data-pembelian').DataTable().ajax.reload(null, false);
            });
        });

        $("#reset").on("click", function () {
            $("#tanggal_awal").val("");
            $("#tanggal_akhir").val("");

            $('.data-pembelian').DataTable().ajax.reload(null, false);
        });
    </script>
@endpush
