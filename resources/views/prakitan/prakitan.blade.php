@extends('template.template')

@section('title')
    Prakitan
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
              <div class="card-header">
                <a href="{{ url("/prakitan/tambah-prakitan") }}" class="btn btn-success"> <i class="align-middle" data-feather="plus"></i>&nbsp;Add Prakitan</a>
              </div>
              <div class="card-body pb-2">
                <div class="table-responsive p-2">
                  <table class="table table-striped  align-items-center mb-0 data-pembelian" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th  style="width: 15%;">No Prakitan</th>
                        <th style="width: 15%;">Kode Produk</th>
                        <th>Qty rencana</th>
                        <th>Qty hasil</th>
                        <th>Tanggal Rencana</th>
                        <th>Tanggal Aktuan</th>
                        <th>Nama Karyawan</th>
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
    </script>

@endpush
