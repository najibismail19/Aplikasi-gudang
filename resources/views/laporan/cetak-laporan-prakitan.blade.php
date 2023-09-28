<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        table tr td {
            font-size: 13px;
        }

        table tr td .text2 {
            text-align: center;
        }

        table tr .text {
            text-align : right;
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
        <table width="550">
            <tr>
                <td>
                    <center>
                        <font size="4">PT GOLDEN ASIA</font><br>
                        <font size="5">Laporan Prakitan</font><br>
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
        <table border="1" class='table' style="font-size: 9pt; width: 18.5cm;">
			<thead>
				<tr style="background-color: #dedede;">
					<th>No</th>
					<th>No Prakitan</th>
					<th>Kode Produk</th>
					<th>Nama</th>
					<th>Tanggal Rencana</th>
					<th>Qty Rencana</th>
					<th>Tanggal Actual</th>
					<th>Qty Hasil</th>
				</tr>
			</thead>
			<tbody>
                @foreach ($prakitan as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->no_prakitan }}</td>
                        <td>{{ $p->kode_produk }}</td>
                        <td>{{ $p->produk->nama }}</td>
                        <td>{{ $p->tgl_rencana }}</td>
                        <td>{{ $p->qty_rencana }}</td>
                        <td>{{ $p->tgl_actual }}</td>
                        <td>{{ $p->qty_hasil }}</td>
                    </tr>
                @endforeach
                {{-- <tr rowSpan="2" style="font: bold; background-color: rgba(154, 194, 196, .8);">
                    <th colspan="4"></th>
                    <th colspan="2">Total</th>
                    <th id="table_total_keseluruhan" colspan="2">{{ "Rp. " . number_format($penerimaan->pembelian->total_keseluruhan) }}</th>
                </tr> --}}
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
