@extends('template.template')

@section('title')
    <div class="col-md-6">
        <a href="{{ url("/pembelian") }}" style="float: left;" class="btn btn-warning"><i class="align-middle" data-feather="chevrons-left"></i>&nbsp;Back</a>
    </div>
@endsection

@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="w-100">
                        <div class="row">
							<div class="card">
                                <div class="card-header p-2">
                                    <h1 class="h3 mb-3"><strong>No</strong> Penerimaan &nbsp;:&nbsp;<span id="no_penerimaan">{{ $no_penerimaan }}</span></h1>
                                    <div class="input-group my-3 search-produk" style="width: 67%;">
                                        <input type="text" class="form-control" placeholder="Cari Pembelian..." id="inputSearchPembelian" readonly>
                                        <button class="btn btn-danger" id="searchPembelian" >Search</button>
                                    </div>
                                  </div>
								<div class="card-body">
                                      <div class="mb-3 row">
                                        <label for="nama_karyawan" class="col-sm-4 col-form-label">Penerima*</label>
                                        <div class="col-sm-8">
                                            <input type="hidden" name="nik" id="nik" value="{{ $karyawan->nik }}">
                                            <input type="text" class="form-control" placeholder="Name" id="nama_karyawan" value="{{ $karyawan->nama }}" readonly>
                                        </div>
                                      </div>
                                      <div class="mb-3 row">
                                        <label for="date" class="col-sm-4 col-form-label">Tanggal Penerimaan*</label>
                                        <div class="col-sm-8">
                                            <input id="tanggal_penerimaan" type="date" class="form-control" name="tanggal_penerimaan"/>
                                        </div>
                                      </div>
                                      <div class="mb-3 row">
                                        <label for="deskripsi" class="col-sm-4 col-form-label">Deskripsi</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" placeholder="Deskripsi..." name="deskripsi"  id="deskripsi" style="height: 100px"></textarea>
                                        </div>
                                      </div>
                                      <hr>
                                      <div class="mb-3 row justify-content-end">

                                      </div>
								</div>

                                <div class="row px-5 pb-5">
                                    <div class="col-md-12">
                                        <div class="my-2 row">
                                            <label for="quantity" class="col-sm-4">No Pembelian*</label>
                                            <div class="col-sm-8">
                                                <input type="hidden" id="no_pembelian" name="no_pembelian">
                                                <input type="text" class="form-control" placeholder="Kode Pembelian" id="input_no_pembelian" readonly>
                                            </div>
                                        </div>
                                        <div class="my-2 row">
                                            <label for="quantity" class="col-sm-4">Nama Supplier*</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="Nama Supplier" id="nama_supplier" readonly>
                                            </div>
                                        </div>
                                        <div class="my-2 row">
                                            <label for="tanggal_pmbelian" class="col-sm-4">Tanggal Pembelian*</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control" placeholder="Tanggal Pembelian" id="tanggal_pembelian" name="tanggal_pembelian" readonly>
                                            </div>
                                        </div>
                                        <div class="my-2 row">
                                            <label for="tanggal_pmbelian" class="col-sm-4">Deskripsi*</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" placeholder="Deskripsi..." name="deskripsi_pembelian"  id="deskripsi_pembelian" style="height: 100px" readonly></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="my-2 row">
                                            <label for="total_produk" class="col-sm-4">Total Produk*</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="total_produk" name="total_produk" value="0" readonly>
                                            </div>
                                        </div>
                                        <div class="my-2 row">
                                            <label for="nama_karyawan_pembelian" class="col-sm-4">Nama Karyawan*</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="nama_karyawan_pembelian" name="nama_karyawan_pembelian" value="0" readonly>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="mb-2 mt-2 row">
                                            <label for="total_keseluruhan" class="col-sm-4">Total Keseluruhan*</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" placeholder="Total Harga" id="total_keseluruhan" name="total_total_keseluruhanarga" readonly>
                                            </div>
                                        </div>
                                        <div class="mb-2 mt-5 row">
                                            <div class="col-sm-12">
                                                <button class="btn-lg btn-success" id="selesai_penerimaan" style="float: right;"><i class="align-middle" data-feather="shopping-cart"></i>&nbsp;Selesai Pembelian</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                        <div class="card mb-4">
                          <div class="card-header p-2">
                          </div>
                          <div class="card-body pb-2">
                            <div class="table-responsive">
                              <table class="table align-items-center mb-0 data-detail-penerimaan" style="width: 100%;">
                                <thead>
                                  <tr>
                                    <th style="width: 7%;">No</th>
                                    <th>Code Item</th>
                                    <th>Name</th>
                                    <th>quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                  </tr>
                                </thead>
                                <tbody id="data-detail-pembelian">

                                </tbody>
                              </table>
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
            error: function(xhr,textStatus,thrownError) {
            alert(xhr + "\n" + textStatus + "\n" + thrownError);
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
                $("#total_produk").val(pembelian["total_produk"]);
                $("#nama_karyawan_pembelian").val(pembelian["karyawan_input"]);
                $("#nama_supplier").val(pembelian["nama_supplier"]);
                $("#total_keseluruhan").val(pembelian["total_keseluruhan"]);
                $("#deskripsi_pembelian").val(pembelian["deskripsi"]);

                let no = 1;
                $.each(response.detail_pembelian, function (key, value) {
							$('#data-detail-pembelian').append("<tr>\
										<td>"+ no++ +"</td>\
										<td>"+value.kode_produk+"</td>\
										<td>"+value.nama_produk+"</td>\
										<td>"+value.jumlah+"</td>\
										<td>"+value.harga+"</td>\
										<td>"+value.total_harga+"</td>\
										</tr>");
				})
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
                no_penerimaan : $("#no_penerimaan").text(),
                no_pembelian : no_pembelian,
                tanggal_penerimaan : tanggal_penerimaan,
                deskripsi : $("#deskripsi").val(),
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
              }

              if(response.error) {
                Swal.fire({
                icon: 'error',
                title: 'error',
                text:  response.error
                });
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
