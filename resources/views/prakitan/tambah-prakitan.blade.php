@extends('template.template')
@section('title')
    <a href="{{ url("/prakitan") }}" style="float: left;" class="btn btn-warning"><i class="align-middle" data-feather="chevrons-left"></i>&nbsp;Back</a>
@endsection
@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-body">
                <div class="row input_prakitan">
                    <div class="col-md-3">
                        <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                        <input type="hidden" id="nik" value="{{ getNik() }}">
                        <input type="text" class="form-control" id="nama_karyawan" value="{{ getNamaKaryawan() }}" readonly>
                        <small class="text-danger error_text nik_error"></small>
                    </div>
                    <div class="col-md-3">
                        <label for="no_prakitan" class="form-label">No Prakitan</label>
                        <input type="text" class="form-control" id="no_prakitan" readonly value="{{ $no_prakitan }}">
                        <small class="text-danger error_text no_prakitan_error"></small>
                    </div>
                    <div class="col-md-3">
                        <label for="tanggal_rencana" class="form-label">Tanggal Rencana</label>
                        <input type="date" class="form-control" id="tanggal_rencana">
                        <small class="text-danger error_text tanggal_rencana_error"></small>
                    </div>
                    <div class="col-md-3">
                        <label for="qty_rencana" class="form-label">Qty Rencana</label>
                        <input type="number" class="form-control"  placeholder="Qty Rencana..." id="qty_rencana" value="">
                        <small class="text-danger error_text qty_rencana_error"></small>
                    </div>
                    <div class="row justify-content-between bg-light" style="margin-top: 2rem; padding-top: 2rem;">
                        <div class="col-md-3">
                            <div class="row justify-content-center contentProdukPrakitan">
                                <h2>Produk Prakitan</h2>
                                <div class="mb-3 row">
                                    <button class="btn btn-success" id="searchMasterPrakitan"><i data-feather="plus"></i>&nbsp;Cari Produk</button>
                                </div>
                                <div class="mb-3">
                                    <label for="kode_produk_jadi" class="form-label" style="margin-bottom: -.5rem;">Kode Produk</label>
                                    <input type="text" id="kode_produk_jadi" class="form-control" placeholder="Kode Produk" readonly>
                                    <small class="text-danger error_text kode_produk_jadi_error"></small>
                                </div>
                                <div class="mb-3">
                                    <label for="nama_Produk" class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control" id="nama_produk_jadi" placeholder="Nama Produk" readonly>
                                  </div>
                                  <div class="mb-3">
                                    <label for="jenis_produk" class="form-label">Jenis Produk</label>
                                    <input type="text" class="form-control" id="jenis_produk" placeholder="Jenis Produk" readonly>
                                  </div>
                                  <div class="mb-3">
                                    <label for="satuan" class="form-label">Satuan</label>
                                    <input type="text" class="form-control" id="satuan" placeholder="Satuan" readonly>
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
                                    <th>Qty/produk</th>
                                    <th>Qty Total</th>
                                  </tr>
                                </thead>
                                <tbody id="data-detail-prakitan"></tbody>
                              </table>
                              <div class="row justify-content-end mt-4">
                                {{-- <div class="col-md-6">
                                    <div class="mb-4 row">
                                        <label for="nama_karyawan" class="col-sm-3 col-form-label">Deskripsion <small>(Optional)</small></label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control error_text" placeholder="Description..." name="deskripsi" id="deskripsi_prakitan" style="height: 100px"></textarea>
                                        </div>
                                      </div>
                                </div> --}}
                                <div class="col-md-6">
                                    <button class="btn btn-success" style="float: right;" id="tambah_prakitan"><i data-feather="send"></i>&nbsp;Tambah Prakitan</button>
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
          $.ajax({
                  headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                  url : "/prakitan/get-master-prakitan",
                  dataType : "json",
                  success: response => {
                      console.log(response);
                      if(response.success) {
                          $("body").append(response.modal)
                      }
                  },
                  error: (xhr,textStatus,thrownError) => {
                      alert(xhr + "\n" + textStatus + "\n" + thrownError);
                  }
              });


              $(document).on("click", "#tambah_prakitan", function () {
                let tanggal_rencana = $("#tanggal_rencana").val();
                let qty_rencana = $("#qty_rencana").val();
                let kode_produk_jadi = $("#kode_produk_jadi").val();

                    $.ajax({
                        headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                        url : "/prakitan",
                        type : "POST",
                        data : {
                            no_prakitan : $("#no_prakitan").val(),
                            kode_produk_jadi : kode_produk_jadi,
                            nik : $("#nik").val(),
                            tanggal_rencana : tanggal_rencana,
                            qty_rencana : qty_rencana,
                            deskripsi : $("#deskripsi_prakitan").val(),
                        },
                        dataType : "json",
                        success: response => {
                            console.log(response);
                            if(response.error_input) {
                                console.log(response.error_input);
                                let input_prakitan = $(".input_prakitan");

                                $.each(response.error_input, function (prefix, val) {
                                    if(prefix == "nik"){
                                        $("#nama_karyawan").addClass("is-invalid");
                                        $(".nik_error").val(val[0]);
                                    } else {
                                        $(input_prakitan).find("#" + prefix + "").addClass("is-invalid");
                                        $(input_prakitan).find("small." + prefix + "_error").text(val[0]);
                                    }
                                })
                            }

                            if(response.error_stok) {
                                $.each(response.error_stok, function (key, value) {
                                    // $("#qty_"+ value.kode_produk +"").addClass("is-invalid");
                                    $("#total_qty_"+ value.kode_produk +"").addClass("is-invalid");
                                    $("#total_qty_"+ value.kode_produk +"").after(`<small class="text-danger">Stok produk kurang</small>`);
                                })
                            }

                            if(response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'success',
                                    text:  response.success
                                });

                                window.location.href = "/prakitan";
                            }


                        },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                console.log("Error Thrown: " + errorThrown);
                                console.log("Text Status: " + textStatus);
                                console.log("XMLHttpRequest: " + XMLHttpRequest);
                                console.warn(XMLHttpRequest.responseText)
                        }
                    });
              });
    </script>
@endpush
