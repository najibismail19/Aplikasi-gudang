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
                  <table class="table table-bordered table-striped align-items-center mb-0 data-sub-menu" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th  style="width: 15%;">Sub Menu ID</th>
                        <th  style="width: 15%;">Menu</th>
                        <th style="width: 15%;">Title</th>
                        <th style="width: 15%;">Url</th>
                        <th>Icon</th>
                        <th>Active</th>
                        <th style="width: 12%; float:center;">Action</th>
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

            var table = $('.data-sub-menu').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/manajement-menu/user-sub-menu/get-data",
                columns: [
                    {
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'sub_menu_id',
                        name: 'sub_menu_id'
                    },
                    {
                        data: 'menu',
                        name: 'menu.nama'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'url',
                        name: 'url'
                    },
                    {
                        data: 'icon',
                        name: 'icon'
                    },
                    {
                        data: 'is_active',
                        name: 'is_active'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endpush
