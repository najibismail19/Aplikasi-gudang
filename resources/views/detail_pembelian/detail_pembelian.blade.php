@extends('template.template')
@section('title')
    <a href="{{ url("/pembelian") }}" style="float: left;" class="btn btn-warning"><i class="align-middle" data-feather="chevrons-left"></i>&nbsp;Back</a>
@endsection
@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                        <input type="text" class="form-control" id="nama_karyawan" value="{{ $pembelian->karyawan->nama }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="no_pembelian" class="form-label">No Pembelian</label>
                        <input type="text" class="form-control" id="no_pembelian" readonly value="{{ $pembelian->no_pembelian }}">
                    </div>
                    <div class="col-md-3">
                        <label for="tanggal_pembelian" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal_pembelian" value="{{ $tanggal_pembelian }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="nama_supplier" class="form-label">Supplier</label>
                        <div class="d-flex">
                            <input type="text" class="form-control"  placeholder="Cari Supplier..." id="nama_supplier" value="{{ $pembelian->supplier->nama }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-between bg-light" style="margin-top: 2rem; padding-top: 2rem;">
                        <div class="col-md-3">
                            <div class="row justify-content-center">
                                <h2 style="margin-bottom: -.5rem;">Tambah Pembelian</h2>
                                <div class="row g-3 d-flex mb-3 justify-content-between">
                                    <label for="kode_produk" class="form-label" style="margin-bottom: -.5rem;">Kode Produk</label>
                                    <div class="col-md-6">
                                      <input type="text" id="kode_produk" class="form-control" placeholder="Kode Produk" readonly>
                                    </div>
                                    <button class="btn btn-success col-md-6" id="searchProduk"><i data-feather="plus"></i>&nbsp;Cari Produk</button>
                                  </div>
                                <div class="mb-3">
                                    <label for="nama_Produk" class="form-label">Produk</label>
                                    <input type="text" class="form-control" id="nama_produk" placeholder="Nama Produk" readonly>
                                  </div>
                                  <div class="mb-3">
                                    <label for="jenis_produk" class="form-label">Jenis Produk</label>
                                    <input type="text" class="form-control" id="jenis_produk" placeholder="Jenis Produk" readonly>
                                  </div>
                                  <div class="mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" class="form-control" id="harga" placeholder="Harga" readonly>
                                  </div>
                                  <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah" value="0">
                                  </div>
                                  <div class="mb-3">
                                    <label for="total_harga" class="form-label">Total Harga</label>
                                    <input type="text" class="form-control" id="total_harga" placeholder="Total Harga" readonly>
                                  </div>
                                  <div class="row" id="btn-action-produk">
                                      <button class="btn btn-secondary col-md-5 mr-1" id="reset"><i data-feather="refresh-ccw"></i>&nbsp;Reset</button>
                                      <button class="btn btn-primary col-md-5" id="tambah"><i data-feather="plus"></i>&nbsp;Tambah</button>
                                      <button class="btn btn-primary col-md-5" id="ubah"><i data-feather="plus"></i>&nbsp;Ubah</button>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h2 style="margin-bottom: 2rem;">Detail Penerimaan</h2>
                            <table class="table table-striped align-items-center mb-0" style="width: 100%">
                                <thead>
                                  <tr>
                                    <th  style="width: 15%;">Kode Produk</th>
                                    <th style="width: 15%;">Nama</th>
                                    <th>Jenis</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody id="data-detail-pembelian">
                                    <tr rowSpan="2" style="font: bold; background-color: rgba(154, 194, 196, .8);">
                                        <th colspan="4"></th>
                                        <th>Total</th>
                                        <th id="table_total_keseluruhan" colspan="2"></th>
                                    </tr>
                                </tbody>
                              </table>
                              <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="mb-4 row">
                                        <label for="nama_karyawan" class="col-sm-5 col-form-label">Jumlah Jenis Produk*</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" placeholder="Jumlah Produk" id="jumlah_jenis_produk" readonly>
                                        </div>
                                      </div>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-success" style="float: right;" id="selesai_transaksi"><i data-feather="send"></i>&nbsp;Selesai dan sudahi Transaksi</button>
                                </div>
                              </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

</div>

@endsection
@push('script')
<script>
    getDataDetailPembelian();

    function getDataDetailPembelian()
    {
        $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
            url : "/pembelian/" + $("#no_pembelian").val(),
            dataType : "json",
            success: response => {
                console.log(response.data);
                $("#data-detail-pembelian tr:not(:last-child)").remove();
                $("#table_total_keseluruhan").text("Rp. " + response.total_keseluruhan);

                $("#jumlah_jenis_produk").val(response.jumlah_jenis_produk);

                $.each(response.data, function (key, value) {
                    let jenis = (value.jenis_produk == 0) ? "Barang Mentah" : "Barang Jadi" ;
							$('#data-detail-pembelian').prepend(`<tr>
										<td>`+value.kode_produk+`</td>
										<td>`+value.nama_produk+`</td>
										<td>`+ jenis +`</td>
										<td>Rp. `+value.harga+`</td>
										<td>`+value.jumlah+`</td>
										<td>Rp. `+value.total_harga+`</td>
										<td>
                                            <button class="btn-sm btn-danger" id="delete" data-kode_produk=` + value.kode_produk + ` data-no_pembelian=` + value.no_pembelian + `>Delete</button>
                                            <button class="btn-sm btn-primary" id="edit"
                                                data-kode_produk=`+ value.kode_produk +`
                                                data-nama_produk=`+ value.nama_produk +`
                                                data-jenis=`+ value.jenis +`
                                                data-jumlah=`+ value.jumlah +`
                                                data-harga=`+ value.harga +`
                                                data-total_harga=`+ value.total_harga +`
                                            >Edit</button>
                                        </td>
										</tr>`);
				})

            },
            error: function(xhr,textStatus,thrownError) {
            alert(xhr + "\n" + textStatus + "\n" + thrownError);
            }
        });
    }



    $(document).ready(function () {
        // $("#gambar_produk").attr("src", "/storage/photos/produk/default.png");
        $("#ubah").hide();
        // $("#cancel").hide();
// GET Modal Search Item
        $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
            url : "/pembelian/get-modal-produk",
            dataType : "json",
            success: response => {
                console.log(response);
                if(response.success) {
                    $("body").append(response.modal);
                }
            },
            error: function(xhr,textStatus,thrownError) {
            alert(xhr + "\n" + textStatus + "\n" + thrownError);
            }
        });
