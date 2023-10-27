@extends('template.template')
@section('content')
<div class="container-fluid p-0">

    <h1 class="h3 mb-3"><strong>Tambah</strong> Penjualan</h1>

    <div class="row">
<div class="col-12">
    <div class="card mb-4">
      <div class="card-header">
        <a href="{{ url("/penjualan") }}" class="btn btn-warning" id="addPurchase" style="float: right;">&nbsp;Back</a>
      </div>
      <div class="card-body pb-2">
        <div class="row px-5 py-3">
            <form action="{{ url("/penjualan") }}" method="post">
                @csrf
                <div class="row mb-3">
                  <label for="no_pembelian" class="col-sm-2 col-form-label">No Penjualan*</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control @error('no_penjualan') is-invalid @enderror" id="no_penjualan" name="no_penjualan" id="no_penjualan" value="{{ $no_penjualan }}" readonly>
                    @error('no_penjualan')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="nik" class="col-sm-2 col-form-label">Nama Karyawan*</label>
                  <div class="col-sm-10">
                    <input type="hidden" name="nik" value="{{ getNik() }}">
                    <input type="text" readonly class="form-control @error('nik') is-invalid @enderror" placeholder="Nama Karyawan" value="{{ getNamaKaryawan() }}">
                    @error('nik')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                  </div>
                </div>
                <div class="row mb-3">
                    <label for="id_supplier" class="col-sm-2 col-form-label">Customer*</label>
                    <div class="col-sm-10 d-flex">
                        <input type="hidden" id="id_customer" name="id_customer">
                        <input type="text" class="form-control @error("id_customer") is-invalid  @enderror" placeholder="Customer" id="nama_customer"readonly>
                        <button class="btn btn-primary" id="searchCustomer">Search</button>
                    </div>
                    @error('id_customer')
                        <small class="text-danger" style="margin: .2rem 0 0 10rem;">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
                <div class="row mb-3">
                    <label for="date" class="col-sm-2 col-form-label">Tanggal Penjualan*</label>
                    <div class="col-sm-10">
                      <input type="date" class="form-control @error('tanggal_penjualan') is-invalid @enderror" id="tanggal_penjualan" name="tanggal_penjualan">
                      @error('tanggal_penjualan')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                      @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-10">
                        <textarea class="form-control error_text @error('deskripsi') is-invalid @enderror" placeholder="Description..." name="deskripsi" id="deskripsi" style="height: 100px"></textarea>
                        @error('deskripsi')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="mb-3" style="float: right">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                    <button type="submit" id="buttonAddItem" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>

</div>

@endsection
@push('script')
    <script>
        $(function () {
            $.ajax({
                  headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                  url : "/penjualan/get-modal-customer",
                  dataType : "json",
                  success: response => {
                      console.log(response);
                      if(response.success) {
                          $("body").append(response.modal)
                      }
                  },
                  error: (xhr,textStatus,thrownError) => {
                      alert(xhr + "\n" + textStatus + "\n" + thrownError);
                  }
              });
        });

        $(document).on("click", "#searchCustomer", function (e) {
            e.preventDefault();
            $("#modalCustomer").modal("show");
        });



    </script>
@endpush

