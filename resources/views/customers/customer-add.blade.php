<div class="modal fade" id="modalTambahCustomer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-lg modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title" id="staticBackdropLabel">Tambah Customer</h2>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" action="/customers" id="formTambahCustomer">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_customer" class="form-label">ID Customer*</label>
                        <input type="text" id="id_customer" class="form-control" name="id_customer" placeholder="ID Customer">
                        <small class="text-danger error_text id_customer_error"></small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label">Nama*</label>
                        <input type="text" id="nama" class="form-control" name="nama" placeholder="Nama Produk">
                        <small class="text-danger error_text nama_error"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="kontak" class="form-label">Kontak*</label>
                      <input type="number" id="kontak" class="form-control" name="kontak" placeholder="Kontak">
                      <small class="text-danger error_text kontak_error"></small>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="alamat" class="form-label">Alamat*</label>
                      <input type="text" id="alamat" class="form-control" name="alamat" placeholder="Alamat">
                      <small class="text-danger error_text alamat_error"></small>
                   </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                      <label for="email" class="form-label">Email*</label>
                      <input type="text" id="email" class="form-control" name="email" placeholder="Email">
                      <small class="text-danger error_text email_error"></small>
                   </div>
                    <div class="col-md-6 mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi(Optional)</label>
                        <textarea class="form-control error_text" placeholder="Deskripsi..." name="deskripsi" id="deskripsi" style="height: 100px"></textarea>
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
    <script>
            $(document).ready(function () {
                $('input').attr('autocomplete', 'off');
            })

            $("#tambahCustomer").on("click", function () {

                let form = $("#formTambahCustumer");
                $("#modalTambahCustomer").modal("show");
            });

            $(document).on("submit", "#formTambahCustomer", function(e){
                e.preventDefault();
                let form = this;
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
                        if(data.success){
                            $("#modalTambahCustomer").modal("hide");
                                Swal.fire({
                                    icon: 'success',
                                    title: 'success',
                                    text:  data.success,
                                })
                            $('.data-customers').DataTable().ajax.reload(null, false);
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log("Error Thrown: " + errorThrown);
                        console.log("Text Status: " + textStatus);
                        console.log("XMLHttpRequest: " + XMLHttpRequest);
                        console.warn(XMLHttpRequest.responseText)
                    }
                });
            });

            // $("input[type=file][name=gambar]").val("");
            // $("input[type=file][name=gambar]").on("change", function () {
            //     var img_path = $(this)[0].value;
            //     var img_holder = $(".img-holder");
            //     var extension = img_path.substring(img_path.lastIndexOf(".") + 1).toLowerCase();

            //     if(extension == "jpeg" || extension == "jpg" || extension == "png") {
            //         if(typeof(FileReader) != "undefined") {
            //             var render = new FileReader();
            //             render.onload = function (e) {
            //                    img_holder.empty();
            //                     $("<img/>", {"src":e.target.result,"class":"img-fluid","style":"max-width:100%;"}).
            //                     appendTo(img_holder);
            //             }
            //             img_holder.show();
            //             render.readAsDataURL($(this)[0].files[0]);
            //         } else {
            //            $(img_holder).html("this browser this not support FileReader");
            //         }
            //     } else {
            //         $(img_holder).empty();
            //     }
            // });
    </script>
