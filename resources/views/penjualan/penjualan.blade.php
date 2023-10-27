@extends('template.template')

@section('title')
    Penjualan
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
              <div class="card-header">
                <a href="{{ url("/penjualan/tambah-penjualan") }}" class="btn btn-success" style="float: right;"><i class="align-middle" data-feather="plus"></i>&nbsp;Tambah Penjualan</a>
              </div>
              <div class="card-body pb-2">
                <div class="row mb-2">
                    <div class="col-md-5">
                        <button class="btn btn-success px-3" id="cetak_pdf">PDF</button>
                        <button class="btn btn-warning px-3" id="download_excel">Excel</button>
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
                  <table class="table table-bordered table-striped  align-items-center mb-0 data-penjualan" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th  style="width: 15%;">No Penjualan</th>
                        <th>Customer</th>
                        <th>Tanggal</th>
                        <th>Total Jenis</th>
                        <th>Total Harga</th>
                        <th>Karyawan Input</th>
                        <th>Deskripsi</th>
                        <th style="width: 15%;">Action</th>
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

      var table = $('.data-penjualan').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
              url : "/penjualan",
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
                  data: 'no_penjualan',
                  name: 'no_penjualan'
              },
              {
                  data: 'customer',
                  name: 'customer.nama'
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
            validation("/penjualan/print/cetak-pdf");
        });

        $("#export_excel").on("click", function() {
            validation("/penjualan/print/export-excel");
        });

        $("#serachPembelian").on("click", function () {
            validation(null, "search", function() {
                $('.data-penjualan').DataTable().ajax.reload(null, false);
            });
        });

        $("#reset").on("click", function () {
            $("#tanggal_awal").val("");
            $("#tanggal_akhir").val("");

            $('.data-pembelian').DataTable().ajax.reload(null, false);
        });

        $(".searchAll input").each(function () {
            if($(this).attr('type') == "date") {
                $(this).on("change", function() {
                    $('.data-penjualan').DataTable().ajax.reload(null, false);
                });
            } else {
                $(this).on("keyup", function() {
                    $('.data-penjualan').DataTable().ajax.reload(null, false);
                });
            }
        });



        $(document).on('click', '#delete', function() {
        let no_pembelian = $(this).attr("data-no_pembelian");
        let kode_produk = $(this).attr("data-kode_produk");
            Swal.fire({
                title: 'Apakah Yakin Menghapus?',
                text: "Hapus data kode produk " + kode_produk,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                        url: "/pembelian/" + no_pembelian + "/produk/" + kode_produk,
                        type: "DELETE",
                        success: response => {

                            if(response.success) {
                                Swal.fire({
                                icon: 'success',
                                title: 'success',
                                text:  response["success"],
                            })
                            getDataDetailPembelian();
                        }


                            if(response.error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'error',
                                    text:  response["error"],
                                })
                                getDataDetailPembelian();
                            }
                        }
                    });
                }
            })
        });

        $(document).on("click",".hapusPenjualan", function () {
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
                    url : "/penjualan/" + $(btn).attr("id"),
                    type : "DELETE",
                    dataType : "json",
                    success: response => {
                        if(response["success"]) {
                            Swal.fire({
                                icon: 'success',
                                title: 'success',
                                text:  response["success"]
                            });
                            $('.data-penjualan').DataTable().ajax.reload(null, false);
                        }
                        if(response["error"]) {
                            Swal.fire({
                                icon: 'error',
                                title: 'error',
                                text:  response["error"]
                            });
                            $('.data-penjualan').DataTable().ajax.reload(null, false);
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
