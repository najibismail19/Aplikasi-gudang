@extends('template.template')

@section('title')
    Kartu Stok
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
                  <table class="table table-striped  align-items-center mb-0 data-pembelian" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th>No Referensi</th>
                        <th>Gudang</th>
                        <th>Kode Produk</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Saldo Awal</th>
                        <th>Stok In</th>
                        <th>Stok Out</th>
                        <th>Saldo Akhir</th>
                        <th>Tanggal</th>
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

            var table = $('.data-pembelian').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/kartu-stok",
                columns: [
                    {
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'no_referensi',
                        name: 'no_referensi'
                    },
                    {
                        data: 'gudang',
                        name: 'gudang.nama'
                    },
                    {
                        data: 'kode_produk',
                        name: 'kode_produk'
                    },
                    {
                        data: 'nama_produk',
                        name: 'produk.nama'
                    },
                    {
                        data: 'jenis_produk',
                        name: 'produk.jenis_produk'
                    },
                    {
                        data: 'saldo_awal',
                        name: 'saldo_awal'
                    },
                    {
                        data: 'stock_in',
                        name: 'stock_in'
                    },
                    {
                        data: 'stock_out',
                        name: 'stock_out'
                    },
                    {
                        data: 'saldo_akhir',
                        name: 'saldo_akhir'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                ],
                drawCallback: function( settings ) {
                    feather.replace();
                }
            });
        });
    </script>
@endpush
