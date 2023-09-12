@extends('template.template')
@section('title')
    Users Activity
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
              <div class="card-header">
              </div>
              <div class="card-body pb-2">
                <div class="table-responsive p-2">
                  <table class="table align-items-center mb-0 data-user-activity" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 7%;">No</th>
                        <th>Nama</th>
                        <th>Tempat Gudang</th>
                        <th>Alamat</th>
                        <th>Kontak</th>
                        <th>Status Pengguna</th>
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

var table = $('.data-user-activity').DataTable({
    processing: true,
    serverSide: true,
    ajax: "/users/users-activity",
    columns: [
        {
            "data": 'DT_RowIndex',
            orderable: false,
            searchable: false
        },
        {
            data: 'nama',
            name: 'nama'
        },
        {
            data: 'gudang',
            name: 'gudang'
        },
        {
            data: 'alamat',
            name: 'alamat'
        },
        {
            data: 'kontak',
            name: 'kontak'
        },
        {
            data: 'tanggal_logout',
            name: 'tanggal_logout'
        },
    ]
});

});
    </script>
@endpush
