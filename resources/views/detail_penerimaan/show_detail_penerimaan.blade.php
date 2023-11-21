@extends('template.template')
@section('title')
    <a href="{{ url("/penerimaan") }}" style="float: left;" class="btn btn-warning"><i class="align-middle" data-feather="chevrons-left"></i>&nbsp;Back</a>
@endsection
@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="row justify-content-between bg-light" style="margin-top: 2rem; padding-top: 2rem;">
                        <div class="col-md-4">
                            {{-- <div class="row justify-content-center">
                                <h2 class="mb-2">Data Penerimaan</h2>
                                <div class="mb-3">
                                    <label class="form-label">No Penerimaan</label>
                                    <input type="text" class="form-control" placeholder="No Penerimaan" value="{{ $penerimaan->no_penerimaan }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">No Pembelian</label>
                                    <input type="text" class="form-control" placeholder="No Pembelian" value="{{ $penerimaan->no_pembelian }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Supplier</label>
                                    <input type="text" class="form-control" placeholder="Supplier" value="{{ $penerimaan->pembelian->supplier->nama }}" readonly>
                                </div>
                                  <div class="mb-3">
                                    <label class="form-label">Tanggal Penerimaan</label>
                                    <input type="text" class="form-control" placeholder="Tanggal Penerimaan" value="{{ $tanggal_penerimaan }}" readonly>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label">Total Jenis Produk</label>
                                    <input type="number" class="form-control" placeholder="count" value="{{ count($penerimaan->pembelian->detailPembelian) }}" readonly>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label">Total Harga</label>
                                    <input type="text" class="form-control" placeholder="Total Harga" value="{{ $penerimaan->pembelian->total_keseluruhan }}" readonly>
                                  </div>
                            </div> --}}
                            <table class="table table-bordered table-striped align-items-center mb-3" style="width: 100%">
                                <thead>
                                <tr>
                                    <th colspan="2" style="text-align: center">Penerimaan</th>
                                </tr>
                                </thead>
                                <tbody id="data-detail-pembelian">
                                    <tr>
                                       <td>No Penerimaan</td>
                                       <td>{{ $penerimaan->no_penerimaan }}</td>
                                    </tr>
                                    <tr>
                                       <td>Tanggal</td>
                                       <td>{{ $tanggal_penerimaan }}</td>
                                    </tr>
                                    <tr>
                                       <td>Penerima/Karyawan</td>
                                       <td>{{ $penerimaan->karyawan->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jabatan</td>
                                        <td>{{ $penerimaan->karyawan->jabatan->nama_jabatan }}</td>
                                    </tr>
                                    <tr>
                                        <td>Karyawan</td>
                                        <td>{{ $penerimaan->karyawan->gudang->nama_gudang }}</td>
                                    </tr>
                                    <tr>
                                        <td>Cetak</td>
                                        <td>
                                            <a href="/penerimaan/detail-penerimaan/print-pdf/{{ $penerimaan->no_penerimaan }}"class="btn btn-success mb-2">PDF</a>
                                            <a href="/penerimaan/detail-penerimaan/download-excel/{{ $penerimaan->no_penerimaan }}"class="btn btn-warning mb-2">Excel</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered table-striped align-items-center mb-3" style="width: 100%">
                                <thead>
                                <tr>
                                    <th colspan="5" style="text-align: center">Pembelian Yang diterima</th>
                                </tr>
                                  <tr>
                                    <th  style="width: 15%;">No Pembelian</th>
                                    <th style="width: 15%;">Supplier</th>
                                    <th>Tanggal</th>
                                    <th>Karyawan</th>
                                    <th>Gudang</th>
                                  </tr>
                                </thead>
                                <tbody id="data-detail-pembelian">
                                    <tr>
                                        <td>{{ $penerimaan->no_pembelian }}</td>
                                        <td>{{ $penerimaan->pembelian->supplier->nama }}</td>
                                        <td>{{ $penerimaan->pembelian->tanggal_pembelian }}</td>
                                        <td>{{ $penerimaan->pembelian->karyawan->nama }}</td>
                                        <td>{{ $penerimaan->pembelian->karyawan->gudang->nama_gudang }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered table-striped align-items-center mb-0" style="width: 100%">
                                <thead>
                                <tr>
                                    <th colspan="6" style="text-align: center">Detail Penerimaan</th>
                                </tr>
                                  <tr>
                                    <th  style="width: 15%;">Kode Produk</th>
                                    <th style="width: 15%;">Nama</th>
                                    <th>Jenis</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                  </tr>
                                </thead>
                                <tbody id="data-detail-pembelian">
                                    @foreach ($detail_penerimaan as $detail)
                                        <tr>
                                            <td  style="width: 15%;">{{ $detail->kode_produk }}</td>
                                            <td style="width: 15%;">{{ $detail->produk->nama }}</td>
                                            <td>{{ ($detail->produk->jenis == 0) ? "Barang Mentah" : "Barang Jadi" }}</td>
                                            <td>{{ "Rp. " . number_format($detail->harga) }}</td>
                                            <td>{{ $detail->jumlah }}</td>
                                            <td>{{ "Rp. " . number_format($detail->total_harga) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr rowSpan="2" style="font: bold; background-color: rgba(154, 194, 196, .8);">
                                        <th colspan="4"></th>
                                        <th>Total</th>
                                        <th id="table_total_keseluruhan" colspan="2">{{ "Rp. " . number_format($penerimaan->pembelian->total_keseluruhan) }}</th>
                                    </tr>
                                </tbody>
                            </table>
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
