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
                    <div class="row justify-content-between bg-light" style="margin-top: 2rem; padding-top: 2rem;">
                        <div class="col-md-3">
                            <div class="row justify-content-center">
                                <h2 class="mb-2">Data Penjualan</h2>
                                <div class="mb-3">
                                    <label class="form-label">No Penjualan</label>
                                    <input type="text" class="form-control" placeholder="No Pembelian Produk" value="{{ $penjualan->no_penjualan }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Customer</label>
                                    <input type="text" class="form-control" placeholder="Nama Customer" value="{{ $penjualan->customer->nama }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Alamat Customer</label>
                                    <input type="text" class="form-control" placeholder="Alamat" value="{{ $penjualan->customer->alamat }}" readonly>
                                </div>
                                  <div class="mb-3">
                                    <label class="form-label">Tanggal Penjualan</label>
                                    <input type="text" class="form-control" placeholder="Tanggal Penjualan" value="{{ $tanggal_penjualan }}" readonly>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label">Karyawan Input</label>
                                    <input type="text" class="form-control" placeholder="Karyawan Input" value="{{ $penjualan->karyawan->nama }}" readonly>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" placeholder="Jabatan Karyawan" value="{{ $penjualan->karyawan->jabatan->nama_jabatan }}" readonly>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h2 style="margin-bottom: 2rem;">Detail Penerimaan</h2>
                            <a href="/penjualan/print/detail-penjualan/print-pdf/{{ $penjualan->no_penjualan }}"class="btn btn-success mb-2">Download PDF</a>
                            <a href="/penjualan/detail-prakitan/export-excel/{{ $penjualan->no_penjualan }}"class="btn btn-warning mb-2">Download Excel</a>
                            <table class="table table-bordered table-striped align-items-center mb-0" style="width: 100%">
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th  style="width: 15%;">Kode Produk</th>
                                    <th style="width: 15%;">Nama</th>
                                    <th>Jenis</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Diskon</th>
                                    <th>Total Harga</th>
                                  </tr>

                                </thead>
                                <tbody id="data-detail-pembelian">
                                    @foreach ($details as $detail)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td  style="width: 15%;">{{ $detail->kode_produk }}</td>
                                            <td style="width: 15%;">{{ $detail->produk->nama }}</td>
                                            <td>{{ ($detail->produk->jenis == 0) ? "Barang Mentah" : "Barang Jadi" }}</td>
                                            <td>{{ $detail->jumlah }}</td>
                                            <td>{{ "Rp. " . number_format($detail->harga) }}</td>
                                            <td>{{ $detail->diskon }}</td>
                                            <td>{{ "Rp. " . number_format($detail->total_harga) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr rowSpan="2" style="font: bold; background-color: rgba(154, 194, 196, .8);">
                                        <th colspan="6"></th>
                                        <th>Total</th>
                                        <th id="table_total_keseluruhan" colspan="2">{{ "Rp. " . number_format($penjualan->total_keseluruhan) }}</th>
                                    </tr>
                                </tbody>
                              </table>
                              <div class="row mt-4">
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
</script>
@endpush
