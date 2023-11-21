@extends('template.template')

@section('title')
    Stok Barang Mentah
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
              <div class="card-header">
                <a class="btn btn-success"> <i class="align-middle" data-feather="plus"></i>&nbsp;Add Pembelian</a>
              </div>
              <div class="card-body pb-2">
                <div class="table-responsive p-2">
                  <table class="table table-bordered table-striped align-items-center mb-0 data-stok-produk-mentah" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th>Gudang</th>
                        <th>Kode Produk</th>
                        <th>Nama</th>
                        <th>Satuan</th>
                        <th>Stok</th>
                        <th>Jenis</th>
                      </tr>
                    </thead>
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
          $(function () {

            var table = $('.data-stok-produk-mentah').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/stok-barang-mentah",
                columns: [
                    {
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_gudang',
                        name: 'gudang.nama_gudang'
                    },
                    {
                        data: 'kode_produk',
                        name: 'stok.kode_produk'
                    },
                    {
                        data: 'nama',
                        name: 'produk.nama'
                    },
                    {
                        data: 'satuan',
                        name: 'produk.satuan'
                    },
                    {
                        data: 'stok',
                        name: 'stok.stok'
                    },
                    {
                        data: 'jenis_produk',
                        name: 'jenis_produk'
                    },
                ]
            });
        });
    </script>
@endpush
