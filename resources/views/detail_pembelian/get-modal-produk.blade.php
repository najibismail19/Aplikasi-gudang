<!-- Modal -->
<div class="modal fade" id="modalProduk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-lg modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Searh Produk</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive p-2">
                <table class="table align-items-center mb-0 search-produk" style="width: 100%">
                  <thead>
                    <tr>
                      <th style="width: 5%;">No</th>
                      <th  style="width: 20%;">Kode Produk</th>
                      <th style="width: 15%;">Nama</th>
                      <th>Harga</th>
                      <th>Jenis</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($produk as $p)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$p->kode_produk}}</td>
                        <td>{{$p->nama}}</td>
                        <td>{{$p->harga}}</td>
                        <td>{{($p->jenis == 0) ? "Barang Mentah" : "Barang Jadi"}}</td>
                        <td>
                            <a class="pilihProduk btn btn-primary mx-1"
                                        data-kode-produk="{{$p->kode_produk}}"
                                        data-nama="{{$p->nama}}"
                                        data-satuan="{{$p->satuan}}"
                                        data-harga="{{$p->harga}}"
                                        data-jenis="{{$p->jenis}}"
                                        data-gambar="{{$p->gambar}}"
                                        data-deskripsi="{{$p->deskripsi}}"
                                    ><i class="fas fa-check"></i></a>
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
        $(function () {
            $('.search-produk').DataTable();
        });

    $(document).on("click", ".pilihProduk", function () {
        let kode_produk = $(this).attr("data-kode-produk");
        let nama = $(this).attr("data-nama");
        let harga = $(this).attr("data-harga");
        let jenis = $(this).attr("data-jenis");
        let gambar = $(this).attr("data-gambar");

        $("#kode_produk").val(kode_produk);
        $("#nama_produk").val(nama);
        $("#harga").val(harga);

        let nama_jenis = (jenis == 0) ? "Barang Mentah" : "Barang Jadi";
        $("#jenis_produk").val(nama_jenis);

        let file_gambar = (gambar) ? gambar : "default.png";

        // $("#gambar_produk").attr("src", "/storage/photos/produk/" + file_gambar);
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
