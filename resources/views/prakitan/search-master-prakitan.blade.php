<!-- Modal -->
<div class="modal fade" id="modalMasterPrakitan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-lg modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Searh Master Prakitan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive p-2">
                <table class="table table-bordered table-striped align-items-center mb-0 data-search-master-prakitan" style="width: 100%">
                  <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 20%;">Kode Produk</th>
                        <th style="width: 20%;">Nama</th>
                        <th>Satuan</th>
                        <th>Jenis Produk</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($produk_master_prakitan as $produk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $produk->kode_produk }}</td>
                            <td>{{ $produk->nama }}</td>
                            <td>{{ $produk->satuan }}</td>
                            <td>{{ ($produk->jenis == 0 ) ? "Barang Mentah" : "Barang Jadi" }}</td>
                            <td>
                                <a class='btn btn-primary mx-1' id='pilihMasterPrakitan' data-kode_produk='{{$produk->kode_produk}}' data-nama_produk='{{$produk->nama}}' data-satuan='{{ $produk->satuan }}'><i class='fas fa-check'></i></a>
                            </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

<script>
$(document).on("click", "#searchMasterPrakitan", function () {
    // alert("berhasil!!!");
    $("#modalMasterPrakitan").modal("show");
});

$(document).on("keyup", "#qty_rencana", function () {
    $("#data-detail-prakitan tr").each(function(){
        var total = parseInt($(this).find("input[data-qty-produk]").val()) * parseInt($("#qty_rencana").val());
        $(this).find("input[data-qty-total]").val(total);
    });
});

$(document).on("click", "#pilihMasterPrakitan", function () {
    let kode_produk = $(this).attr("data-kode_produk");
    let nama_produk = $(this).attr("data-nama_produk");
    let satuan = $(this).attr("data-satuan");
    $("#kode_produk_jadi").val(kode_produk);
    $("#nama_produk_jadi").val(nama_produk);
    $("#jenis_produk").val("Barang Jadi");
    $("#satuan").val(satuan);

    // let qty = $("#qty_rencana").val();
    $.ajax({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
            url : "/prakitan/get-detail-master-prakitan/" + kode_produk,
            dataType : "json",
            success: response => {
                console.log(response);
            $("#data-detail-prakitan tr").remove();
                $.each(response.data, function (key, value) {
							$('#data-detail-prakitan').prepend(`<tr class="">
										<td>`+value.kode_produk+`</td>
										<td>`+value.nama+`</td>
										<td></td>
										<td><input type="text" data-qty-produk="`+ value.kode_produk +`" class="form-control" id="qty_`+ value.kode_produk +`"  placeholder="Cari Produk..." value="`+value.qty+`" readonly></td>
										<td><input type="number" class="form-control" data-qty-total="`+ value.kode_produk +`" id="total_qty_`+ value.kode_produk +`" placeholder="Total Qty" value="`+ $("#qty_rencana").val() * value.qty +`" readonly></td>
										</tr>`);
				})
                $("#modalMasterPrakitan").modal("hide");


            },
            error: (xhr,textStatus,thrownError) => {
                alert(xhr + "\n" + textStatus + "\n" + thrownError);
            }
        });
    // $.ajax({
    //         headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
    //         url : "/prakitan/get-detail-master-prakitan",
    //         dataType : "json",
    //         type : "POST",
    //         data : {
    //             kode_produk : kode_produk,
    //             qty : qty
    //         },
    //         success: response => {
    //             console.log(response.data);

    //             $("#data-detail-prakitan tr").remove();
    //             $.each(response.data, function (key, value) {
    //                 let status = (value.status == true)  ?  "Stok Mencukupi" : "Stok Kurang";
    //                 let total_qty = value.qty * $("#qty_rencana").val();
    //                 let class_tr = (value.status == false) ? "text-danger" : "";
    //                 let class_input = (value.status == false) ? "is-invalid" : "";
	// 						$('#data-detail-prakitan').prepend(`<tr class="`+ class_tr +`">
	// 									<td>`+value.kode_produk+`</td>
	// 									<td>`+value.nama+`</td>
	// 									<td>`+ value.jenis +`</td>
	// 									<td><input type="text" class="form-control `+ class_input +`"  placeholder="Cari Produk..." value="`+value.qty+`" readonly></td>
	// 									<td><input type="text" class="form-control ` + class_input +`"  placeholder="Cari Produk..." value="`+ total_qty +`" readonly></td>
	// 									<td>`+ status +`</td>
	// 									</tr>`);
	// 			})
    //             $("#modalMasterPrakitan").modal("hide");
    //         },
    //         error: (xhr,textStatus,thrownError) => {
    //             alert(xhr + "\n" + textStatus + "\n" + thrownError);
    //         }
    //     });
});
</script>
