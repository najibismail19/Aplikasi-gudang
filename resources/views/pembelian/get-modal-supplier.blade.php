<div class="modal fade" id="modalSupplier" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-xl modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Pilih Supplier</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
        <div class="modal-body bg-light">
            <div class="card-body pb-2">
                <div class="table-responsive p-2">
                  <table class="table align-items-center mb-0 data-supplier" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th  style="width: 15%;">Code Supplier</th>
                        <th style="width: 15%;">Nama</th>
                        <th>Kontak</th>
                        <th>Alamat</th>
                        <th>Deskripsi</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $supplier)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $supplier->id_supplier }}</td>
                                <td>{{ $supplier->nama }}</td>
                                <td>{{ $supplier->kontak }}</td>
                                <td>{{ $supplier->alamat }}</td>
                                <td>{{ $supplier->deskripsi }}</td>
                                <td><a class="btn btn-primary mx-1" id="pilihSupplier"
                                    data-id_supplier ="{{$supplier->id_supplier}}"
                                    data-nama = "{{$supplier->nama}}"
                                    data-kontak ="{{$supplier->kontak}}"
                                    data-alamat = "{{$supplier->alamat}}"
                                    data-deskripsi ="{{$supplier->deskripsi}}"
                                    ><i class='fas fa-eye'></i>
                                </a></td>
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

     $(function () {
        $('.data-supplier').DataTable({
        });
      });

$(document).on("click", "#pilihSupplier", function (e) {
    e.preventDefault();
    let id_supplier = $(this).attr("data-id_supplier");
    let nama = $(this).attr("data-nama");
    $("#id_supplier").val(id_supplier);
    $("#nama_supplier").val(nama);

    $("#modalSupplier").modal("hide");
});
</script>
