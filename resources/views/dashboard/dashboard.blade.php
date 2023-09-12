@extends('template.template')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
              <div class="card-header">
                <a class="btn btn-success"  id="addItem"> <i class="align-middle" data-feather="plus"></i>&nbsp;Add Items</a>
              </div>
              <div class="card-body pb-2">
                <div class="table-responsive p-2">
                  <table class="table align-items-center mb-0 data-items" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 7%;">No</th>
                        <th>Code Item</th>
                        <th>Name</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Description</th>
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
