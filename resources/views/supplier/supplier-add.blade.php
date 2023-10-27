<div class="modal fade" id="modalTambahSupplier" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title" id="staticBackdropLabel">Tambah Supplier</h2>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" action="/supplier" id="formTambahSupplier">
                <div class="mb-3">
                    <label for="id_supplier" class="form-label">ID Supplier*</label>
                    <input type="text" id="id_supplier" class="form-control" name="id_supplier" placeholder="ID Supplier">
                    <small class="text-danger error_text id_supplier_error"></small>
                  </div>
                  <div class="mb-3">
                    <label for="nama" class="form-label">Nama*</label>
                    <input type="text" id="nama" class="form-control" name="nama" placeholder="Nama Supplier">
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
            $("#tambahSupplier").on("click", function () {
                $("#formTambahSupplier").find("input").removeClass("is-invalid");
                $("#formTambahSupplier").find("small").html("");
                $("#modalTambahSupplier").modal("show");
            });

            $(document).ready(function () {
                $('input').attr('autocomplete', 'off');
            })

            $(document).on("submit", "#formTambahSupplier", function(e){
                let form = $(this);
                e.preventDefault();
                $.ajax({
                    headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                    url : $(this).attr("action"),
                    method : $(this).attr("method"),
                    data : $(this).serialize(),
                    dataType : "json",
                    success: data => {
                        console.log(data);
                        if(data.error) {
                            $.each(data.error, function (prefix, val) {
                                $(form).find("small." + prefix + "_error").text(val[0]);
                                $(form).find("#"+ prefix + "").addClass("is-invalid");
                            })
                        }
                        if(data["success"]){
                            $("#modalTambahSupplier").modal("hide");
                                Swal.fire({
                                    icon: 'success',
                                    title: 'success',
                                    text:  data["success"],
                                })
                            $('.data-supplier').DataTable().ajax.reload(null, false);
                        }
                    },
                    error: function(xhr,textStatus,thrownError) {
                    alert(xhr + "\n" + textStatus + "\n" + thrownError);
                    }
                });
            });

    </script>
