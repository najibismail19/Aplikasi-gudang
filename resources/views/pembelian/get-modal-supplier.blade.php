<div class="modal fade" id="modalSupplier">
    <div class="modal-lg modal-dialog">
      <div class="modal-content">
        <div class="modal-header  bg-info">
          <h4 class="modal-title">Pilih Supplier</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
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
        var table = $('.data-supplier').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/supplier",
                type: "GET",
                headers: {
                    "X-SRC-Supplier":"Serach Supplier xxxx",
                }
            },
            columns: [
                {
                    "data": 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'id_supplier',
                    name: 'id_supplier'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'kontak',
                    name: 'kontak'
                },
                {
                    data: 'alamat',
                    name: 'alamat'
                },
                {
                    data: 'deskripsi',
                    name: 'deskripsi'
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

$(document).on("click", ".pilihSupplier", function (e) {
    e.preventDefault();
    let id_supplier = $(this).attr("data-id_supplier");
    let nama = $(this).attr("data-nama");
    $("#id_supplier").val(id_supplier);
    $("#nama_supplier").val(nama);

    $("#modalSupplier").modal("hide");
});
</script>
