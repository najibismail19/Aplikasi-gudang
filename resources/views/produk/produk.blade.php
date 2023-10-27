@extends('template.template')

@section('title')
    Produk Jadi
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
              <div class="card-header">
                <a class="btn btn-success" id="tambahProduk"> <i class="align-middle" data-feather="plus"></i>&nbsp;Add Items</a>
              </div>
              <div class="card-body pb-2">
                <div class="table-responsive p-2">
                  <table class="table table-bordered table-striped align-items-center mb-0 data-produk" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th  style="width: 15%;">Code Produk</th>
                        <th style="width: 15%;">Nama</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Jenis</th>
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

            var table = $('.data-produk').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/produk",
                columns: [
                    {
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'kode_produk',
                        name: 'kode_produk'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'satuan',
                        name: 'satuan'
                    },
                    {
                        data: 'harga',
                        name: 'harga'
                    },
                    {
                        data: 'jenis',
                        name: 'jenis'
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
                url : "/produk/get-modal-add",
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
                url : "/produk/get-modal-edit",
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

            $(document).on("click", "#clearInputFileProduct", function () {
                var form = $(this).closest("form");
                $(form).find('input[type="file"]').val("");
                $(form).find(".img-holder").html('<img src="/storage/photos/produk/default.png" class="img-fluid" style="max-width:100%;"/>');
            });

            $(document).on('click', '.hapusProduk', function() {
            var kode_produk = $(this).attr('id');
            Swal.fire({
                title: 'Yakin Ingin Menghapus?',
                text: "Hapus Kode produk " + kode_produk,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                        url: "/produk/" + kode_produk,
                        type: "DELETE",
                        success: response => {

                            if(response.success) {
                                Swal.fire({
                                icon: 'success',
                                title: 'success',
                                text:  response["success"],
                            })
                                 $('.data-produk').DataTable().ajax.reload(null, false);
                            }

                            if(response.error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'error',
                                    text:  response["error"],
                                })
                                    $('.data-produk').DataTable().ajax.reload(null, false);
                            }
                        }
                    });
                }
            })
        });
        });


        $(document).on("click", ".showImage", function () {
            let image = $(this).attr("data-image");
            let nama = $(this).attr("data-nama");
            let kode_produk = $(this).attr("data-kode_produk");
            let file = (image != "") ? image : "default.png";
            Swal.fire({
                title: kode_produk,
                text: nama,
                imageUrl: '/storage/photos/produk/' + file,
                imageWidth: 500,
                imageHeight: 300,
                imageAlt: 'Custom image',
            })
        });
    </script>
@endpush
