@extends('template.template')

@section('title')
    Kartu Stok
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
              <div class="card-header">
                  <div class="row mb-2">

                  </div>
                  <div class="row searchAll">
                      <div class="row align-items-center">
                          <div class="col-md-2">
                              <div class="form-group">
                                  <label for="tanggal_awal">Tanggal Awal</label>
                                  <input type="date" class="form-control" id="tanggal_awal" name="awal">
                              </div>
                          </div>
                          <div class="col-md-2">
                              <div class="form-group">
                                  <label for="tanggal_akhir">Tanggal Akhir</label>
                                  <input type="date" class="form-control" id="tanggal_akhir" name="akhir">
                              </div>
                          </div>
                          <div class="col-md-2">
                              <div class="form-group">
                                  <label for="exampleInputEmail1">By Gudang</label>
                                  <select class="custom-select" id="id_gudang" name="gudang">
                                        <option selected value="all">Semua Gudang</option>
                                        @foreach ($gudang as $g)
                                            <option value="{{ $g->id_gudang }}">{{ $g->nama_gudang }}</option>
                                        @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                                <label for="no_referensi">No Referensi</label>
                                <input type="text" placeholder="No Referensi" class="form-control" id="no_referensi" name="no_referensi">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="kode_produk">Kode Produk</label>
                                <input type="text" placeholder="Kode Produk" class="form-control" id="kode_produk" name="kode_produk">
                            </div>
                        </div>
                        <div class="col-md-2 mt-3">
                            <button class="btn btn-success px-3" id="cetak_pdf">PDF</button>
                            <button class="btn btn-warning px-3" id="export_excel">Excel</button>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="card-body pb-2">
                <div class="table-responsive p-2">
                  <table class="table table-bordered table-striped align-items-center mb-0 data-kartu-stok" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th>No Referensi</th>
                        <th>Gudang</th>
                        <th>Kode Produk</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Saldo Awal</th>
                        <th>Stok In</th>
                        <th>Stok Out</th>
                        <th>Saldo Akhir</th>
                        <th>Tanggal</th>
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

            var table = $('.data-kartu-stok').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url : "/kartu-stok",
                    data : function (d) {
                        d.awal = $('#tanggal_awal').val(),
                        d.akhir = $('#tanggal_akhir').val(),
                        d.id_gudang = $('#id_gudang').val(),
                        d.no_referensi = $('#no_referensi').val(),
                        d.kode_produk = $('#kode_produk').val()
                    }
                },
                columns: [
                    {
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'no_referensi',
                        name: 'no_referensi'
                    },
                    {
                        data: 'gudang',
                        name: 'gudang.nama'
                    },
                    {
                        data: 'kode_produk',
                        name: 'kode_produk'
                    },
                    {
                        data: 'nama_produk',
                        name: 'produk.nama'
                    },
                    {
                        data: 'jenis_produk',
                        name: 'produk.jenis_produk'
                    },
                    {
                        data: 'saldo_awal',
                        name: 'saldo_awal'
                    },
                    {
                        data: 'stock_in',
                        name: 'stock_in'
                    },
                    {
                        data: 'stock_out',
                        name: 'stock_out'
                    },
                    {
                        data: 'saldo_akhir',
                        name: 'saldo_akhir'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                ]
            });
        });

        function validation(path) {
            let tanggal_awal = $("#tanggal_awal").val();
            let tanggal_akhir = $("#tanggal_akhir").val();

            if((tanggal_awal == "" && tanggal_akhir == "") || (tanggal_awal != "" && tanggal_akhir != ""))  {
                    let string_query_param = "?";
                    $(".searchAll input").each(function () {
                        if($.trim($(this).val()) != "") {
                                string_query_param  += $.trim($(this).attr("name")) + "="  + $.trim($(this).val()) + "&";
                        }
                    });

                    let id_gudang = $("#id_gudang");
                    if($(id_gudang).val() != "all") {
                        string_query_param  += $.trim($(id_gudang).attr("name")) + "=" + $.trim($(id_gudang).val()) + "&";
                    }

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
            validation("/kartu-stok/print/export-excel");
        });

        $("#cetak_pdf").on("click", function () {
            validation("/kartu-stok/print/cetak-laporan");
        });

        $("#reset").on("click", function () {
            $("#tanggal_awal").val("");
            $("#tanggal_akhir").val("");

            $('.data-kartu-stok').DataTable().ajax.reload(null, false);
        });

        $(".searchAll input").each(function () {
            if($(this).attr('type') == "date") {
                $(this).on("change", function() {
                    $('.data-kartu-stok').DataTable().ajax.reload(null, false);
                });
            } else {
                $(this).on("keyup", function() {
                    $('.data-kartu-stok').DataTable().ajax.reload(null, false);
                });
            }
        });

        $("#id_gudang").on("change", function () {
            $('.data-kartu-stok').DataTable().ajax.reload(null, false);
        });

    </script>
@endpush
