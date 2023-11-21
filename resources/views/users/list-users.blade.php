@extends('template.template')
@section('title')
    List Users
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
              <div class="card-header">
                    <a class="btn btn-success" id="addUser"><i class="align-middle" data-feather="plus"></i>&nbsp;Add User</a>
              </div>
              <div class="card-body pb-2">
                <div class="table-responsive p-2">
                  <table class="table align-items-center mb-0 data-users" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 7%;">No</th>
                        <th>NK</th>
                        <th>Nama</th>
                        <th>Gudang</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th>Jabatan</th>
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


<!-- Modal -->
<div class="modal fade" id="modalAddUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-lg modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Add User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ url("/users") }}" id="formAddUser">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kode_produk" class="form-label">NIK*</label>
                        <input type="text" id="nik" class="form-control" name="nik" placeholder="NIK">
                        <small class="text-danger error_text nik_error"></small>
                      </div>
                      <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label">Nama*</label>
                        <input type="text" id="nama" class="form-control" name="nama" placeholder="Nama">
                        <small class="text-danger error_text nama_error"></small>
                      </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email*</label>
                        <input type="text" id="email" class="form-control" name="email" placeholder="Email">
                        <small class="text-danger error_text email_error"></small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kontak" class="form-label">Kontak*</label>
                        <input type="number" id="kontak" class="form-control" name="kontak" placeholder="Kontak">
                        <small class="text-danger error_text kontak_error"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="jabatan" class="form-label">Gudang*</label>
                      <select class="custom-select" id="id_gudang" name="id_gudang">
                        <option value="">-- Pilih Gudang --</option>
                          @foreach ($gudang as $g)
                              <option value="{{ $g->id_gudang }}">{{ $g->nama_gudang }}</option>
                          @endforeach
                      </select>
                      <small class="text-danger error_text id_gudang_error"></small>
                   </div>

                    <div class="col-md-6 mb-3">
                      <label for="id_jabatan" class="form-label">Jabatan*</label>
                      <select class="custom-select" id="id_jabatan" name="id_jabatan">
                          <option value="">-- Pilih Gudang --</option>
                          @foreach ($jabatan as $j)
                              <option value="{{ $j->id_jabatan }}">{{ $j->nama_jabatan }}</option>
                          @endforeach
                      </select>
                      <small class="text-danger error_text id_jabatan_error"></small>
                   </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="jabatan" class="form-label">Jenis Kelamin*</label>
                      <select class="custom-select" id="gender" name="gender">
                        <option value="">-- Pilih Jenis Kelamin --</option>
                              <option value="Laki-laki">Laki-laki</option>
                              <option value="Perempuan">Perempuan</option>
                      </select>
                      <small class="text-danger error_text gender_error"></small>
                   </div>

                    <div class="col-md-6 mb-3">
                      <label for="id_jabatan" class="form-label">Tanggal Lahir*</label>
                      <input type="date" id="tanggal_lahir" class="form-control" name="tanggal_lahir">
                      <small class="text-danger error_text tanggal_lahir_error"></small>
                   </div>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat(Optional)</label>
                    <textarea class="form-control error_text" placeholder="Alamat..." name="alamat" id="alamat" style="height: 100px"></textarea>
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

@push('script')
    {{-- <script>

      
    </script> --}}

    <script>
    $(document).on("click", "#addUser", function () {
        $("#modalAddUser").modal("show");
    });

    $(document).ready(function () {
            $('.data-users').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/users",
                columns: [
                    {
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'id_gudang',
                        name: 'id_gudang'
                    },
                    {
                        data: 'kontak',
                        name: 'kontak'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'id_jabatan',
                        name: 'id_jabatan'
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


$(document).on("submit", "#formAddUser", function(e){
   
  e.preventDefault();
  let form = $(this);
        $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
            url : $(form).attr("action"),
            method : $(form).attr("method"),
            data : $(form).serialize(),
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
                    $("#modalAddUser").modal("hide");
                        Swal.fire({
                            icon: 'success',
                            title: 'success',
                            text:  data.success,
                    })

                    $('.data-users').DataTable().ajax.reload(null, false);
                }
            },
            error: function(xhr,textStatus,thrownError) {
            alert(xhr + "\n" + textStatus + "\n" + thrownError);
            }
        });

        
});

$(document).on('click', '.hapusKaryawan', function() {
            var nik = $(this).attr('id');
            Swal.fire({
                title: 'Yakin Ingin Menghapus?',
                text: "Hapus karyawan " + nik,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                        url: "/users/" + nik,
                        type: "DELETE",
                        success: response => {

                            if(response.success) {
                                Swal.fire({
                                icon: 'success',
                                title: 'success',
                                text:  response["success"],
                            })
                                 $('.data-users').DataTable().ajax.reload(null, false);
                            }

                            if(response.error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'error',
                                    text:  response["error"],
                                })
                                    $('.data-users').DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            })
        });
</script>
@endpush
