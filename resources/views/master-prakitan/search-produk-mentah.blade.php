<!-- Modal -->
<div class="modal fade" id="modalProdukMentah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-lg modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Searh Produk Mentah</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive p-2">
                <table class="table align-items-center mb-0 data-detail-produk-mentah" style="width: 100%">
                  <thead>
                    <tr>
                      <th style="width: 5%;">No</th>
                      <th  style="width: 20%;">Kode Produk</th>
                      <th style="width: 15%;">Nama</th>
                      <th style="width: 15%;">Satuan</th>
                      <th>Jenis</th>
                      <th>Action</th>
                    </tr>
                  </thead>
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
    $(function () {
        var table = $('.data-detail-produk-mentah').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
                url: "/produk",
                type: "GET",
                headers: {
                    "X-SRC-PRK-Produk":"P-M",
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

    $(document).on("click", "#searchProdukMentah", function () {
        $("#modalProdukMentah").modal("show");
    });


    $(document).on("click", ".pilihProdukMentah", function () {
        let kode_produk = $(this).attr("data-kode-produk");
        let nama = $(this).attr("data-nama");
        let harga = $(this).attr("data-harga");
        let jenis = $(this).attr("data-jenis");
        let satuan = $(this).attr("data-satuan");

        $("#kode_produk_mentah").val(kode_produk);
        $("#nama_produk_mentah").val(nama);
        $("#satuan").val(satuan);

        let nama_jenis = (jenis == 0) ? "Barang Mentah" : "Barang Jadi";
        $("#jenis_produk").val(nama_jenis);


        // $("#gambar_produk").attr("src", "/storage/photos/produk/" + file_gambar);
        $("#modalProdukMentah").modal("hide");
    });
</script>
