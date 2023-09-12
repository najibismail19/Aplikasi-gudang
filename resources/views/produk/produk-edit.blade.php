<div class="modal fade" id="modalEditProduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title" id="staticBackdropLabel">Edit Produk</h2>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST"  enctype="multipart/form-data" id="formEditProduk">
                <div class="mb-3">
                    <label for="kode_produk" class="form-label">Kode Produk*</label>
                    <input type="text" id="kode_produk" class="form-control" name="kode_produk" placeholder="Kode Produk" readonly>
                    <small class="text-danger error_text kode_produk_error"></small>
                  </div>
                  <div class="mb-3">
                    <label for="nama" class="form-label">Nama*</label>
                    <input type="text" id="nama" class="form-control" name="nama" placeholder="Nama Produk">
                    <small class="text-danger error_text nama_error"></small>
                  </div>
                  <div class="mb-3">
                    <label for="satuan" class="form-label">Satuan*</label>
                    <input type="text" id="satuan" class="form-control" name="satuan" placeholder="Satuan">
                    <small class="text-danger error_text satuan_error"></small>
                  </div>
                  <div class="mb-3">
                    <label for="harga" class="form-label">Harga*</label>
                    <input type="number" id="harga" class="form-control" name="harga" placeholder="Harga">
                    <small class="text-danger error_text harga_error"></small>
                 </div>
                 <div class="mb-3">
                    <label for="harga" class="form-label">Jenis*</label>
                    <input type="hidden" id="jenis" name="jenis">
                    <input type="text" id="jenis_produk" class="form-control" placeholder="Jenis Barang" readonly>
                    <small class="text-danger error_text jenis_error"></small>
                 </div>
                 <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar(Optional)</label>
                    <input type="file" id="gambar" name="gambar" class="form-control">
                    <small class="text-danger error_text gambar_error"></small>
                </div>
                <div class="img-holder mb-2" style="width: 50%;">
                </div>
                <a class="btn btn-danger mb-3" id="clearInputFileProduct">Clear</a>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi(Optional)</label>
                    <textarea class="form-control error_text" placeholder="Deskripsi..." name="deskripsi" id="deskripsi" style="height: 100px"></textarea>
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
    <script>
        $(document).on("click", ".editProduk", function () {
                let kode_produk = $(this).attr("data-kode-produk");
                let nama = $(this).attr("data-nama");
                let satuan = $(this).attr("data-satuan");
                let harga = $(this).attr("data-harga");
                let jenis = $(this).attr("data-jenis");
                let gambar = $(this).attr("data-gambar");
                let deskripsi = $(this).attr("data-deskripsi");

                let form = $("#formEditProduk");
                $(form).find("input").removeClass("is-invalid");
                $(form).find(".error_text").html("");
                $(form).find("#kode_produk").val(kode_produk);
                $(form).find("#nama").val(nama);
                $(form).find("#satuan").val(satuan);
                $(form).find("#harga").val(harga);
                $(form).find("#deskripsi").val(deskripsi);
                $(form).find("#jenis").val(jenis);
                let tipe_jenis = jenis == 0 ? "Barang Mentah" : "Barang Jadi";
                $(form).find("#jenis_produk").val(tipe_jenis);
                if($.trim(gambar) != "") {
                    $(form).find(".img-holder").html('<img src="/storage/photos/produk/' + gambar + '" class="img-fluid" style="max-width:100%;"/>');
                } else {
                    $(form).find(".img-holder").html('<img src="/storage/photos/produk/default.png" class="img-fluid" style="max-width:100%;"/>');
                }
                $("#modalEditProduk").modal("show");
            });

                    $(document).on("submit", "#formEditProduk", function(e){
                        e.preventDefault();
                                let kode_produk = $(this).find("#kode_produk").val();
                                let form = this;
                                $.ajax({
                                    headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                                    url : "/produk/" + kode_produk,
                                    method : $(this).attr("method"),
                                    enctype: 'multipart/form-data',
                                    async: false,
                                    data : new FormData(form),
                                    cache : false,
                                    contentType: false,
                                    processData: false,
                                    dataType : "json",
                                    beforeSend: () => {
                                        $(form).find("small.error_text").text("");
                                        $(form).find(".form-control").removeClass("is-invalid");
                                    },
                                    success: data => {
                                        if(data.error) {
                                            $.each(data.error, function (prefix, val) {
                                                $(form).find("small." + prefix + "_error").text(val[0]);
                                                $(form).find("#" + prefix).addClass("is-invalid");
                                            })
                                        }

                                        if(data["success"]){
                                            $("#modalEditProduk").modal("hide");
                                            setTimeout(() => {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'success',
                                                    text:  data["success"],
                                                })
                                            }, 2000);
                                            $('.data-produk').DataTable().ajax.reload(null, false);
                                        }

                                    },
                                    complete: () => {
                                    },
                                    error: function(xhr,textStatus,thrownError) {
                                    alert(xhr + "\n" + textStatus + "\n" + thrownError);
                                    }
                                });
                        });

                        //  $("input[type=file][name=image]").val("");
                        $("#formEditProduct").find("input[type=file][name=image]").val("");
                         $("#formEditProduct input[type=file][name=image]").on("change", function () {
                             var formEdit = $("#formEditProduct");
                             var img_path = $(this)[0].value;
                             var img_holder = $(formEdit).find(".img-holder");
                             var extension = img_path.substring(img_path.lastIndexOf(".") + 1).toLowerCase();

                             if(extension == "jpeg" || extension == "jpg" || extension == "png") {
                                 if(typeof(FileReader) != "undefined") {
                                     var render = new FileReader();
                                     render.onload = function (e) {
                                            img_holder.empty();
                                             $("<img/>", {"src":e.target.result,"class":"img-fluid","style":"max-width:100%;"}).
                                             appendTo(img_holder);
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
    </script>
