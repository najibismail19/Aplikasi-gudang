@extends('template.template')
@section('title')
    <a href="{{ url("/penjualan") }}" style="float: left;" class="btn btn-warning"><i class="align-middle" data-feather="chevrons-left"></i>&nbsp;Back</a>
@endsection
@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                        <input type="text" class="form-control" id="nama_karyawan" value="{{ $penjualan->karyawan->nama }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="no_penjualan" class="form-label">No Penjualan</label>
                        <input type="text" class="form-control" id="no_penjualan" readonly value="{{ $penjualan->no_penjualan }}">
                    </div>
                    <div class="col-md-3">
                        <label for="tanggal_penjualan" class="form-label">Tanggal</label>
                        <input type="text" class="form-control" id="tanggal_penjualan" value="{{ $tanggal_penjualan }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="nama_customer" class="form-label">Customer</label>
                        <div class="d-flex">
                            <input type="text" class="form-control"  placeholder="Cari Customer..." id="nama_customer" value="{{ $penjualan->customer->nama }}" readonly>
                        </div>
                    </div>
                    <div class="row justify-content-between bg-light" style="margin-top: 2rem; padding-top: 2rem;">
                        <div class="col-md-3">
                            <div class="row justify-content-center data_produk">
                                <h2 >Tambah Penjualan</h2>
                                <div class="mb-3 row">
                                    <button class="btn btn-success col-md-6" id="searchProduk" style="width: 100%"><i data-feather="plus"></i>&nbsp;Cari Produk</button>
                                </div>
                                <div class="mb-3">
                                    <label for="nama_Produk" class="form-label">Kode Produk</label>
                                    <input type="text" id="kode_produk" class="form-control" placeholder="Kode Produk" readonly>
                                    <small class="text-danger error_text kode_produk_error"></small>
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
                                    <input type="text" class="form-control" id="harga" placeholder="Harga" readonly>
                                    <small class="text-danger error_text harga_error"></small>
                                  </div>
                                  <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah" value="1">
                                    <small class="text-danger error_text jumlah_error"></small>
                                  </div>
                                  <div class="mb-3">
                                    <label for="diskon" class="form-label">Diskon</label>
                                    <input type="number" class="form-control" id="diskon" value="0">
                                    <small class="text-danger error_text diskon_error"></small>
                                  </div>
                                  <div class="mb-3">
                                    <label for="total_harga" class="form-label">Total Harga</label>
                                    <input type="text" class="form-control" id="total_harga" placeholder="Total Harga" readonly>
                                    <small class="text-danger error_text total_harga_error"></small>
                                  </div>
                                  <div class="row" id="btn-action-produk">
                                      <button class="btn btn-secondary col-md-5 m-2" id="reset"><i data-feather="refresh-ccw"></i>&nbsp;Reset</button>
                                      <button class="btn btn-primary col-md-5 m-2" id="tambah"><i data-feather="plus"></i>&nbsp;Tambah</button>
                                      <button class="btn btn-primary col-md-5 m-2" id="ubah"><i data-feather="plus"></i>&nbsp;Ubah</button>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h2 style="margin-bottom: 2rem;">Detail Penerimaan</h2>
                            <table class="table table-bordered table-striped align-items-center mb-0" style="width: 100%">
                                <thead>
                                  <tr>
                                    <th  style="width: 15%;">Kode Produk</th>
                                    <th style="width: 15%;">Nama</th>
                                    <th>Jenis</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Diskon</th>
                                    <th>Total Harga</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody id="data-detail-penjualan">
                                    <tr rowSpan="2" style="font: bold; background-color: rgba(154, 194, 196, .8);">
                                        <th colspan="5"></th>
                                        <th>Total</th>
                                        <th id="table_total_keseluruhan" colspan="2"></th>
                                    </tr>
                                </tbody>
                              </table>
                              <div class="row mt-4">
                                <div class="col-md-6">
                                    {{-- <div class="mb-4 row">
                                        <label for="nama_karyawan" class="col-sm-5 col-form-label">Jumlah Jenis Produk*</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" placeholder="Jumlah Produk" id="jumlah_jenis_produk" readonly>
                                        </div>
                                      </div> --}}
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
    getDataDetailPenjualan();

    function getDataDetailPenjualan()
    {
        $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
            url : "/penjualan/" + $("#no_penjualan").val(),
            dataType : "json",
            success: response => {
                $("#data-detail-penjualan tr:not(:last-child)").remove();
                $("#table_total_keseluruhan").text("Rp. " + response.total_keseluruhan);

                // $("#jumlah_jenis_produk").val(response.jumlah_jenis_produk);

                $.each(response.data, function (key, value) {
                    let jenis = (value.jenis_produk == 0) ? "Barang Mentah" : "Barang Jadi" ;
							$('#data-detail-penjualan').prepend(`<tr>
										<td>`+value.kode_produk+`</td>
										<td>`+value.nama_produk+`</td>
										<td>`+ jenis +`</td>
										<td>Rp. `+value.harga+`</td>
										<td><input type="text" class="form-control" style="width:7.5rem;" id="` + value.kode_produk +`" value="` + value.jumlah + `" readonly></td>
										<td>`+value.diskon+`%</td>
										<td>Rp. `+value.total_harga+`</td>
										<td>
                                            <button class="btn-sm btn-danger" id="delete" data-kode_produk=` + value.kode_produk + ` data-no_penjualan=` + value.no_penjualan + `>Delete</button>
                                            <button class="btn-sm btn-primary" id="edit"
                                                data-kode_produk=`+ value.kode_produk +`
                                                data-nama_produk=`+ value.nama_produk +`
                                                data-jenis=`+ value.jenis +`
                                                data-jumlah=`+ value.jumlah +`
                                                data-diskon=`+ value.diskon +`
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


    $(document).on("click", "#tambah", function () {
        makeRequest('/penjualan/produk/create', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content'),
                        'Content-Type' : 'application/json'
                    },
                    body: JSON.stringify({
                        no_penjualan : $("#no_penjualan").val(),
                        kode_produk : $("#kode_produk").val(),
                        jumlah : $("#jumlah").val(),
                        total_harga : $("#total_harga").val(),
                        harga : $("#harga").val(),
                        diskon : $("#diskon").val()
                    })
        })
        .then(response => response.json())
        .then(response => {
            if(response.errors) {
                            let form_produk = $(".data_produk");
                                $.each(response.errors, function (prefix, val) {
                                        $(form_produk).find("#" + prefix + "").addClass("is-invalid");
                                        $(form_produk).find("small." + prefix + "_error").text(val[0]);
                                })
                        }

                        if(response["success"]) {

                            Swal.fire({
                                icon: 'success',
                                title: 'success',
                                text:  response["success"],
                            });

                            getDataDetailPenjualan();
                        }
        });
    });



    $(document).ready(function () {
        // $("#gambar_produk").attr("src", "/storage/photos/produk/default.png");
        $("#ubah").hide();
        // $("#cancel").hide();
// GET Modal Search Item
        $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
            url : "/penjualan/get-modal-produk",
            dataType : "json",
            success: response => {
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



    $(document).on("click", "#edit", function () {
        let kode_produk = $(this).attr("data-kode_produk");
        let nama_produk = $(this).attr("data-nama_produk");
        let jenis = $(this).attr("data-jenis");
        let jumlah = $(this).attr("data-jumlah");
        let harga = $(this).attr("data-harga");
        let diskon = $(this).attr("data-diskon");
        let total_harga = $(this).attr("data-total_harga");

        $("#kode_produk").val(kode_produk);
        $("#jumlah").val(jumlah);
        $("#harga").val(harga);
        $("#total_harga").val(total_harga);
        $("#diskon").val(diskon);

        let input_jenis = (jenis == 0) ? "Barang Mentah" : "Barang Jadi";

        $("#jenis_produk").val(input_jenis);
        $("#nama_produk").val(nama_produk);

        $("#tambah").hide();
        $("#ubah").show();
        $("#searchProduk").hide();
        $(".search-produk").hide();

    });

    $(document).on("click", "#reset", function (e) {
        e.preventDefault();
        refreshUI();
    });

    async function makeRequest(url, configutation) {
        let response = await fetch(url, configutation);
        let data = await response;
        return data;
    }

    $(document).on("click", "#ubah", function (e) {
            makeRequest('/penjualan/detail-penjualan/update', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content'),
                        'Content-Type' : 'application/json'
                    },
                    body: JSON.stringify({
                        no_penjualan : $("#no_penjualan").val(),
                        kode_produk : $("#kode_produk").val(),
                        jumlah : $("#jumlah").val(),
                        total_harga : $("#total_harga").val(),
                        harga : $("#harga").val(),
                        diskon : $("#diskon").val()
                    })
            })
            .then(response => response.json())
            .then(response => {
                if(response.errors) {
                    let form_produk = $(".data_produk");
                        $.each(response.errors, function (prefix, val) {
                                $(form_produk).find("#" + prefix + "").addClass("is-invalid");
                                $(form_produk).find("small." + prefix + "_error").text(val[0]);
                        })
                }

                if(response["success"]) {
                    Swal.fire({
                        icon: 'success',
                        title: 'success',
                        text:  response["success"]
                    })
                    getDataDetailPenjualan();
                    refreshUI();
                }

            })
            .catch(error => console.error('Error:', error));
    });

    $(document).on('click', '#delete', function() {
        let no_penjualan = $(this).attr("data-no_penjualan");
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
                        url: "/penjualan/" + no_penjualan + "/produk/" + kode_produk,
                        type: "DELETE",
                        success: response => {

                            if(response.success) {
                                Swal.fire({
                                icon: 'success',
                                title: 'success',
                                text:  response["success"],
                            })
                            getDataDetailPenjualan();
                        }


                            if(response.error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'error',
                                    text:  response["error"],
                                })
                                getDataDetailPenjualan();
                            }
                        }
                    });
                }
            })
        });

        $(document).on("click","#selesai_transaksi", function () {
        Swal.fire({
            title: 'Apakah Ingin Menyelesaikan Penjualan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Yakin!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                    url : "/penjualan/detail-penjualan",
                    type : "POST",
                    data : {
                        no_penjualan : $("#no_penjualan").val()
                    },
                    dataType : "json",
                    success: response => {
                        console.log(response);
                        if(response.error_stok) {
                                $.each(response.error_stok, function (key, value) {
                                    // $("#qty_"+ value.kode_produk +"").addClass("is-invalid");
                                    $("#"+ value.kode_produk +"").addClass("is-invalid");
                                    $("#"+ value.kode_produk +"").after(`<small class="text-danger">Stok produk kurang</small>`);
                                })
                            }
                        if(response["success"]) {
                            Swal.fire({
                                icon: 'success',
                                title: 'success',
                                text:  response["success"]
                            });
                                window.location.href = "/penjualan";
                        }
                        // if(response["error"]) {
                        //     Swal.fire({
                        //         icon: 'error',
                        //         title: 'error',
                        //         text:  response["error"]
                        //     });
                        // }
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
        $(".data_produk input").removeClass("is-invalid");
        $(".data_produk small").html("");
    }

 function calculate() {
        let harga =  parseInt($("#harga").val());
        let jumlah = parseInt($("#jumlah").val());
        setTimeout(() => {
            $("#total_harga").val(harga * jumlah);
        }, 500);
    }
</script>
@endpush
