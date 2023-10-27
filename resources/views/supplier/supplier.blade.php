@extends('template.template')

@section('title')
    Produk Jadi
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
              <div class="card-header">
                <a class="btn btn-success" id="tambahSupplier"> <i class="align-middle" data-feather="plus"></i>&nbsp;Add Supplier</a>
              </div>
              <div class="card-body pb-2">
                <div class="table-responsive p-2">
                  <table class="table table-bordered table-striped align-items-center mb-0 data-supplier" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th  style="width: 15%;">Code Supplier</th>
                        <th style="width: 15%;">Nama</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th>Deskripsi</th>
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
          $(function () {

            var table = $('.data-supplier').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/supplier",
                columns: [
                    {
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id_supplier',
                        name: 'id_supplier'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
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
                        data: 'deskripsi',
                        name: 'deskripsi'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                drawCallback: function( settings ) {
                    feather.replace();
                }
            });
        });

        $(document).ready(function () {

            $.ajax({
                headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                url : "/supplier/get-modal-add",
                dataType : "json",
                success: response => {
                    console.log(response);
                    if(response.success) {
                        $("body").append(response.modal)
                    }
                },
                error: (xhr,textStatus,thrownError) => {
                    alert(xhr + "\n" + textStatus + "\n" + thrownError);
                }
            })

            $.ajax({
                headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                url : "/supplier/get-modal-edit",
                dataType : "json",
                success: response => {
                    if(response.success) {
                        $("body").append(response.modal)
                    }
                },
                error: (xhr,textStatus,thrownError) => {
                    alert(xhr + "\n" + textStatus + "\n" + thrownError);
                }
            })

            $(document).on('click', '.hapusSupplier', function() {
            var id_supplier = $(this).attr('id');
            Swal.fire({
                title: 'Yakin Ingin Menghapus?',
                text: "Hapus Supplier " + id_supplier,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                        url: "/supplier/" + id_supplier,
                        type: "DELETE",
                        success: response => {

                            if(response.success) {
                                Swal.fire({
                                icon: 'success',
                                title: 'success',
                                text:  response["success"],
                            })
                                 $('.data-supplier').DataTable().ajax.reload(null, false);
                            }

                            if(response.error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'error',
                                    text:  response["error"],
                                })
                                    $('.data-supplier').DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            })
        });
        });
    </script>
@endpush
