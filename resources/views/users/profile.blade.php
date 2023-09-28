@extends('template.template')
@section('title')
    Profile
@endsection
@section('content')
    <div class="row justify-content-between">
        <div class="col-md-12">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="row p-5">
                    <div class="col-md-4">
                        <div class="text-center">
                          <img class="profile-user-img img-fluid img-circle"
                               src="{{ url("/assets/dist/img/user4-128x128.jpg") }}"
                               alt="User profile picture">
                               <h3 class="profile-username text-center">{{ $user->nama }}</h3>

                               <p class="text-muted text-center">{{ $user->gudang->nama_gudang }}</p>
                        </div>
                    </div>
                    <div class="col-md-7">

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
                          <a class="btn btn-secondary ganti-password col-md-5 m-2"><i class="fas fa-edit mr-2"></i>Ganti Password</a>
                          <a class="btn btn-primary edit-profile col-md-5 m-2"><i class="fas fa-edit mr-2"></i>Ubah Profile</a>
                      </div>
                    </div>
                </div>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>


    <div class="modal fade" id="modalEditProfile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-xl modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Search Penerimaan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="card-body">

                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Photo Profile</label>
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
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>


      <div class="modal fade" id="modalGantiPassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-lg modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Search Penerimaan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="card-body">
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Old Password*</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputEmail3" placeholder="Nama Lengkap">
                        </div>
                      </div>
                      <hr>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">New Password*</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputEmail3" placeholder="Nama Lengkap">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-4 col-form-label">Password Confirm*</label>
                        <div class="col-sm-8">
                          <input type="password" class="form-control" id="inputEmail3" placeholder="Nama Lengkap">
                        </div>
                      </div>

                    </div>
                    <!-- /.card-body -->
                  </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
@endsection

@push('script')
    <script>
        $(".edit-profile").on("click", function () {
            $("#modalEditProfile").modal("show");
        });

        $(".ganti-password").on("click", function () {
            $("#modalGantiPassword").modal("show");
        });
    </script>
@endpush
