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
                        <font size="5">Laporan Penjualan Per Customer</font><br>
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
        <table width="550" class="title">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td width="100"> No Penjualan</td>
                            <td>:</td>
                            <td width="100"> {{ $penjualan->no_penjualan }}</td>
                        </tr>
                        <tr>
                            <td width="100">Tanggal</td>
                            <td>:</td>
                            <td width="100"> {{ $tanggal_penjualan }}</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table  align="right">
                        <tr>
                            <td width="100">Customer</td>
                            <td>:</td>
                            <td width="100"> {{ $penjualan->customer->nama }}</td>
                        </tr>
                        <tr>
                            <td width="100">Alamat</td>
                            <td>:</td>
                            <td width="100"> {{ $penjualan->customer->alamat }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br>
        <table class='table data' cellspacing="0" style="font-size: 9pt; width: 18.5cm;">
			<thead>
				<tr style="background-color: #fffafa;">
					<th>No</th>
					<th>Kode Produk</th>
					<th>Nama</th>
					<th>Jenis</th>
					<th>Satuan</th>
					<th>Harga</th>
					<th>Diskon</th>
					<th>Jumlah</th>
					<th>Total Harga</th>
				</tr>
			</thead>
			<tbody>
                @foreach ($details as $detail)
                    <tr class="tr">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->kode_produk }}</td>
                        <td>{{ $detail->produk->nama }}</td>
                        <td>{{ ($detail->jenis == 0) ? "Barang Mentah" : "Barang Jadi" }}</td>
                        <td>{{ $detail->produk->satuan }}</td>
                        <td>{{ "Rp. " . number_format($detail->harga) }}</td>
                        <td>{{ $detail->diskon . "%"}}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>{{ "Rp. " . number_format($detail->total_harga) }}</td>
                    </tr>
                @endforeach
                <tr rowSpan="2" style="font: bold; background-color: #fffafa;">
                    <th colspan="6"></th>
                    <th colspan="2">Total</th>
                    <th id="table_total_keseluruhan" colspan="1">{{ "Rp. " . number_format($penjualan->total_keseluruhan) }}</th>
                </tr>
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
