@extends('template.template')

@section('title')
<br>
<a href="{{ url("/manajement-menu/user-access-menu") }}" style="float: left;" class="btn btn-warning"><i class="fa-solid fa-arrow-left"></i>&nbsp;Back</a>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
              <div class="card-header">
                <div class="row p-3">
                    <div class="col-md-10">
                        <h3>User Access Menu : {{ $jabatan->nama_jabatan }}</h3>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ url("/pembelian/tambah-pembelian") }}" class="btn btn-success" style="float: right;"> <i class="align-middle" data-feather="plus"></i>&nbsp;Add Pembelian</a>
                    </div>
                </div>
              </div>
              <div class="card-body pb-2">
                <div class="table-responsive p-2">
                  <table class="table table-bordered table-striped align-items-center mb-0 data-role-access" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th>Title</th>
                        <th>Menu</th>
                        <th>Url</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($sub_menu as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->title }}</td>
                                <td>{{ $s->menu->nama }}</td>
                                <td>{{ $s->url }}</td>
                                <td>
                                    <div class="form-group" style="text-align: center;">
                                        <input class="form-check-input" type="checkbox" data-id_jabatan="{{ $jabatan->id_jabatan }}" data-sub_menu_id="{{ $s->sub_menu_id }}" id="tambah_akses"
                                        @php
                                            $access = DB::table("user_access_menu")->where("id_jabatan", $jabatan->id_jabatan)->where("sub_menu_id", $s->sub_menu_id)->first();
                                        @endphp
                                        @if ($access)
                                            checked
                                        @endif
                                        >
                                        <label class="form-check-label" for="tambah_akses">
                                          Tambahkan Akses
                                        </label>
                                    </div>
                                </td>
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
                var table = $('.data-role-access').DataTable({
                });
            });

            $(document).on("click", "#tambah_akses",function () {
                // Mengecek apakah checkbox dicentang
                var isChecked = $("#tambah_akses").prop("checked");

                // Menggunakan if untuk menentukan tindakan berdasarkan status checkbox
                if (isChecked) {

                    $.ajax({
                        headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                        url : "/manajement-menu/user-access-menu",
                        method : "POST",
                        data : {
                            id_jabatan : $(this).attr("data-id_jabatan"),
                            sub_menu_id : $(this).attr("data-sub_menu_id")
                        },
                        success: response => {
                            if(response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'success',
                                    text:  response.success
                                });
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                                console.log("Error Thrown: " + errorThrown);
                                console.log("Text Status: " + textStatus);
                                console.log("XMLHttpRequest: " + XMLHttpRequest);
                                console.warn(XMLHttpRequest.responseText)
                        }
                    })

                } else {

                    
                    $.ajax({
                        headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                        url : "/manajement-menu/user-access-menu",
                        method : "DELETE",
                        data : {
                            id_jabatan : $(this).attr("data-id_jabatan"),
                            sub_menu_id : $(this).attr("data-sub_menu_id")
                        },
                        dataType : "json",
                        success: response => {
                            console.log(response);
                            if(response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'success',
                                    text:  response.success
                                });
                            }
                        },
                        error: (xhr,textStatus,thrownError) => {
                            alert(xhr + "\n" + textStatus + "\n" + thrownError);
                        }
                    })
  
                }
            });
    </script>
@endpush
