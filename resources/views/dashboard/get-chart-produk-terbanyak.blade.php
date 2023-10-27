<link rel="stylesheet" href="{{ url("/assets/plugins/chart.js/Chart.min.css") }}">
<script src="{{ url("/assets/plugins/chart.js/Chart.bundle.min.js") }}"></script>

<canvas id="ProdukTerbanyakChart" style="height: 50vh; width: 80vh"></canvas>

<script>

    var sumbu_x =  {{ Js::from($sumbu_x) }};
    var sumbu_y =  {{ Js::from($sumbu_y) }};
    var rgb =  {{ Js::from($rgb) }};

    var ctx = document.getElementById("ProdukTerbanyakChart").getContext("2d");


    var chart = new Chart(ctx, {
        type : "doughnut",
        responsive : true,
        data : {
            labels : sumbu_x,
            datasets : [{
                label : "Jumlah Produk Terjual",
                backgroundColor : rgb,
                borderColor : rgb,
                data : sumbu_y,
                borderWidth: 1
            }]
        },
        duration : 1000,
        options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
    })


</script>
