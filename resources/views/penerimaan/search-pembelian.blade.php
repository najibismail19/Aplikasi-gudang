<div class="modal fade" id="modalSearchPembelian">
    <div class="modal-xl modal-dialog">
      <div class="modal-content">
        <div class="modal-header  bg-info">
          <h4 class="modal-title">Pilih Pembelian</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body bg-light">
            <div class="card-body pb-2">
                <div class="table-responsive p-2">
                  <table class="table align-items-center mb-0 data-pembelian" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th  style="width: 15%;">No Pembelian</th>
                        <th style="width: 15%;">Supplier</th>
                        <th>Tanggal</th>
                        <th>Jumlah Produk</th>
                        <th>Total harga</th>
                        <th>Karywan Input</th>
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
    var table = $('.data-pembelian').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
                url: "/pembelian",
                type: "GET",
                headers: {
                    "X-SRC-Pembelian":"Serach Pembelian xxxx",
                }
            },
        columns: [
            {
                "data": 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'no_pembelian',
                name: 'no_pembelian'
            },
            {
                data: 'supplier',
                name: 'supplier.nama'
            },
            {
                data: 'tanggal',
                name: 'tanggal'
            },
            {
                data: 'total_produk',
                name: 'total_produk'
            },
            {
                data: 'total_keseluruhan',
                name: 'total_keseluruhan'
            },
            {
                data: 'karyawan',
                name: 'karyawan.nama'
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

$(function () {

var table = $('.data-detail-penerimaan').DataTable({
    processing: true,
    serverSide: true,
});
});


</script>
