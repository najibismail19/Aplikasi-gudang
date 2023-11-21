@extends('template.template')
@section('title')
    <a href="{{ url("/prakitan") }}" style="float: left;" class="btn btn-warning"><i class="align-middle" data-feather="chevrons-left"></i>&nbsp;Back</a>
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
                                <h2 class="mb-2">Data Prakitan</h2>
                                <div class="mb-3">
                                    <label class="form-label">No Prakitan</label>
                                    <input type="text" class="form-control" placeholder="No Penerimaan" value="{{ $prakitan->no_prakitan }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama Karyawan Input</label>
                                    <input type="text" class="form-control" placeholder="Nama Karyawan Input" value="{{ $prakitan->karyawan->nama }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" placeholder="Jabatan" value="{{ $prakitan->karyawan->jabatan->nama_jabatan }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kode Produk</label>
                                    <input type="text" class="form-control" placeholder="No Pembelian" value="{{ $prakitan->kode_produk }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Qty Rencana</label>
                                    <input type="text" class="form-control" placeholder="Qty Rencana" value="{{ $prakitan->qty_rencana }}" readonly>
                                </div>
                                  <div class="mb-3">
                                    <label class="form-label">Qty Hasil</label>
                                    <input type="text" class="form-control" placeholder="Qty Hasil" value="{{ $prakitan->qty_hasil }}" readonly>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label">Tanggal Rencana</label>
                                    <input type="text" class="form-control" placeholder="Tanggan Rencana" value="{{ $tanggal_rencana }}" readonly>
                                  </div>
                                  <div class="mb-3">
                                    <label class="form-label">Tanggal Actual</label>
                                    <input type="text" class="form-control" placeholder="Tanggal Actual" value="{{ $tanggal_actual }}" readonly>
                                  </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h2 style="margin-bottom: 2rem;">Detail Penerimaan</h2>
                            <a href="/prakitan/detail-prakitan/print-pdf/{{ $prakitan->no_prakitan }}"class="btn btn-success mb-2">Download PDF</a>
                            <a href="/prakitan/detail-prakitan/download-excel/{{ $prakitan->no_prakitan }}"class="btn btn-warning mb-2">Download Excel</a>
                            <table class="table table-bordered table-striped align-items-center mb-0" style="width: 100%">
                                <thead>
                                  <tr>
                                    <th  style="width: 15%;">Kode Produk</th>
                                    <th style="width: 15%;">Nama</th>
                                    <th>Jenis</th>
                                    <th>Diambil</th>
                                    <th>Digunakan</th>
                                    <th>Dikembalikan</th>
                                  </tr>
                                </thead>
                                <tbody id="data-detail-pembelian">
                                    @foreach ($detail_prakitan as $detail)
                                        <tr>
                                            <td  style="width: 15%;">{{ $detail->kode_produk_mentah }}</td>
                                            <td style="width: 15%;">{{ $detail->produk_mentah->nama }}</td>
                                            <td>{{ ($detail->produk_mentah->jenis == 0) ? "Barang Mentah" : "Barang Jadi" }}</td>
                                            <td>{{ $detail->quantity * $prakitan->qty_rencana}}</td>
                                            <td>{{ $detail->quantity * $prakitan->qty_hasil }}</td>
                                            <td>{{ ($detail->quantity * $prakitan->qty_rencana) - ($detail->quantity * $prakitan->qty_hasil)}}</td>
                                        </tr>
                                    @endforeach
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
