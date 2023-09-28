@extends('template.template')

@section('content')
    <div class="row">
        <div class="col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-truck"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Suppliers</span>
              <span class="info-box-number">
                {{ $suppliers }}
                {{-- <small>%</small> --}}
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><a href=""><i class="fas fa-users"></i></a></span>

            <div class="info-box-content">
              <span class="info-box-text">User Registration</span>
              <span class="info-box-number">{{ $users }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        {{-- <div class="clearfix hidden-md-up"></div> --}}

        <div class="col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-inbox"></i></span>
            {{-- <i data-feather="inbox"></i> --}}
            <div class="info-box-content">
              <span class="info-box-text">Produk</span>
              <span class="info-box-number">{{ $products }}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Customers</span>
                <span class="info-box-number">760</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    <div class="row justify-content-end">

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h3>Purchases</h3>
                        {{-- <a>View Report</a> --}}
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Filter</label>
                            <input type="month" class="form-control" id="filterStok" placeholder="Filter By Month" value="{{ date("Y-m") }}">
                        </div>
                      </div>
                    <div class="chart chart_stok">
                        <!-- Sales Chart Canvas -->
                        {{-- <canvas id="salesChart" height="180" style="height: 180px;"></canvas> --}}
                    </div>
                </div>
              </div>
        </div>
            <!-- /.card -->
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header border-0">
                  <h3 class="card-title">Karyawan</h3>
                </div>
                <div class="card-body table-responsive p-0">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Profil</th>
                      <th>Nama</th>
                      <th>Jabatan</th>
                      <th>Gudang</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td>
                        <img src="{{ url("/storage/photos/produk/default.png") }}" alt="Product 1" class="img-circle img-size-32 mr-2">
                      </td>
                      <td>Najib Ismail</td>
                      <td>Survepisor</td>
                      <td>Gudang A</td>

                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card -->
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header border-0">
                  <h3 class="card-title">Produk Terlaris</h3>
                </div>
                <div class="card-body table-responsive p-0">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Kode Produk</th>
                      <th>Nama</th>
                      <th>Terjual</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td>Nik132218503</td>
                      <td>Najib Ismail</td>
                      <td>ismailnajib@gmail.com</td>
                    </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card -->
        </div>
    </div>
        <!-- /.col-md-6 -->
@endsection


@push('script')
    <script>
        feather.replace();
        getChartStok();


        $("#filterStok").on("change", function() {
                getChartStok();
        });

        function getChartStok() {

            $.ajax({
                headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                url : "/dashboard/get-chart-stok/" + $("#filterStok").val(),
                type : "GET",
                dataType : "json",
                success: response => {
                    console.log(response);
                    $(".chart_stok").html(response.chart_stok);
                },
                error: function(xhr,textStatus,thrownError) {
                alert(xhr + "\n" + textStatus + "\n" + thrownError);
                }
            });
        }
    </script>
@endpush
