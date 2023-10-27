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
                    <div class="row justify-content-between bg-light">
                        <div class="col-md-4">
                            <h2 style="margin-bottom: 2rem;">Prakitan</h2>
                                    <div class="row justify-content-center">
                                        <div class="mb-3">
                                            <label for="nama_karyawan" class="form-label">Nama Karyawan*</label>
                                            <input type="text" class="form-control" id="nama_karyawan" placeholder="Nama Karyawan" value="{{ $prakitan->karyawan->nama }}" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="no_prakitan" class="form-label">No Prakitan*</label>
                                            <input type="text" class="form-control" id="no_prakitan" placeholder="No Prakitan" value="{{ $prakitan->no_prakitan }}" readonly>
                                          </div>
                                          <div class="mb-3">
                                            <label for="kode_produk" class="form-label">Kode Produk*</label>
                                            <input type="text" class="form-control" id="kode_produk" placeholder="Kode Produk" value="{{ $prakitan->kode_produk }}" readonly>
                                          </div>
                                          <div class="mb-3">
                                            <label for="qty_rencana_prakitan" class="form-label">Qty Rencana*</label>
                                            <input type="number" class="form-control" id="qty_rencana_prakitan" placeholder="Qty Rencana..."  value="{{ $prakitan->qty_rencana }}" readonly>
                                          </div>
                                          <div class="mb-3">
                                            <label for="tanggal_rencana" class="form-label">Tanggal Rencana*</label>
                                            <input type="text" class="form-control" id="tanggal_rencana" value="{{ $tanggal_rencana }}" readonly>
                                          </div>
                                    </div>
                        </div>
                        <div class="col-md-8">
                            <h2 style="margin-bottom: 2rem;">Detail Prakitan</h2>
                            <table class="table table-bordered table-striped align-items-center mb-0" style="width: 100%">
                                <thead>
                                  <tr style="background-color: rgba(182, 192, 183, .75)">
                                    <th  style="width: 15%;">Kode Produk</th>
                                    <th style="width: 15%;">Nama</th>
                                    <th>Diambil</th>
                                    <th>Digunakan</th>
                                    <th>Dikembalikan</th>
                                  </tr>
                                </thead>
                                <tbody id="data-detail-prakitan">
                                    <input type="hidden" id="qty_rencana" value="{{ $prakitan->qty_rencana }}">
                                    @foreach ($detail_prakitan as $detail)
                                        <tr>
                                            <td>{{ $detail->kode_produk_mentah }}</td>
                                            <td>{{ $detail->produk_mentah->nama }}</td>
                                            <input type="hidden" id="qty_master_detail" value="{{ $detail->quantity }}">
                                            <td><input type="number" value="{{ $detail->quantity * $prakitan->qty_rencana }}" class="form-control qty_diambil" readonly></td>
                                            <td><input type="number" class="form-control qty_digunakan" placeholder="qty terpakai.." readonly></td></td>
                                            <td><input type="number" class="form-control qty_sisa" readonly readonly></td></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                              </table>
                              <div class="row justify-content-end mt-4">
                                <div class="col-md-6">
                                    <div class="mb-4 row">
                                        <label for="qty_hasil" class="col-sm-5 col-form-label">Qty Hasil*</label>
                                        <div class="col-sm-7">
                                            <input type="number" class="form-control" placeholder="Jumlah Produk" id="qty_hasil">
                                        </div>
                                    </div>
                                    <button class="btn btn-success" style="float: right;" id="selesai_prakitan"><i data-feather="send"></i>&nbsp;Selesai dan sudahi Prakitan</button>
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

    $("#qty_hasil").on("keyup", function () {
         $("#data-detail-prakitan tr").each(function () {
            let tr = $(this);


            let qty_diambil = $(tr).find(".qty_diambil").val();
            let qty_total = parseInt($("#qty_hasil").val()) * parseInt($(tr).find("#qty_master_detail").val());
            // let sisa = parseInt(qty_diambil) - parseInt($(tr).find(".qty_digunakan").val());
            $(tr).find(".qty_digunakan").val(qty_total)
            $(tr).find(".qty_sisa").val(qty_diambil - qty_total)
            if(qty_diambil - qty_total < 0) {
                $(tr).find(".qty_sisa").addClass("is-invalid");
            } else {
                $(tr).find(".qty_sisa").removeClass("is-invalid");
            }
        })
    });


    $("#selesai_prakitan").on("click", function () {
        let qty_hasil = $("#qty_hasil").val();

        if($.trim(qty_hasil) == "" || $.trim(qty_hasil) == 0) {
            $("#qty_hasil").addClass("is-invalid");
                Swal.fire({
                    icon: 'error',
                    title: 'error',
                    text:  "Qty hasil tidak boleh kosong!"
                })
            return false;
        } else {
            $.ajax({
                headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                url : "/prakitan/detail-prakitan/store",
                type : "POST",
                data : {
                    no_prakitan : $("#no_prakitan").val(),
                    kode_produk : $("#kode_produk").val(),
                    qty_rencana : $("#qty_rencana_prakitan").val(),
                    qty_hasil : qty_hasil,
                },
                dataType : "json",
                success: response => {
                    if(response.success) {
                        Swal.fire({
                                icon: 'success',
                                title: 'success',
                                text:  response.success
                            });
                        window.location.href = "/prakitan";
                    }
                    if(response.error) {
                        Swal.fire({
                                icon: 'error',
                                title: 'error',
                                text:  response.error
                            });
                    }
                },
                error: (xhr,textStatus,thrownError) => {
                    alert(xhr + "\n" + textStatus + "\n" + thrownError);
                }
            });
        }
    });
    $("#data-detail-prakitan tr").each(function () {
        let tr = $(this);
        $(tr).find(".qty_digunakan").on("keyup", function() {

            let qty_diambil = $(tr).find(".qty_diambil").val();
            let sisa = parseInt(qty_diambil) - parseInt($(this).val());
            if(sisa < 0) {
                $(tr).find(".qty_sisa").addClass("is-invalid");
            } else {
                $(tr).find(".qty_sisa").removeClass("is-invalid");
            }
            $(tr).find(".qty_sisa").val(sisa);
        })
    });
</script>
@endpush
