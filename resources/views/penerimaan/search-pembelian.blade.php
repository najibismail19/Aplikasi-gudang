<div class="modal fade" id="modalSearchPembelian" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-xl modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Search Penerimaan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="table-responsive p-2">
                <table class="table table-bordered table-striped align-items-center mb-0 search-pembelian" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th  style="width: 15%;">No Pembelian</th>
                        <th style="width: 15%;">Supplier</th>
                        <th>Tanggal</th>
                        <th>Total harga</th>
                        <th>Karywan Input</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembelian as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->no_pembelian }}</td>
                                <td>{{ $p->supplier->nama }}</td>
                                <td>{{ $p->tanggal_pembelian }}</td>
                                <td>{{ $p->total_keseluruhan }}</td>
                                <td>{{ $p->karyawan->nama }}</td>
                                <td><a class='pilihPembelian btn btn-primary mx-1' id={{ $p->no_pembelian }}><i class='align-middle' data-feather='check'></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<script>

        $(function () {
            feather.replace();
            $('.search-pembelian').DataTable({
            });
         });

$(function () {

var table = $('.data-detail-penerimaan').DataTable({
    processing: true,
    serverSide: true,
});
});


</script>
