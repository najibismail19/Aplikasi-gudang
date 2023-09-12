@extends('template.template')
@section('title')
    Profile
@endsection
@section('content')
    <div class="row justify-content-between">
        <div class="col-md-5">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{ url("/assets/dist/img/user4-128x128.jpg") }}"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ $user->nama }}</h3>

                <p class="text-muted text-center">{{ $user->gudang->nama_gudang }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Nomor Hp</b> <p class="float-right">{{ $user->kontak }}</p>
                  </li>
                  <li class="list-group-item">
                    <b>Alamat</b> <p class="float-right">{{ $user->alamat }}</p>
                  </li>
                  <li class="list-group-item">
                    <b>Jabatan</b> <p class="float-right">{{ $user->jabatan->nama_jabatan }}</p>
                  </li>
                  <li class="list-group-item">
                    <b>Email</b> <p class="float-right">{{ $user->email }}</p>
                  </li>
                </ul>
                <div class="row justify-content-between p-2">
                    <a class="btn btn-secondary edit-profile col-md-5"><i class="fas fa-edit mr-2"></i>Ganti Password</a>
                    <a class="btn btn-primary edit-profile col-md-5"><i class="fas fa-edit mr-2"></i>Ubah Profile</a>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-7">
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">

                </div>
                <!-- /.card-body -->
              </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditProfile">
        <div class="modal-dialog">
          <div class="modal-content bg-info">
            <div class="modal-header">
              <h4 class="modal-title">Info Modal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="card-body">

                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                          <input type="file" class="form-control" id="inputEmail3" placeholder="Nama Lengkap">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputEmail3" placeholder="Nama Lengkap">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputEmail3" placeholder="Alamat">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Kontak</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" id="inputEmail3" placeholder="No HP">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
                        </div>
                      </div>
                    </div>
                    <!-- /.card-body -->
                  </form>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-outline-light">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
@endsection


@push('script')
    <script>
        $(".edit-profile").on("click", function () {
            $("#modalEditProfile").modal("show");
        });
    </script>
@endpush
