<div class="modal fade" id="modalProduk">
    <div class="modal-lg modal-dialog">
      <div class="modal-content">
        <div class="modal-header  bg-info">
          <h4 class="modal-title">Pilih Produk</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body bg-light">
            <div class="card-body pb-2">
                <div class="table-responsive p-2">
                  <table class="table align-items-center mb-0 data-produk" style="width: 100%">
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
        <div class="modal-footer justify-content-end">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
<script>
    $(function () {
        var table = $('.data-produk').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
                url: "/produk",
                type: "GET",
                headers: {
                    "X-SRC-Produk":"Serach Produk xxxx",
                }
        },
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

    $(document).on("click", "#searchProduk", function () {
        $("#modalProduk").modal("show");
    });

    $(document).on("click", ".pilihProduk", function () {
        let kode_produk = $(this).attr("data-kode-produk");
        let nama = $(this).attr("data-nama");
        let harga = $(this).attr("data-harga");
        let jenis = $(this).attr("data-jenis");
        let gambar = $(this).attr("data-gambar");

        $("#kode_produk").val(kode_produk);
        $("#input_kode_produk").val(kode_produk);
        $("#nama_produk").val(nama);
        $("#harga").val(harga);

        let nama_jenis = (jenis == 0) ? "Barang Mentah" : "Barang Jadi";
        $("#jenis").val(nama_jenis);

        let file_gambar = (gambar) ? gambar : "default.png";

        $("#gambar_produk").attr("src", "/storage/photos/produk/" + file_gambar);
        $("#total_harga").val(calculate());
        $("#modalProduk").modal("hide");
    });


    $("#jumlah").on("keyup", function (e) {
        calculate();
    });

    function calculate() {
        let harga =  parseInt($("#harga").val());
        let jumlah = parseInt($("#jumlah").val());
        setTimeout(() => {
            $("#total_harga").val(harga * jumlah);
        }, 500);
    }
</script>
