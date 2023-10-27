<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
            .table.data {
                border: 1px solid black;
            }

            .table.data .tr td {
                border: 1px solid black;
            }

            .table.data th {
                border: 1px solid black;
            }

            table tr td .text2 {
                text-align: center;
            }

            table tr .text {
                text-align : right;
                font-size: 13px;
            }

            .title table {
                font-size: 13px;
            }
            .table tr td {
                padding: .1cm;
            }
            .table tr th {
                padding: .1cm;
            }
    </style>
</head>
<body>
    <center>
        <table style="width: 18.5cm;">
            <tr>
                <td>
                    <center>
                        <font size="4">PT GOLDEN ASIA</font><br>
                        <font size="5">Laporan Kartu Stok</font><br>
                    </center>
                </td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
        </table>
        {{-- <table width="550">
            <tr>
                <td class="text">Jember 16 mei 20222</td>
            </tr>
        </table> --}}
        <br>
        <table class='table data' cellspacing="0" style="font-size: 9pt; width: 18.5cm;">
			<thead>
				<tr style="background-color: #fffafa;">
					<th>No</th>
					<th>No Referensi</th>
					<th>Tanggal</th>
					<th>Gudang</th>
					<th>Kode Produk</th>
					<th>Nama</th>
					<th>Awal</th>
					<th>In</th>
					<th>Out</th>
					<th>Akhir</th>
				</tr>
			</thead>
			<tbody>
                @foreach ($kartu_stok as $k)
                    <tr class="tr">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $k->no_referensi }}</td>
                        <td>{{ $k->tanggal }}</td>
                        <td>{{ $k->gudang->nama_gudang }}</td>
                        <td>{{ $k->kode_produk}}</td>
                        <td>{{ $k->produk->nama}}</td>
                        <td>{{ $k->saldo_awal }}</td>
                        <td>{{ $k->stock_in }}</td>
                        <td>{{ $k->stock_out }}</td>
                        <td>{{ $k->saldo_akhir }}</td>
                    </tr>
                @endforeach

			</tbody>
		</table>
        {{-- <br>
        <table width="625" border="1">
            <tr>
                <td width="430"></td>
                <td class="text2">Wali Kelas <br><br><br><br>Bpk DASD</td>
            </tr>
        </table> --}}

    </center>
</body>
</html>
