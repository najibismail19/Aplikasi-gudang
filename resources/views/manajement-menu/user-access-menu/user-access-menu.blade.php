@extends('template.template')

@section('title')
    Sub Menu
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
              <div class="card-header">
                <a href="{{ url("/pembelian/tambah-pembelian") }}" class="btn btn-success" style="float: right;"> <i class="align-middle" data-feather="plus"></i>&nbsp;Add Pembelian</a>
              </div>
              <div class="card-body pb-2">
                <div class="table-responsive p-2">
                  <table class="table table-bordered table-striped align-items-center mb-0 data-access-jabatan" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th>ID Jabatan</th>
                        <th>Nama Jabatan</th>
                        <th>Lihat Akses</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($jabatan as $j)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $j->id_jabatan }}</td>
                                <td>{{ $j->nama_jabatan }}</td>
                                <td><a href="{{ url("manajement-menu/user-access-menu") . "/" .  $j->id_jabatan }}" class="btn btn-primary">Lihat</a></td>

                            </tr>
                        @endforeach
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
           $(function () {
                var table = $('.data-access-jabatan').DataTable({
                });
            });
    </script>
@endpush
