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
                            <div class="card">
                                <div class="card-header bg-danger">
                                    <h2>Prakitan</h2>
                                </div>
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div class="mb-3">
                                            <label for="total_harga" class="form-label">Nama Karyawan</label>
                                            <input type="text" class="form-control" id="total_harga" placeholder="Total Harga" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama_Produk" class="form-label">No Prakitan</label>
                                            <input type="text" class="form-control" id="nama_produk" placeholder="Nama Produk" readonly>
                                          </div>
                                          <div class="mb-3">
                                            <label for="jenis_produk" class="form-label">Kode Produk</label>
                                            <input type="text" class="form-control" id="jenis_produk" placeholder="Jenis Produk" readonly>
                                          </div>
                                          <div class="mb-3">
                                            <label for="harga" class="form-label">Qty Rencana</label>
                                            <input type="number" class="form-control" id="harga" placeholder="Harga" readonly>
                                          </div>
                                          <div class="mb-3">
                                            <label for="jumlah" class="form-label">Tanggal Rencana</label>
                                            <input type="number" class="form-control" id="jumlah" readonly>
                                          </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h2 style="margin-bottom: 2rem;">Detail Prakitan</h2>
                            <table class="table table-striped align-items-center mb-0" style="width: 100%">
                                <thead>
                                  <tr>
                                    <th  style="width: 15%;">Kode Produk</th>
                                    <th style="width: 15%;">Nama</th>
                                    <th>Diambil</th>
                                    <th>Digunakan</th>
                                    <th>Dikembalikan</th>
                                  </tr>
                                </thead>
                                <tbody id="data-detail-prakitan">
                                    @foreach ($detail_prakitan as $detail)
                                        <tr>
                                            <td>{{ $detail->kode_produk_mentah }}</td>
                                            <td>{{ $detail->produk_mentah->nama }}</td>
                                            <td><input type="number" value="{{ $detail->quantity * $qty_rencana }}" class="form-control qty_diambil" readonly></td>
                                            <td><input type="number" class="form-control qty_digunakan" placeholder="qty terpakai.."></td></td>
                                            <td><input type="number" class="form-control qty_sisa" readonly></td></td>
                                        </tr>
                                    @endforeach
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
                                    <button class="btn btn-success" style="float: right;" id="selesai_transaksi"><i data-feather="send"></i>&nbsp;Selesai dan sudahi Prakitan</button>
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
