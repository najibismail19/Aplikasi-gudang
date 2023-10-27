<div class="modal fade" id="modalProduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-xl modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Pilih Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body bg-light">
            <div class="card-body pb-2">
                <div class="table-responsive p-2">
                  <table class="table align-items-center mb-0 data-products" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th>Kode Produk</th>
                        <th style="width: 15%;">Nama</th>
                        <th>Jenis</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($produk as $p)
                            <tr class="data-produk">
                                <td>{{ $loop->iteration }}</td>
                                <td id="kode_produk">{{ $p->kode_produk }}</td>
                                <td id="nama">{{ $p->nama }}</td>
                                <td id="jenis">{{ ( $p->jenis == 0 ) ? "Barang Mentah" : "Baranag Jadi"}}</td>
                                <td id="satuan">{{ $p->satuan }}</td>
                                <td id="harga">{{ 'Rp '.number_format($p->harga, 0, ',', '.'); }}</td>
                                <td>
                                  <a id="pilihProduk" class="btn btn-success">
                                      Pilih
                                  </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
        </div>
        <div class="modal-footer justify-content-end">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<script>

    feather.replace();

     $(function () {
        $('.data-products').DataTable();
      });


$(".data-produk").each(function() {
    let row = $(this);
    $(row).find("#pilihProduk").on("click", function (){
        $("#kode_produk").val($(row).find("#kode_produk").text());
        $("#nama_produk").val($(row).find("#nama").text());
        $("#harga").val($(row).find("#harga").text());

        $("#jenis_produk").val($(row).find("#jenis").text());


        $("#total_harga").val(calculate());
        $("#modalProduk").modal("hide");
    });
});

$(document).on("click", "#searchProduk", function () {
        $("#modalProduk").modal("show");
    });

    function calculate() {
        let harga =  parseInt($("#harga").val());
        let jumlah = parseInt($("#jumlah").val());
        let dis = parseInt($("#diskon").val());

        let diskon = dis ?? 0;

        let pot = ((harga * jumlah) / 100) * diskon;

        setTimeout(() => {
            $("#total_harga").val((harga * jumlah) - pot);
        }, 500);
    }

    $("#diskon").on("keyup", function() {
        if($(this).val() > 100) {
            $(this).addClass("is-invalid");
        } else {
            $(this).removeClass("is-invalid");
        }
        calculate();
    });

    $("#jumlah").on("keyup", function (e) {
        calculate();
    });
</script>
