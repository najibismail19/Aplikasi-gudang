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
                    <div class="col-md-4 mb-3">
                        <div class="text-center">
                          <img class="profile-user-img img-fluid img-circle" style="width: 17.5rem; height:17.5rem;"


                            @php
                                $gambar = "default.png";
                                if ($user->gambar_profile != null) {
                                    $gambar = $user->gambar_profile;
                                }
                            @endphp
                               src="{{ url("/storage/profiles/" . $gambar) }}" alt="User profile picture" >
                               {{-- <h3 class="profile-username text-center">{{ $user->nama }}</h3>

                               <p class="text-muted text-center">{{ $user->email }}</p> --}}
                        </div>
                    </div>
                    <div class="col-md-7">

                      <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Nama Lengkap</b> <p class="float-right">{{ $user->nama }}</p>
                        </li>
                        <li class="list-group-item">
                            <b>Email</b> <p class="float-right">{{ $user->email }}</p>
                        </li>
                        <li class="list-group-item">
                            <b>Jabatan</b> <p class="float-right">{{ $user->jabatan->nama_jabatan }}</p>
                        </li>
                        <li class="list-group-item">
                            <b>Tempat Gudang</b> <p class="float-right">{{ $user->gudang->nama_gudang }}</p>
                        </li>
                        <li class="list-group-item">
                          <b>Nomor Hp</b> <p class="float-right">{{ $user->kontak }}</p>
                        </li>
                        <li class="list-group-item">
                          <b>Alamat</b> <p class="float-right">{{ $user->alamat }}</p>
                        </li>
                        <li class="list-group-item">
                          <b>Jenis Kelamin</b> <p class="float-right">{{ $user->gender ?? "-"}}</p>
                        </li>
                        <li class="list-group-item">
                          <b>Usia</b> <p class="float-right">{{ $usia}} Tahun</p>
                        </li>
                        <li class="list-group-item">
                          <b>Tanggal Lahir</b> <p class="float-right">{{ $tanggal_lahir}}</p>
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
        <div class="modal-lg modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Search Penerimaan</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/users/update" id="formUpdateUser" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="inputEmail3" class="col-form-label">Photo Profile</label>
                                <input type="file" class="form-control" id="gambar_profile" name="gambar_profile">
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="img-holder mb-2" style="width: 100%;">
                                    <img id="img" class="img-fluid rounded-circle" style="max-width:100%;">
                                </div>
                                <div class="col-md-">
                                    <a class="btn btn-danger mb-3" id="clearInputFileProfile">Clear</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nik" class="col-form-label">Nik</label>
                                <input type="text" class="form-control" id="nik" name="nik" placeholder="NIK" value="{{ getNik() }}" readonly>
                                <small class="text-danger error_text nik_error"></small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="inputEmail3" class="col-form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                                <small class="text-danger error_text email_error"></small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="inputEmail3" class="col-form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lengkap">
                                <small class="text-danger error_text nama_error"></small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="inputEmail3" class="col-form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat">
                                <small class="text-danger error_text alamat_error"></small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="inputEmail3" class="col-form-label">Kontak</label>
                                <input type="number" class="form-control" id="kontak" name="kontak" placeholder="No HP">
                                <small class="text-danger error_text kontak_error"></small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_lahir" class="col-form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                                <small class="text-danger error_text tanggal_lahir_error"></small>
                            </div>
                        </div>

                    </div>
                    <div class="mb-3" style="float: right">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="buttonAddItem" class="btn btn-primary">Save</button>
                    </div>
                </form>
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

        feather.replace();

        $(document).ready(function () {
            $("#img").attr("src", "/storage/profiles/default.png" );
        });

        $(document).on("click", "#clearInputFileProfile", function () {
                var form = $(this).closest("form");
                $(form).find('input[type="file"]').val("");
                $(form).find(".img-holder").html('<img src="/storage/profiles/default.png" class="img-fluid rounded-circle" style="max-width:100%;"/>');
            });

        $(".edit-profile").on("click", function () {
            $("#formUpdateUser").find("input").each((i) => $(this).val(" "));
            $("#modalEditProfile").modal("show");

            $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
            url : "/profile",
            dataType : "json",
            success: response => {
                console.log(response);
                $.each(response.data, function (key, value) {
                    $("#formUpdateUser").find("#" + key + "").val(value);
                });

                },
                error: function(xhr,textStatus,thrownError) {
                alert(xhr + "\n" + textStatus + "\n" + thrownError);
                }
            });
        });

        $(".ganti-password").on("click", function () {
            $("#modalGantiPassword").modal("show");
        });

        $("input[type=file][name=gambar_profile]").val("");
            $("input[type=file][name=gambar_profile]").on("change", function () {
                var img_path = $(this)[0].value;
                var img_holder = $(".img-holder");
                var extension = img_path.substring(img_path.lastIndexOf(".") + 1).toLowerCase();

                if(extension == "jpeg" || extension == "jpg" || extension == "png") {
                    if(typeof(FileReader) != "undefined") {
                        var render = new FileReader();
                        render.onload = function (e) {
                               img_holder.empty();
                                $("<img/>", {"src":e.target.result,"class":"img-fluid  rounded-circle","style":"max-width:100%; max-width:8rem;"}).appendTo(img_holder);
                                console.log(e.target.result);
                        }
                        img_holder.show();
                        render.readAsDataURL($(this)[0].files[0]);
                    } else {
                       $(img_holder).html("this browser this not support FileReader");
                    }
                } else {
                    $(img_holder).empty();
                }
            });

            $(document).on("submit", "#formUpdateUser", function(e){
                e.preventDefault();
                let form = this;
                $.ajax({
                    headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                    url : $(this).attr("action"),
                    method : $(this).attr("method"),
                    enctype: 'multipart/form-data',
                    data : new FormData(form),
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType : "json",
                    success: data => {
                        console.log(data);
                        if(data.error) {
                            $.each(data.error, function (prefix, val) {
                                $(form).find("small." + prefix + "_error").text(val[0]);
                                $(form).find("#"+ prefix + "").addClass("is-invalid");
                            })
                        }
                        if(data.success){
                            $("#modalEditProfile").modal("hide");
                                Swal.fire({
                                    icon: 'success',
                                    title: 'success',
                                    text:  data.success,
                            })
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Tampilkan pesan error di konsol
                    }
                });
        });
    </script>
@endpush
