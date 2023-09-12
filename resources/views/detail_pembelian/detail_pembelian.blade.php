@extends('template.template')
@section('content')
<div class="container-fluid p-0">
    <div class="row">
        <div class="col-md-6">
            <h1 class="h3 mb-3"><strong>No</strong> Pembelian &nbsp;:&nbsp;<span id="no_pembelian">{{ $pembelian->no_pembelian }}</span></h1>
        </div>
        <div class="col-md-6">
            <a href="{{ url("/pembelian") }}" style="float: right;" class="btn btn-warning"><i class="align-middle" data-feather="chevrons-left"></i>&nbsp;Back</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-xl-6 col-xxl-5 d-flex">
                    <div class="w-100">
                        <div class="row">
							<div class="card">
								<div class="card-body">
                                      <div class="mb-3 row">
                                        <label for="nama_karyawan" class="col-sm-4 col-form-label">Karyawan Input*</label>
                                        <div class="col-sm-8">
                                            <input type="hidden" name="nik" id="nik">
                                          <input type="text" class="form-control" placeholder="Name" id="nama_karyawan" value="{{ $pembelian->karyawan->nama }}" readonly>
                                        </div>
                                      </div>
                                      <div class="mb-3 row">
                                        <label for="supplier" class="col-sm-4 col-form-label">Supplier*</label>
                                        <div class="col-sm-8 d-flex">
                                            <input type="text" class="form-control" placeholder="Supplier" id="id_supplier" name="id_supplier" value="{{ $pembelian->supplier->nama }}" readonly>
                                        </div>
                                      </div>
                                      <div class="mb-3 row">
                                        <label for="date" class="col-sm-4 col-form-label">Tanggal Pembelian*</label>
                                        <div class="col-sm-8">
                                            <input id="tanggal_pembelian" type="date" class="form-control" name="tanggal_pembelian" value="{{ $tanggal_pembelian }}" readonly/>
                                        </div>
                                      </div>
                                      <div class="mb-3 row">
                                        <label for="deskripsi" class="col-sm-4 col-form-label">Deskripsi</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" placeholder="Deskripsi..." name="deskripsi"  id="deskripsi" style="height: 100px" readonly>{{ $pembelian->deskripsi  }}</textarea>
                                        </div>
                                      </div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-xxl-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="my-2 row">
                                        <label for="quantity" class="col-sm-6">Kode Produk*</label>
                                        <div class="col-sm-6">
                                            <input type="hidden" id="kode_produk" name="kode_produk">
                                            <input type="text" class="form-control" placeholder="Kode Produk" id="input_kode_produk" readonly>
                                        </div>
                                    </div>
                                    <div class="my-2 row">
                                        <label for="nama_produk" class="col-sm-6">Nama*</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" placeholder="Nama Produk" id="nama_produk" name="nama_produk" readonly>
                                        </div>
                                    </div>
                                    <div class="my-2 row">
                                        <label for="harga" class="col-sm-6">Harga*</label>
                                        <div class="col-sm-6">
                                            <input type="number" class="form-control" id="harga" name="harga" value="0" readonly>
                                        </div>
                                    </div>
                                    <div class="my-2 row">
                                        <label for="jenis" class="col-sm-6">Jenis*</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="jenis" name="jenis" value="0" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label for="jumlah" class="col-sm-6">Jumlah*</label>
                                        <div class="col-sm-6">
                                            <input type="number" class="form-control"  id="jumlah" name="jumlah" value="1">
                                            <small class="text-danger jumlah-in-valid"></small>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mb-2 mt-2 row">
                                        <label for="total_harga" class="col-sm-6">Total Harga*</label>
                                        <div class="col-sm-6">
                                            <input type="number" class="form-control" placeholder="Total Harga" id="total_harga" name="total_harga" readonly>
                                        </div>
                                    </div>

                                    <div class="mt-2 mb-1 row" id="btn-produk">
                                        <button class="btn btn-primary" id="save">Save</button>
                                        <button class="btn btn-secondary" id="cancel">Cancel</button>
                                        <button class="btn btn-primary" id="update">Update</button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="img h-75">
                                        <img src="" alt="" style="width : 100%;height : 100%;" alt="Gambar Produk" id="gambar_produk">
                                    </div>
                                    <div class="input-group my-3 search-produk">
                                        <input type="text" class="form-control" placeholder="Search Item..." id="inputSearchItem" readonly>
                                        <button class="btn btn-primary" id="searchProduk" ><i class="align-middle" data-feather="search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                      <div class="card-header">
                        <table class="table align-items-center mb-0" style="width: 40%;">
                            <tr>
                                <th>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text" id="inputGroup-sizing-lg">Total Keseluruhan</span>
                                        <input type="text" class="form-control" placeholder="Grand Total" id="total_keseluruhan" readonly>
                                      </div>
                                    {{-- <td><h3>Rp</h3></td> --}}
                                    {{-- <input type="text" class="form-control" placeholder="Grand Total" id="grand_total" readonly> --}}
                                    {{-- <td><h3>3000000</h3></td> --}}
                                </th>
                            </tr>
                        </table>
                        <button class="btn-lg btn-success" id="selesai_pembelian" style="float: right;"><i class="align-middle" data-feather="shopping-cart"></i>&nbsp;Selesai Pembelian</button>
                      </div>
                      <div class="card-body pb-2">
                        <div class="table-responsive p-2">
                          <table class="table align-items-center mb-0 data-detail-pembelian" style="width: 100%;">
                            <thead>
                              <tr>
                                <th style="width: 7%;">No</th>
                                <th>Code Item</th>
                                <th>Name</th>
                                <th>quantity</th>
                                <th>Price</th>
                                <th>Total</th>
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
        </div>
    </div>

