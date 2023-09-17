@extends('template.template')

@section('title')
    Master Prakitan
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
              <div class="card-header">
                <a href="{{ url("/master-prakitan/tambah-master-prakitan") }}" class="btn btn-success"> <i class="align-middle" data-feather="plus"></i>&nbsp;Tambah Master Prakitan</a>
              </div>
              <div class="card-body pb-2">
                <div class="table-responsive p-2">
                  <table class="table table-striped  align-items-center mb-0 data-master-prakitan" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th  style="width: 15%;">Kode Produk</th>
                        <th style="width: 15%;">Nama</th>
                        <th>Satuan</th>
                        <th>Jenis Produk</th>
                        <th>Action</th>
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

            var table = $('.data-master-prakitan').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/master-prakitan",
                columns: [
                    {
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kode_produk',
                        name: 'produk.kode_produk'
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
                        data: 'jenis_produk',
                        name: 'jenis_produk'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                drawCallback: function( settings ) {
                    feather.replace();
                }
            });
        });
    </script>
@endpush
