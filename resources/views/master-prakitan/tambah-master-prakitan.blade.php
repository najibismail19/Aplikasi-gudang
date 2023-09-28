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
                    <div class="row" id="inputProdukJadi">
                        <div class="col-md-3">
                            <label for="kode_produk_jadi" class="form-label">Kode Produk Jadi*</label>
                            <input type="text" class="form-control" id="kode_produk_jadi" placeholder="Kode Produk Jadi..." readonly>
                            <small class="text-danger error_text kode_produk_jadi_error"></small>
                        </div>
                        <div class="col-md-3">
                            <label for="nama_produk_jadi" class="form-label">Nama Produk Jadi*</label>
                            <input type="text" class="form-control" id="nama_produk_jadi" readonly placeholder="Nama Produk Jadi...">
                            <small class="text-danger error_text kode_produk_jadi_error"></small>
                        </div>
                        <div class="col-md-3">
                            <label for="jenis_produk_jadi" class="form-label">Jenis Produk</label>
                            <input type="text" class="form-control" id="jenis_produk_jadi" placeholder="Jenis Produk..." readonly>
                            <small class="text-danger error_text kode_produk_jadi_error"></small>
                        </div>
                        <div class="col-md-3">
                            <label for="satuan_produk_jadi" class="form-label">Satuan</label>
                            <input type="text" class="form-control"  placeholder="Cari Produk..." id="satuan_produk_jadi" readonly>
                            <small class="text-danger error_text kode_produk_jadi_error"></small>
                        </div>
                    </div>
                    <div class="row justify-content-between bg-light data-detail-prakitan" style="margin-top: 2rem; padding-top: 2rem;">

                        <div class="col-md-3">
                            <div class="row justify-content-center inputProdukMentah data_produk">
                                <h2>Tambah Produk</h2>
                                <div class="mb-3 row">
                                    <button class="btn btn-success col-md-6" id="searchProdukMentah" style="width: 100%"><i data-feather="plus"></i>&nbsp;Cari Produk</button>
                                </div>
                                <div class="mb-3">
                                    <label for="nama_Produk" class="form-label">Kode Produk Mentah</label>
                                    <input type="text" id="kode_produk_mentah" class="form-control" placeholder="Kode Produk" readonly>
                                    <small class="text-danger error_text kode_produk_mentah_error"></small>
                                </div>
                                <div class="mb-3">
                                    <label for="nama_Produk" class="form-label">Produk</label>
                                    <input type="text" class="form-control" id="nama_produk_mentah" placeholder="Nama Produk" readonly>
                                  </div>
                                  <div class="mb-3">
                                    <label for="jenis_produk" class="form-label">Jenis Produk</label>
                                    <input type="text" class="form-control" id="jenis_produk" placeholder="Jenis Produk" readonly>
                                  </div>
                                  <div class="mb-3">
                                    <label for="satuan" class="form-label">Satuan</label>
                                    <input type="text" class="form-control" id="satuan" placeholder="Satuan Produk" readonly>
                                  </div>
                                  <div class="mb-3">
                                    <label for="quantity" class="form-label">Qty</label>
                                    <input type="number" class="form-control" id="quantity" value="0">
                                    <small class="text-danger error_text quantity_error"></small>
                                  </div>
                                  <div class="row" id="btn-action-produk">
                                      <button class="btn btn-secondary col-md-5 m-2" id="reset"><i data-feather="refresh-ccw"></i>&nbsp;Reset</button>
                                      <button class="btn btn-primary col-md-5 m-2" id="tambah-master-prakitan"><i data-feather="plus"></i>&nbsp;Tambah</button>
                                      <button class="btn btn-primary col-md-5 m-2" id="ubah-master-prakitan"><i data-feather="plus"></i>&nbsp;Ubah</button>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row my-1 justify-content-end contentSearchProdukJadi">
                                <div class="col-md-7">
                                    <h2>Detail Perakitan</h2>
                                </div>
                                <div class="col-md-5">
                                    <label for="exampleInputEmail1" class="form-label">Cari Produk...</label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control"  placeholder="Cari Produk..." id="input_search_pembelian" readonly>
                                        <button class="btn btn-danger" style="width : 20%;" id="searchProduk"><i data-feather="search"></i>&nbsp;</button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped align-items-center mb-0" style="width: 100%">
                                <thead>
                                  <tr>
                                    <th  style="width: 30%;">Kode Produk</th>
                                    <th style="width: 20%;">Nama</th>
                                    <th>Jenis</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody id="data-detail-prakitan">

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
                                    <button class="btn btn-success" style="float: right;" id="selesai_master_prakitan"><i data-feather="send"></i>&nbsp;Selesai Master Prakitan</button>
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
      feather.replace();
        $(function () {
            $("#btn-action-produk").find("#ubah-master-prakitan").hide();
            // $(".data-detail-prakitan").hide();

            $.ajax({
                  headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                  url : "/master-prakitan/get-modal-produk-jadi",
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

              $.ajax({
                  headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                  url : "/master-prakitan/get-modal-produk-mentah",
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
        });

        $(document).on("click", "#searchProduk", function () {
            $("#modalProdukPrakitan").modal("show");
        });

         function getDataDetailPrakitan() {
            let kode_produk_jadi = $("#kode_produk_jadi").val();
            $.ajax({
                  headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                  url : "/master-prakitan/get-detail-prakitan/" + kode_produk_jadi,
                  dataType : "json",
                  success: response => {
                      console.log(response);
                      if(response.success) {
                        $("#data-detail-prakitan tr").remove();
                        $.each(response.data, function (key, value) {
                                let jenis = (value.jenis_produk == 0) ? "Barang Mentah" : "Barang Jadi" ;
                                        $('#data-detail-prakitan').prepend(`<tr>
                                                    <td>`+value.kode_produk+`</td>
                                                    <td>`+value.nama_produk+`</td>
                                                    <td>Barang Mentah</td>
                                                    <td>`+value.quantity+`</td>
                                                    <td>
                                                        <button class="btn-sm btn-danger" id="deleteDetailMasterPrakitan" data-kode_produk_mentah=` + value.kode_produk + ` data-kode_produk_jadi=` + value.kode_produk_jadi + `>Delete</button>
                                                        <button class="btn-sm btn-primary" id="editDetailMasterPrakitan" data-kode_produk=` + value.kode_produk +` data-nama_produk=` + value.nama_produk +` data-satuan=` + value.satuan +` data-quantity=` + value.quantity +`>Edit</button>
                                                    </td>
                                                    </tr>`);
                                })
                      }
                  },
                  error: function(xhr,textStatus,thrownError) {
                  alert(xhr + "\n" + textStatus + "\n" + thrownError);
                  }
              });
         }

         $(document).on("click", "#tambah-master-prakitan", function () {
            let kode_produk_jadi = $("#kode_produk_jadi").val();
            let kode_produk_mentah = $("#kode_produk_mentah").val();
            let quantity = $("#quantity").val();

                $.ajax({
                  headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                  url : "/master-prakitan/detail-master-prakitan/store",
                  type : "POST",
                  data : {
                    kode_produk_jadi : kode_produk_jadi,
                    kode_produk_mentah : kode_produk_mentah,
                    quantity : quantity
                  },
                  dataType : "json",
                  success: response => {
                    if(response.errors) {
                            let form_produk = $(".data_produk");
                                $.each(response.errors, function (prefix, val) {
                                    if(prefix == "kode_produk_jadi") {
                                    $("#inputProdukJadi").find("input").addClass("is-invalid");
                                    $("#inputProdukJadi").find("small").text("Kode Produk Jadi Is Required");
                                }
                                $(form_produk).find("#" + prefix + "").addClass("is-invalid");
                                $(form_produk).find("small." + prefix + "_error").text(val[0]);
                            })
                    }

                    if(response.success) {
                    Swal.fire({
                            icon: 'success',
                            title: 'success',
                            text:  response.success
                        })

                    refreshError("produk_jadi");


                    getDataDetailPrakitan();
                    }
                  },
                  error: function(xhr,textStatus,thrownError) {
                  alert(xhr + "\n" + textStatus + "\n" + thrownError);
                  }
              });
         });


         $(document).on("click", "#editDetailMasterPrakitan", function () {
            let kode_produk_mentah = $(this).attr("data-kode_produk");
            let nama_produk = $(this).attr("data-nama_produk");
            let satuan = $(this).attr("data-satuan");
            let quantity = $(this).attr("data-quantity");

            $("#kode_produk_mentah").val(kode_produk_mentah);
            $("#nama_produk_mentah").val(nama_produk);
            $("#satuan").val(satuan);
            $("#jumlah_produk_mentah").val(quantity);
            $("#jenis_produk").val("Barang Mentah");

            $("#btn-action-produk").find("#ubah-master-prakitan").show();
            $("#btn-action-produk").find("#tambah-master-prakitan").hide();
         });

         $(document).on("click", "#ubah-master-prakitan", function () {
            let kode_produk_jadi = $("#kode_produk_jadi").val();
            let kode_produk_mentah = $("#kode_produk_mentah").val();
            let quantity = $("#quantity").val();

                $.ajax({
                  headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                  url : "/master-prakitan/detail-master-prakitan/update",
                  type : "POST",
                  data : {
                    kode_produk_jadi : kode_produk_jadi,
                    kode_produk_mentah : kode_produk_mentah,
                    quantity : quantity
                  },
                  dataType : "json",
                  success: response => {
                        if(response.errors) {
                            let form_produk = $(".data_produk");
                                $.each(response.errors, function (prefix, val) {
                                if(prefix == "kode_produk_jadi") {
                                    $("#inputProdukJadi").find("input").addClass("is-invalid");
                                }
                                $(form_produk).find("#" + prefix + "").addClass("is-invalid");
                                $(form_produk).find("small." + prefix + "_error").text(val[0]);
                            })
                        }

                      if(response.success) {
                        Swal.fire({
                                icon: 'success',
                                title: 'success',
                                text:  response.success
                            })
                        refreshError("produk_mentah");

                        getDataDetailPrakitan();
                      }

                  },
                  error: function(xhr,textStatus,thrownError) {
                  alert(xhr + "\n" + textStatus + "\n" + thrownError);
                  }
              });
         });

         $(document).on("click", "#deleteDetailMasterPrakitan", function() {
            let kode_produk_jadi = $(this).attr("data-kode_produk_jadi");
            let kode_produk_mentah = $(this).attr("data-kode_produk_mentah");

            Swal.fire({
                title: 'Apakah Yakin Menghapus?',
                text: "Hapus data kode produk " + kode_produk_mentah,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                        url: "/master-prakitan/"+ kode_produk_jadi + "/produk/" + kode_produk_mentah,
                        type: "DELETE",
                        success: response => {

                            if(response.success) {
                                Swal.fire({
                                icon: 'success',
                                title: 'success',
                                text:  response["success"],
                            })
                            getDataDetailPrakitan();
                        }

                            if(response.error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'error',
                                    text:  response["error"],
                                })
                                getDataDetailPrakitan();
                            }
                        }
                    });
                }
            })
         });

         $(document).on("click", "#selesai_master_prakitan", function () {
            Swal.fire({
            title: 'Apakah Ingin Menyelesaikan Master Prakitan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Yakin!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                    url : "/master-prakitan/store",
                    type : "POST",
                    data : {
                        kode_produk_jadi : $("#kode_produk_jadi").val()
                    },
                    dataType : "json",
                    success: response => {
                        console.log(response);
                        if(response["success"]) {
                            Swal.fire({
                                icon: 'success',
                                title: 'success',
                                text:  response["success"]
                            });
                                window.location.href = "/master-prakitan";
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

         $("#reset").on("click", function () {
            $(".inputProdukMentah").find("input").val("");
            $(".inputProdukMentah").find("small").html("");
            $("#tambah-master-prakitan").show();
            $("#ubah-master-prakitan").hide();
         });

         function refreshError(type) {
            if(type == "produk_jadi") {
                $("#inputProdukJadi").find("input").removeClass("is-invalid");
                $("#inputProdukJadi").find("small").html("");
            }
            $(".inputProdukMentah").find("input").removeClass("is-invalid");
            $(".inputProdukMentah").find("small").html("");

         }
    </script>
@endpush
