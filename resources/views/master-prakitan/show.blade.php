@extends('template.template')
@section('title')
    <a href="{{ url("/master-prakitan") }}" style="float: left;" class="btn btn-warning"><i class="align-middle" data-feather="chevrons-left"></i>&nbsp;Back</a>
@endsection
@section('content')
<div class="container-fluid p-0">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="row justify-content-between bg-light" style="margin-top: 2rem; padding-top: 2rem;">
                            <table class="table table-bordered table-striped align-items-center mb-3" style="width: 100%">
                                <thead>
                                <tr>
                                    <th colspan="4" style="text-align: center">Produk Jadi</th>
                                </tr>
                                  <tr>
                                    <th style="width: 15%;">Kode Produk</th>
                                    <th style="width: 15%;">Nama</th>
                                    <th>Satuan</th>
                                    <th>Jenis</th>
                                  </tr>
                                </thead>
                                <tbody id="data-detail-master-prakitan">
                                    <tr>
                                        <td>{{ $produk->kode_produk }}</td>
                                        <td>{{ $produk->nama }}</td>
                                        <td>{{ $produk->satuan }}</td>
                                        <td>{{ "Produk Jadi" }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered table-striped align-items-center mb-0" style="width: 100%">
                                <thead>
                                <tr>
                                    <th colspan="6" style="text-align: center">Detail Rakit Produk</th>
                                </tr>
                                  <tr>
                                    <th>No</th>
                                    <th style="width: 15%;">Kode Produk</th>
                                    <th style="width: 15%;">Nama</th>
                                    <th>Satuan</th>
                                    <th>Jenis</th>
                                    <th>Qty</th>
                                  </tr>
                                </thead>
                                <tbody id="data-detail-pembelian">
                                    @foreach ($produk_detail as $detail)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $detail->kode_produk_mentah }}</td>
                                            <td>{{ $detail->produk_mentah->nama }}</td>
                                            <td>{{ $detail->produk_mentah->satuan }}</td>
                                            <td>{{ "Produk Mentah" }}</td>
                                            <td>{{ $detail->quantity }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
