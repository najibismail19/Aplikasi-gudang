<div class="modal fade" id="modalEditSupplier" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title" id="staticBackdropLabel">Edit Supplier</h2>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" id="formEditSupplier">
                <div class="mb-3">
                    <label for="id_supplier" class="form-label">ID Supplier*</label>
                    <input type="text" id="id_supplier" class="form-control" name="id_supplier" placeholder="ID Supplier" readonly>
                    <small class="text-danger error_text id_supplier_error"></small>
                  </div>
                  <div class="mb-3">
                    <label for="nama" class="form-label">Nama*</label>
                    <input type="text" id="nama" class="form-control" name="nama" placeholder="Nama Produk">
                    <small class="text-danger error_text nama_error"></small>
                  </div>
                  <div class="mb-3">
                    <label for="kontak" class="form-label">Kontak*</label>
                    <input type="number" id="kontak" class="form-control" name="kontak" placeholder="Kontak">
                    <small class="text-danger error_text kontak_error"></small>
                  </div>
                  <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat*</label>
                    <input type="text" id="alamat" class="form-control" name="alamat" placeholder="Alamat">
                    <small class="text-danger error_text alamat_error"></small>
                 </div>
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
            $(".editSupplier").on("click", function () {
                let id_supplier = $(this).attr("data-id_supplier");
                let nama = $(this).attr("data-nama");
                let kontak = $(this).attr("data-kontak");
                let alamat = $(this).attr("data-alamat");
                let deskripsi = $(this).attr("data-deskripsi");

                let form = $("#formEditSupplier");

                $(form).find("input").removeClass("is-invalid");
                $(form).find(".error_text").html("");

                $(form).find("#id_supplier").val(id_supplier);
                $(form).find("#nama").val(nama);
                $(form).find("#kontak").val(kontak);
                $(form).find("#alamat").val(alamat);
                $(form).find("#deskripsi").val(deskripsi);

                $("#modalEditSupplier").modal("show");
            });

                    $(document).on("submit", "#formEditSupplier", function(e){
                        e.preventDefault();
                                let id_supplier = $(this).find("#id_supplier").val();
                                let form = this;
                                $.ajax({
                                    headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                                    url : "/supplier/" + id_supplier,
                                    method : $(this).attr("method"),
                                    data : $(this).serialize(),
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
                                            $("#modalEditSupplier").modal("hide");
                                            setTimeout(() => {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'success',
                                                    text:  data["success"],
                                                })
                                            }, 2000);
                                            $('.data-supplier').DataTable().ajax.reload(null, false);
                                        }

                                    },
                                    complete: () => {
                                    },
                                    error: function(xhr,textStatus,thrownError) {
                                    alert(xhr + "\n" + textStatus + "\n" + thrownError);
                                    }
                                });
                        });
    </script>
