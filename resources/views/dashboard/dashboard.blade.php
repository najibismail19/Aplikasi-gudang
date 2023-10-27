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
                <span class="info-box-number">{{ $customers }}</span>
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
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Grafik Pembelian</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        {{-- <a>View Report</a> --}}
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Filter</label>
                            <input type="month" class="form-control" id="filterPembelian" placeholder="Filter By Month" value="{{ date("Y-m") }}">
                        </div>
                      </div>
                    <div class="chart chart_pembelian">
                        <!-- Sales Chart Canvas -->
                        {{-- <canvas id="salesChart" height="180" style="height: 180px;"></canvas> --}}
                    </div>
                </div>
              </div>
        </div>
        <div class="col-md-6">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Grafik Penjualan</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        {{-- <a>View Report</a> --}}
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Filter</label>
                            <input type="month" class="form-control" id="filterPenjualan" placeholder="Filter By Month" value="{{ date("Y-m") }}">
                        </div>
                      </div>
                    <div class="chart chart_penjualan">
                        <!-- Sales Chart Canvas -->
                        {{-- <canvas id="salesChart" height="180" style="height: 180px;"></canvas> --}}
                    </div>
                </div>
              </div>
        </div>
        <div class="col-md-6">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Produk Terlaris</h3>
                  </div>
                <div class="card-body">
                    <div class="d-flex justify-content-end">
                        {{-- <a>View Report</a> --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="exampleFormControlInput1">Filter</label>
                                    <input type="month" class="form-control" id="filterProdukTerlaris" placeholder="Filter By Month" value="{{ date("Y-m") }}">
                                </div>
                                <div class="col-md-6">

                                    <label for="exampleFormControlInput1">Urutan Produk</label>
                                    <select class="form-select" id="urutan_produk_terlaris" name="urutan_produk_terlaris">
                                        @php
                                            for($i = 1; $i<=50; $i++) :
                                        @endphp
                                            <option value="{{ $i }}">{{ $i }}</option>
                                            @if ($i == 10)
                                                <option value="{{ $i }}" selected>{{ $i }}</option>
                                            @endif
                                            @php
                                                endfor;
                                            @endphp
                                      </select>
                                </div>
                            </div>
                        </div>
                      </div>
                    <div class="chart chart_produk_terlaris">
                        <!-- Sales Chart Canvas -->
                        {{-- <canvas id="salesChart" height="180" style="height: 180px;"></canvas> --}}
                    </div>
                </div>
              </div>
        </div>
        <div class="col-md-6">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Stok Produk Terbanyak</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        {{-- <a>View Report</a> --}}
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="filte_by_gudang">Filter By Gudang</label>
                                    <select class="form-select" id="pilih_gudang" name="pilih_gudang">
                                        <option value="">-- Pilih Gudang --</option>
                                        @foreach ($gudang as $g)
                                            <option value="{{ $g->id_gudang }}">{{ $g->nama_gudang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">

                                    <label for="exampleFormControlInput1">Urutan Produk</label>
                                    <select class="form-select" id="urutan_stok" name="urutan_stok">
                                        @php
                                            for($i = 1; $i<=50; $i++) :
                                        @endphp
                                            <option value="{{ $i }}">{{ $i }}</option>
                                            @if ($i == 10)
                                                <option value="{{ $i }}" selected>{{ $i }}</option>
                                            @endif
                                            @php
                                                endfor;
                                            @endphp
                                      </select>
                                </div>
                            </div>
                        </div>
                      </div>
                    <div class="chart chart_produk_terbanyak">
                        <!-- Sales Chart Canvas -->
                        {{-- <canvas id="salesChart" height="180" style="height: 180px;"></canvas> --}}
                    </div>
                </div>
              </div>
        </div>
            <!-- /.card -->
    </div>

        <!-- /.col-md-6 -->
@endsection


@push('script')
    <script>
        feather.replace();

        getChartPembelian();
        getChartPenjualan();
        getChartProdukTerlaris();
        getChartStokProdukTerbanyak();


        $("#filterPembelian").on("change", function() {
            getChartPembelian();
        });


        $("#filterProdukTerlaris").on("change", function() {
                getChartProdukTerlaris();
        });

        $("#urutan_produk_terlaris").on("change", function() {
                getChartProdukTerlaris();
        });

        $("#pilih_gudang").on("change", function() {
            getChartStokProdukTerbanyak();
        });

        $("#urutan_stok").on("change", function() {
            getChartStokProdukTerbanyak();
        });

        $("#filterPenjualan").on("change", function() {
                getChartPenjualan();
        });


        function getChartPembelian() {

            $.ajax({
                headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                url : "/dashboard/get-chart-pembelian?bulan=" + $("#filterPembelian").val(),
                type : "GET",
                dataType : "json",
                success: response => {
                    $(".chart_pembelian").html(response.chart_pembelian);
                },
                error: function(xhr,textStatus,thrownError) {
                    var err = JSON.parse(xhr.responseText);
                    alert(err.Message);
                }
            })
        }

        function getChartPenjualan() {

            $.ajax({
                headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                url : "/dashboard/get-chart-penjualan?bulan=" + $("#filterPenjualan").val(),
                type : "GET",
                dataType : "json",
                success: response => {
                    $(".chart_penjualan").html(response.chart_penjualan);
                }
            });
        }

        function getChartProdukTerlaris() {
            $.ajax({
                headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                url : "/dashboard/get-chart-produk-terlaris?bulan=" + $("#filterProdukTerlaris").val() + "&limit=" + $("#urutan_produk_terlaris").val(),
                type : "GET",
                dataType : "json",
                success: response => {
                    console.log(response);
                    $(".chart_produk_terlaris").html(response.chart_produk_terlaris);
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log("Error Thrown: " + errorThrown);
                    console.log("Text Status: " + textStatus);
                    console.log("XMLHttpRequest: " + XMLHttpRequest);
                    console.warn(XMLHttpRequest.responseText)
               }
            });
        }

        function getChartStokProdukTerbanyak() {

            $.ajax({
                headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') },
                url : "/dashboard/get-chart-produk-terbanyak?gudang=" + $("#pilih_gudang").val() + "&limit=" + $("#urutan_stok").val(),
                type : "GET",
                dataType : "json",
                success: response => {
                    console.log(response);
                    $(".chart_produk_terbanyak").html(response.chart_produk_terbanyak);
                },
                error: function(xhr,textStatus,thrownError) {
                alert(xhr + "\n" + textStatus + "\n" + thrownError);
                }
            });
        }


    </script>
@endpush
