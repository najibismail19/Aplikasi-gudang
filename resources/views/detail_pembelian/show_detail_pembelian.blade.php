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
                    <div class="row justify-content-between bg-light" style="margin-top: 2rem; padding-top: 2rem;">
                        <div class="col-md-4">
                            {{-- <div class="row justify-content-center">
                                <h2 class="mb-2">Pembelian</h2>
                                <div class="mb-3">
                                    <label class="form-label">No Pembelian</label>
                                    <input type="text" class="form-control" placeholder="No Pembelian Produk" value="{{ $pembelian->no_pembelian }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Supplier</label>
                                    <input type="text" class="form-control" placeholder="Nama Supplier" value="{{ $pembelian->supplier->nama }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Alamat</label>
                                    <input type="text" class="form-control" placeholder="Alamat Suppliar" value="{{ $pembelian->supplier->alamat }}" readonly>
                                </div>
                                  <div class="mb-3">
                                    <label class="form-label">Tanggal Pembelian</label>
                                    <input type="text" class="form-control" placeholder="Tanggal Pembelian" value="{{ $tanggal_pembelian }}" readonly>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label">Karyawan Input</label>
                                    <input type="text" class="form-control" placeholder="Karyawan Input" value="{{ $pembelian->karyawan->nama }}" readonly>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" placeholder="Jabatan" value="{{ $pembelian->karyawan->jabatan->nama_jabatan }}" readonly>
                                  </div>
                            </div> --}}
                            <table class="table table-bordered table-striped align-items-center mb-3" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="text-align: center">Pembelian</th>
                                    </tr>
                                  <tr>
                                  </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td>No Pembelian</td>
                                            <td>{{ $pembelian->no_pembelian }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal</td>
                                            <td>{{ $tanggal_pembelian }}</td>
                                        </tr>
                                        <tr>
                                            <td>Supplier</td>
                                            <td>{{ $pembelian->supplier->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td>{{ $pembelian->supplier->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <td>Karyawan Input</td>
                                            <td>{{ $pembelian->karyawan->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jabatan</td>
                                            <td>{{ $pembelian->karyawan->jabatan->nama_jabatan }}</td>
                                        </tr>
                                        <tr>
                                            <td>Penempatan Gudang</td>
                                            <td>{{ $pembelian->karyawan->gudang->nama_gudang }}</td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered table-striped align-items-center mb-3" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th colspan="4" style="text-align: center">Status Penerimaan</th>
                                    </tr>
                                  <tr>
                                    <th>No</th>
                                    <th>Nama Penerima</th>
                                    <th>Status</th>
                                    <th>Cetak</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#</td>
                                        <td>                                            
                                            @if ($pembelian->status_penerimaan)
                                                {{ $pembelian->penerimaan->karyawan->nama }}
                                            @else 
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($pembelian->status_penerimaan)
                                                <a class="btn btn-success">Sudah Diterima</a>
                                            @else 
                                                <a class="btn btn-danger">Belum Diterima</a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="/pembelian/detail-pembelian/print-pdf/{{ $pembelian->no_pembelian }}"class="btn btn-success mb-2">PDF</a>
                                            <a href="/pembelian/detail-pembelian/download-excel/{{ $pembelian->no_pembelian }}"class="btn btn-warning mb-2">Excel</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                           
                            <table class="table table-bordered table-striped align-items-center mb-0" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th colspan="7" style="text-align: center">Detail Pembelian</th>
                                    </tr>
                                  <tr>
                                    <th>No</th>
                                    <th  style="width: 15%;">Kode Produk</th>
                                    <th style="width: 15%;">Nama</th>
                                    <th>Jenis</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
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
                                            <td>{{ "Rp. " . number_format($detail->harga) }}</td>
                                            <td>{{ $detail->jumlah }}</td>
                                            <td>{{ "Rp. " . number_format($detail->total_harga) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr rowSpan="2" style="font: bold; background-color: rgba(154, 194, 196, .8);">
                                        <th colspan="5"></th>
                                        <th>Total</th>
                                        <th id="table_total_keseluruhan" colspan="2">{{ "Rp. " . number_format($pembelian->total_keseluruhan) }}</th>
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
        feather.replace();
</script>
@endpush
