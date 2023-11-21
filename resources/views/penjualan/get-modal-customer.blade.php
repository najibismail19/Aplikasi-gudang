<div class="modal fade" id="modalCustomer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-xl modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Pilih Customer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body bg-light">
            <div class="card-body pb-2">
                <div class="table-responsive p-2">
                  <table class="table align-items-center mb-0 data-customer" style="width: 100%">
                    <thead>
                      <tr>
                        <th style="width: 5%;">No</th>
                        <th >ID Customer</th>
                        <th style="width: 15%;">Nama</th>
                        <th>Kontak</th>
                        <th>Email</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $customer->id_customer }}</td>
                                <td>{{ $customer->nama }}</td>
                                <td>{{ $customer->kontak }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>
                                  <a id="pilihCustomer" class="btn btn-success"
                                    data-id-customer="{{ $customer->id_customer }}"
                                    data-nama="{{ $customer->nama }}">
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
     $(function () {
        $('.data-customer').DataTable({
        });
      });

$(document).on("click", "#pilihCustomer", function (e) {
    e.preventDefault();
    let id_customer = $(this).attr("data-id-customer");
    let nama = $(this).attr("data-nama");
    $("#id_customer").val(id_customer);
    $("#nama_customer").val(nama);

    $("#modalCustomer").modal("hide");
});
</script>