</div>

@endsection
@push('script')
<script>
     $(function () {
      let no_pembelian = $("#no_pembelian").text();
      var table = $('.data-detail-pembelian').DataTable({
          processing: true,
          serverSide: true,
          ajax: "/pembelian/" + no_pembelian,
          columns: [
            {
                "data": 'DT_RowIndex',
                 orderable: false,
                 searchable: false
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
                data: 'jumlah',
                name: 'jumlah'
            },
            {
                data: 'harga',
                name: 'harga'
            },
            {
                data: 'total_harga',
                name: 'total_harga'
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
    $(document).ready(function () {
        $("#update").hide();
        $("#cancel").hide();
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

    $(document).on("click", "#save", function () {
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
                    no_pembelian : $("#no_pembelian").text(),
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
                                refreshUI();
                                $("#total_keseluruhan").val(reponse["total_keseluruhan"]);
                                $('.data-detail-pembelian').DataTable().ajax.reload(null, false);
                        }

                        if(response["error"]) {

                            Swal.fire({
                                icon: 'error',
                                title: 'error',
                                text:  response["error"]

                            })
                            refreshUI();
                            $('.data-detail-pembelian').DataTable().ajax.reload(null, false);
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

    $(document).on("click", ".editDetailPembelian", function () {
        let kode_produk = $(this).attr("data-kode_produk");
        let nama_produk = $(this).attr("data-nama_produk");
        let jenis = $(this).attr("data-jenis");
        let jumlah = $(this).attr("data-jumlah");
        let harga = $(this).attr("data-harga");
        let total_harga = $(this).attr("data-total_harga");
        let gambar = $(this).attr("data-gambar");

        $("#input_kode_produk").val(kode_produk);
        $("#kode_produk").val(kode_produk);
        $("#jumlah").val(jumlah);
        $("#harga").val(harga);
        $("#total_harga").val(total_harga);

        let input_jenis = (jenis == 0) ? "Barang Mentah" : "Barang Jadi";

        $("#jenis").val(input_jenis);
        $("#nama_produk").val(nama_produk);
        $("#btn-produk").addClass("d-flex justify-content-center");
        $("#btn-produk  button").addClass("col-md-5 mx-1");
        $("#save").hide();
        $("#update").show();
        $("#cancel").show();
        $(".search-produk").hide();

        let file_gambar = ($.trim(gambar) != "") ? gambar : "default.png";
        $("#gambar_produk").attr("src", "/storage/photos/produk/" + file_gambar);
    });

    $(document).on("click", "#update", function (e) {
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
                url : "/pembelian/" + $("#no_pembelian").text() + "/produk/" + kode_produk,
                type : "POST",
                data : {
                    no_pembelian : $("#no_pembelian").text(),
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
                            $("#total_keseluruhan").val(response["total_keseluruhan"]);
                            $('.data-detail-pembelian').DataTable().ajax.reload(null, false);
                            refreshUI();
                        }

                        if(response["error"]) {
                            Swal.fire({
                                icon: 'error',
                                title: 'error',
                                text:  response["error"]
                            });
                            $('.data-detail-pembelian').DataTable().ajax.reload(null, false);
                            refreshUI();
                        }
                },
                error: function(xhr,textStatus,thrownError) {
                alert(xhr + "\n" + textStatus + "\n" + thrownError);
                }
            });
        }
    });

    $(document).on('click', '.hapusDetailPembelian', function() {
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
                                 $('.data-detail-pembelian').DataTable().ajax.reload(null, false);
                            }

                            if(response.error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'error',
                                    text:  response["error"],
                                })
                                    $('.data-detail-pembelian').DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            })
        });

        $(document).on("click","#selesai_pembelian", function () {
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
                        no_pembelian : $("#no_pembelian").text()
                    },
                    dataType : "json",
                    success: response => {
                        if(response["success"]) {
                            Swal.fire({
                                icon: 'success',
                                title: 'success',
                                text:  response["success"]
                            });
                            setTimeout(() => {
                                window.location.href = "/pembelian";
                            }, 2500);
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
        $("#input_kode_produk").val("");
        $("#nama_produk").val("");
        $("#jenis").val("-");
        $("#jumlah").val("");
        $("#harga").val("");
        $("#total_harga").val("");
        $("#btn-produk  button").removeClass("col-md-5 mx-1");
        $("#save").show();
        $("#update").hide();
        $("#cancel").hide();
        $(".search-produk").show();
        $("#image_item").attr("src", "/storage/photos/produk/default.png");
    }

    $(document).on("click", "#cancel", function () {
        refreshUI();
    });
</script>
@endpush
