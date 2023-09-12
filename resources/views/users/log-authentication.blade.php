@extends('template.template')

@section('title')
    Log Authentication
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
              <div class="card-header">

              </div>
              <div class="card-body pb-2">
                <div class="table-responsive p-2">
                  <table class="table align-items-center mb-0 data-log-authentication" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th  style="width: 15%;">Name</th>
                        <th style="width: 15%;">Tanggal Login</th>
                        <th>IP</th>
                        <th style="width: 15%;">Tanggal Logout</th>
                        <th style="width: 40%;">Device</th>
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

            var table = $('.data-log-authentication').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/users/log-authentication",
                columns: [
                    {
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_karyawan',
                        name: 'karyawan.nama'
                    },
                    {
                        data: 'tanggal_login',
                        name: 'tanggal_login'
                    },
                    {
                        data: 'ip',
                        name: 'ip'
                    },
                    {
                        data: 'tanggal_logout',
                        name: 'tanggal_logout'
                    },
                    {
                        data: 'device',
                        name: 'device'
                    },
                ]
            });

            });
    </script>
@endpush