// End Modal Search Item
    });

    $(document).on("click", "#tambah", function () {
        let kode_produk = $("#kode_produk").val();
        let jumlah = $("#jumlah").val();
        let total_harga = $("total_harga").val();
        let harga = $("#harga").val();
        if($.trim(kode_produk) == "") {
            Swal.fire({
                icon: 'error',
                title: 'error',
                text:  "Kode Produk Tidak Boleh Kosong"
            });
            return false;
        } else if($.trim(jumlah) == "" || $.trim(jumlah) == 0) {
            Swal.fire({
                icon: 'error',
                title: 'error',
                text:  "Jumlah Produk Tidak Boleh Kosong"
            })
            $("#jumlah").addClass("is-invalid");
            $(".jumlah-in-valid").html("please input the quantity");
            return false;
        } else {
        $.ajax({
                headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                url : "/pembelian/produk",
                type : "POST",
                data : {
                    no_pembelian : $("#no_pembelian").val(),
                    kode_produk : $("#kode_produk").val(),
                    jumlah : $("#jumlah").val(),
                    harga : $("#harga").val(),
                    total_harga : $("#total_harga").val()
                },
                dataType : "json",
                success: response => {
                        if(response["success"]) {

                            Swal.fire({
                                icon: 'success',
                                title: 'success',
                                text:  response["success"],
                            });

                            getDataDetailPembelian();
                        }

                        if(response["error"]) {

                            Swal.fire({
                                icon: 'error',
                                title: 'error',
                                text:  response["error"]

                            })

                            getDataDetailPembelian();
                        }
                }, error: function(data){

                var errors = data.responseJSON;
                console.log(errors);

                 errorsHtml = '<div class="alert alert-danger"><ul>';

                 $.each( errors.error, function( key, value ) {
                      errorsHtml += '<li>'+ value[0] + '</li>';
                 });
                 errorsHtml += '</ul></div>';

                 $( '#form-errors' ).html( errorsHtml );
            }
            });
        }
    });

    $(document).on("click", "#edit", function () {
        let kode_produk = $(this).attr("data-kode_produk");
        let nama_produk = $(this).attr("data-nama_produk");
        let jenis = $(this).attr("data-jenis");
        let jumlah = $(this).attr("data-jumlah");
        let harga = $(this).attr("data-harga");
        let total_harga = $(this).attr("data-total_harga");

        $("#kode_produk").val(kode_produk);
        $("#jumlah").val(jumlah);
        $("#harga").val(harga);
        $("#total_harga").val(total_harga);

        let input_jenis = (jenis == 0) ? "Barang Mentah" : "Barang Jadi";

        $("#jenis_produk").val(input_jenis);
        $("#nama_produk").val(nama_produk);

        // $("#btn-produk").addClass("d-flex justify-content-center");
        // $("#btn-produk  button").addClass("col-md-5 mx-1");
        $("#tambah").hide();
        $("#ubah").show();
        $("#searchProduk").hide();
        $(".search-produk").hide();

        // let file_gambar = ($.trim(gambar) != "") ? gambar : "default.png";
        // $("#gambar_produk").attr("src", "/storage/photos/produk/" + file_gambar);
    });

    $(document).on("click", "#reset", function (e) {
        e.preventDefault();
        refreshUI();
    });

    $(document).on("click", "#ubah", function (e) {
        // e.preventDefault();
        let kode_produk = $("#kode_produk").val();
        let jumlah = $("#jumlah").val();
        let total_harga = $("#total_harga").val();
        let harga = $("#harga").val();
        if($.trim(kode_produk) == "") {
            Swal.fire({
                icon: 'error',
                title: 'error',
                text:  "Kode Produk Tidak Boleh Kosong!"
            })
            return false;
        } else if($.trim(jumlah) == "" || $.trim(jumlah) == 0) {
            Swal.fire({
                icon: 'error',
                title: 'error',
                text:  "Jumlah tidak boleh kosong!"
            })
            $("#jumlah").addClass("is-invalid");
            $(".jumlah-in-valid").html("please input the quantity");
            return false;
        } else{
            $.ajax({
                headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                url : "/pembelian/detail-pembelian/update",
                type : "POST",
                data : {
                    no_pembelian : $("#no_pembelian").val(),
                    kode_produk : $("#kode_produk").val(),
                    jumlah : $("#jumlah").val(),
                    harga : $("#harga").val(),
                    total_harga : $("#total_harga").val()
                },
                dataType : "json",
                success: response => {

                        if(response["success"]) {
                            Swal.fire({
                                icon: 'success',
                                title: 'success',
                                text:  response["success"]
                            })
                            getDataDetailPembelian();
                            refreshUI();
                        }

                        if(response["error"]) {
                            Swal.fire({
                                icon: 'error',
                                title: 'error',
                                text:  response["error"]
                            });
                            getDataDetailPembelian();
                            refreshUI();
                        }
                },
                error: function(xhr,textStatus,thrownError) {
                alert(xhr + "\n" + textStatus + "\n" + thrownError);
                }
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

        $(document).on("click","#selesai_transaksi", function () {
        Swal.fire({
            title: 'Apakah Ingin Menyelesaikan Pembelian?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Yakin!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                    url : "/pembelian/detail-pembelian",
                    type : "POST",
                    data : {
                        no_pembelian : $("#no_pembelian").val()
                    },
                    dataType : "json",
                    success: response => {
                        if(response["success"]) {
                            Swal.fire({
                                icon: 'success',
                                title: 'success',
                                text:  response["success"]
                            });
                                window.location.href = "/pembelian";
                        }
                        if(response["error"]) {
                            Swal.fire({
                                icon: 'error',
                                title: 'error',
                                text:  response["error"]
                            });
                        }
                    },
                    error: function(xhr,textStatus,thrownError) {
                    alert(xhr + "\n" + textStatus + "\n" + thrownError);
                    }
                });
            }
            })
    });

    function refreshUI()
    {
        $("#kode_produk").val("");
        $("#nama_produk").val("");
        $("#jenis_produk").val("-");
        $("#jumlah").val("");
        $("#harga").val("");
        $("#total_harga").val("");
        $("#tambah").show();
        $("#ubah").hide();
        $("#searchProduk").show();
        // $("#image_item").attr("src", "/storage/photos/produk/default.png");
    }

//     $(document).on("click", "#cancel", function () {
//         refreshUI();
//     });
</script>
@endpush
