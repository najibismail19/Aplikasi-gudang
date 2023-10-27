@extends('template.template')

@section('title')
    <div class="col-md-6">
        <a href="{{ url("/penerimaan") }}" style="float: left;" class="btn btn-warning"><i class="align-middle" data-feather="chevrons-left"></i>&nbsp;Back</a>
    </div>
@endsection

@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="nama_karyawan_penerimaan" class="form-label">Nama Karyawan*</label>
                        <input type="hidden" id="nik" value="{{ getNik() }}">
                        <input type="text" class="form-control" id="nama_karyawan_penerimaan" value="{{ getNamaKaryawan() }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label for="no_penerimaan" class="form-label">No Penerimaan*</label>
                        <input type="text" class="form-control" id="no_penerimaan" readonly value="{{ $no_penerimaan }}">
                    </div>
                    <div class="col-md-3">
                        <label for="tanggal_penerimaan" class="form-label">Tanggal Penerimaan*</label>
                        <input type="date" class="form-control" id="tanggal_penerimaan">
                    </div>
                    <div class="col-md-3">
                        <label for="exampleInputEmail1" class="form-label">Search Pembelian</label>
                        <div class="d-flex">
                            <input type="text" class="form-control"  placeholder="Cari Pembelian..." id="input_search_pembelian" readonly>
                            <button class="btn btn-success" id="searchPembelian">Search</button>
                        </div>
                    </div>
                    <div class="row justify-content-between bg-light" style="margin-top: 2rem; padding-top: 2rem;">

                        <div class="col-md-9">
                            <h2 style="margin-bottom: 2rem;">Detail Penerimaan</h2>
                            <table class="table table-bordered table-striped align-items-center mb-0 data-produk table" style="width: 100%">
                                <thead>
                                  <tr style="font: bold; background-color: rgba(154, 194, 196, .8);">
                                    <th>No</th>
                                    <th style="width: 15%;">Kode Produk</th>
                                    <th style="width: 15%;">Nama</th>
                                    <th>Jenis</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                  </tr>
                                </thead>
                                <tbody id="data-detail-penerimaan">
                                </tbody>
                              </table>
                              <div class="row justify-content-end mt-4">
                                <div class="col-md-6">
                                    <button class="btn btn-success" style="float: right;" id="selesai_penerimaan"><i data-feather="send"></i>&nbsp;Selesai dan sudahi Transaksi</button>
                                </div>
                              </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="deskripsi_penerimaan" class="form-label">Deskripsi Penerimaan*</label>
                                <textarea class="form-control" name="deskripsi" id="deskripsi_penerimaan" style="height: 100px"></textarea>
                            </div>

                            <div class="row justify-content-center">
                                <h2 style="margin-bottom: -.5rem;">Data Pembelian</h2>
                                <div class="row g-3 d-flex mb-3 justify-content-between">
                                    <label for="no_pembelian" class="form-label" style="margin-bottom: -.5rem;">No Pembelian*</label>
                                    <div class="col-md-12">
                                      <input type="text" id="no_pembelian" class="form-control"readonly>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nama_karyawan_pembelian" class="form-label">Nama Karyawan Pembelian*</label>
                                    <input type="text" class="form-control" id="nama_karyawan_pembelian" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="jabatan" class="form-label">Jabatan*</label>
                                    <input type="text" class="form-control" id="jabatan" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="nama_supplier" class="form-label">Nama Supplier*</label>
                                    <input type="text" class="form-control" id="nama_supplier" readonly>
                                  </div>
                                <div class="mb-3">
                                    <label for="alamat_supplier" class="form-label">Alamat Supplier*</label>
                                    <input type="text" class="form-control" id="alamat_supplier" readonly>
                                  </div>
                                  <div class="mb-3">
                                    <label for="tanggal_pembelian" class="form-label">Tanggal Pembelian*</label>
                                    <input type="text" class="form-control" id="tanggal_pembelian" readonly>
                                  </div>
                                  <div class="mb-3">
                                    <label for="deskripsi_pembelian" class="form-label">Deskripsi Pembelian*</label>
                                    <textarea class="form-control" name="deskripsi" id="deskripsi_pembelian" style="height: 100px" readonly></textarea>
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
            $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
            url : "/penerimaan/search-penerimaan",
            dataType : "json",
            success: response => {
                if(response.success) {
                    $("body").append(response.modal);
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

    $(document).on("click", "#searchPembelian", function () {
        $("#modalSearchPembelian").modal("show");
    });

    $(document).on("click", ".pilihPembelian", function () {
    $("#data-detail-pembelian tr").remove();
    let no_pembelian = $(this).attr("id");
    $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
            url : "/penerimaan/get-detail-pembelian/" + no_pembelian,
            dataType : "json",
            success: response => {
                console.log(response);

                let pembelian = response.pembelian;

                $("#no_pembelian").val(pembelian["no_pembelian"]);
                $("#input_no_pembelian").val(pembelian["no_pembelian"]);
                $("#tanggal_pembelian").val(pembelian["tanggal_pembelian"]);
                $("#nama_karyawan_pembelian").val(pembelian["karyawan"]);
                $("#alamat_supplier").val(pembelian["alamat_supplier"]);
                $("#jabatan").val(pembelian["jabatan"]);
                $("#nama_supplier").val(pembelian["nama_supplier"]);
                $("#deskripsi_pembelian").val(pembelian["deskripsi"]);

                let no = 1;

                $("#data-detail-penerimaan tr").remove();

                let i = 1;
                $.each(response.detail_pembelian, function (key, value) {
                    let jenis_produk = (value.jenis_produk == 0) ? "Barang Mentah" : "Barang Jadi";
							$('#data-detail-penerimaan').append("<tr>\
										<td>"+ i++ +"</td>\
										<td>"+value.kode_produk+"</td>\
										<td>"+value.nama_produk+"</td>\
										<td>"+ jenis_produk +"</td>\
										<td>"+value.harga+"</td>\
										<td>"+value.jumlah+"</td>\
										<td>"+value.total_harga+"</td>\
										</tr>");
				});

                $("#data-detail-penerimaan").append(`
                    <tr rowSpan="2" style="font: bold; background-color: rgba(154, 194, 196, .8);">
                                        <th colspan="5"></th>
                                        <th>Total</th>
                        <th colspan="2">` + pembelian["total_keseluruhan"]  + `</th>
                    </tr>
                `);

                $("#modalSearchPembelian").modal("hide");
            },
            error: function(xhr,textStatus,thrownError) {
            alert(xhr + "\n" + textStatus + "\n" + thrownError);
            }
        });
    });


    $(document).on("click", "#selesai_penerimaan", function() {
        let tanggal_penerimaan = $("#tanggal_penerimaan").val();
        let no_pembelian = $("#no_pembelian").val();
        if($.trim(tanggal_penerimaan) == "") {
            Swal.fire({
                icon: 'error',
                title: 'error',
                text:  "Tanggal Penerimaan Tidak boleh kosong!"
            })
            $("#tanggal_penerimaan").addClass("is-invalid");
            return false;
        } else if($.trim(no_pembelian) == "") {
            Swal.fire({
                icon: 'error',
                title: 'error',
                text:  "Pilih Pembelian Yang Sudah diterima!"
            })
            return false;
        } else {
            let nik = $("#nik").val();
            $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
            url : "/penerimaan",
            method : "POST",
            data : {
                no_penerimaan : $("#no_penerimaan").val(),
                no_pembelian : no_pembelian,
                tanggal_penerimaan : tanggal_penerimaan,
                deskripsi : $("#deskripsi_penerimaan").val(),
                nik : nik,
            },
            dataType : "json",
            success: response => {
              console.log(response);
              if(response.success) {
                Swal.fire({
                icon: 'success',
                title: 'success',
                text:  response.success
                });

                window.location.href = "/penerimaan";
              }

              if(response.error) {
                Swal.fire({
                icon: 'error',
                title: 'error',
                text:  response.error
                });

                window.location.href = "/penerimaan";
              }
            },
            error: function(xhr,textStatus,thrownError) {
            alert(xhr + "\n" + textStatus + "\n" + thrownError);
            }
        });
        }
    });
</script>
@endpush
