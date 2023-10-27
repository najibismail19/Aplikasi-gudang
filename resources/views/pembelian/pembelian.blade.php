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
                <div class="row input_tanggal searchAll">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal Awal</label>
                            <input type="date" class="form-control" id="tanggal_awal" name="awal">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="tanggal_akhir" name="akhir">
                        </div>
                    </div>
                </div>
                <div class="table-responsive p-2">
                  <table class="table table-bordered table-striped align-items-center mb-0 data-pembelian" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th  style="width: 15%;">No Pembelian</th>
                        <th style="width: 15%;">Supplier</th>
                        <th>Tanggal</th>
                        <th>Jumlah Jenis</th>
                        <th>Total harga</th>
                        <th>Karywan Input</th>
                        <th>Status</th>
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
                        data: 'total_harga',
                        name: 'total_harga'
                    },
                    {
                        data: 'karyawan',
                        name: 'karyawan.nama'
                    },
                    {
                        data: 'status',
                        name: 'status'
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



        $(".searchAll input").each(function () {
            if($(this).attr('type') == "date") {
                $(this).on("change", function() {
                    $('.data-pembelian').DataTable().ajax.reload(null, false);
                });
            } else {
                $(this).on("keyup", function() {
                    $('.data-pembelian').DataTable().ajax.reload(null, false);
                });
            }
        });


        $(document).on("click",".deletePembelian", function () {
            let btn = $(this);
        Swal.fire({
            title: 'Apakah Yakin Ingin  Menghapus?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                    url : "/pembelian/" + $(btn).attr("id"),
                    type : "DELETE",
                    dataType : "json",
                    success: response => {
                        if(response["success"]) {
                            Swal.fire({
                                icon: 'success',
                                title: 'success',
                                text:  response["success"]
                            });
                            $('.data-pembelian').DataTable().ajax.reload(null, false);
                        }
                        if(response["error"]) {
                            Swal.fire({
                                icon: 'error',
                                title: 'error',
                                text:  response["error"]
                            });
                            $('.data-pembelian').DataTable().ajax.reload(null, false);
                        }
                    },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            console.log("Error Thrown: " + errorThrown);
                            console.log("Text Status: " + textStatus);
                            console.log("XMLHttpRequest: " + XMLHttpRequest);
                            console.warn(XMLHttpRequest.responseText)
                    }
                });
            }
            })
    });
    </script>
@endpush
