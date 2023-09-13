@extends('template.template')

@section('title')
    Penerimaan
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
              <div class="card-header">
                <a href="{{ url("/penerimaan/tambah-penerimaan") }}" class="btn btn-success"> <i class="align-middle" data-feather="plus"></i>&nbsp;Tambah Penerimaan</a>
              </div>
              <div class="card-body pb-2">
                <div class="table-responsive p-2">
                  <table class="table align-items-center mb-0 data-pembelian" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th  style="width: 15%;">No Penerimaan</th>
                        <th>Penerima</th>
                        <th>Tanggal </th>
                        <th style="width: 15%;">No Pembelian</th>
                        <th>Deskripsi</th>
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

            var table = $('.data-pembelian').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/penerimaan",
                columns: [
                    {
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'no_penerimaan',
                        name: 'no_penerimaan'
                    },
                    {
                        data: 'karyawan',
                        name: 'karyawan.nama'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'no_pembelian',
                        name: 'no_pembelian'
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi'
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
