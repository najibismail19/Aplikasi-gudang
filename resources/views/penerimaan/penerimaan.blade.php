@extends('template.template')

@section('title')
    Penerimaan
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
              <div class="card-header">
                <a href="{{ url("/penerimaan/tambah-penerimaan") }}" class="btn btn-success" style="float: right;"><i class="align-middle" data-feather="plus"></i>&nbsp;Tambah Penerimaan</a>
              </div>
              <div class="card-body pb-2">
                <div class="row mb-2">
                    <div class="col-md-5">
                        <button class="btn btn-success px-3" id="cetak_pdf">PDF</button>
                        <button class="btn btn-warning px-3" id="download_excel">Excel</button>
                        <button class="btn btn-primary px-3">Word</button>
                    </div>
                </div>
                <div class="row">
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
                        <button class="btn btn-primary" id="searchPenerimaan">Search</button>
                    </div>
                </div>
                <div class="table-responsive p-2">
                  <table class="table align-items-center mb-0 data-penerimaan" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th  style="width: 15%;">No Penerimaan</th>
                        <th>Penerima</th>
                        <th>Tanggal </th>
                        <th style="width: 15%;">No Pembelian</th>
                        <th>Deskripsi</th>
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

            var table = $('.data-penerimaan').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url : "/penerimaan",
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
                        data: 'no_penerimaan',
                        name: 'no_penerimaan'
                    },
                    {
                        data: 'karyawan',
                        name: 'karyawan.nama'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'no_pembelian',
                        name: 'no_pembelian'
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi'
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
            validation("/penerimaan/print/cetak-laporan");
        });

        $("#download_excel").on("click", function() {
            validation("/penerimaan/print/export-excel");
        });

        $("#searchPenerimaan").on("click", function () {
            validation(null, "search", function() {
                $('.data-penerimaan').DataTable().ajax.reload(null, false);
            });
        });

        $("#reset").on("click", function () {
            $("#tanggal_awal").val("");
            $("#tanggal_akhir").val("");

            $('.data-penerimaan').DataTable().ajax.reload(null, false);
        });
    </script>
@endpush
