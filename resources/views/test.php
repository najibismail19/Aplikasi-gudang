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
                        <font size="4">Laporan Daftar Pembelian</font><br>
                        <font size="5">PT GOLDEN ASIA</font><br>
                        @if (count($penerimaan) > 0)
                            <font size="2">{{ $penerimaan->last()->tanggal }} s/d {{ $penerimaan->first()->tanggal }}</font><br>
                        @endif
                        {{-- <font size="2">Jln Cut Nya'Dien No. 02 Kode Pos : 68173 Telp./Fax (0331)758005 Tangerang</font><br> --}}
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
        </table>
        <br>
        <table width="550">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td width="100">Prihal</td>
                            <td>:</td>
                            <td width="100">-</td>
                        </tr>
                        <tr>
                            <td width="100">Prihal</td>
                            <td>:</td>
                            <td width="100">-</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table  align="right">
                        <tr>
                            <td width="100">Prihal</td>
                            <td></td>
                            <td width="100">-</td>
                        </tr>
                        <tr>
                            <td width="100">Prihal</td>
                            <td></td>
                            <td width="100">-</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table> --}}
        {{-- <br> --}}
        <table border="1" class='table' style="font-size: 9pt; width: 18.5cm; text-align: center;">
			<thead>
				<tr style="background-color: #dedede;">
					<th>No</th>
					<th>No Penerimaan</th>
					<th>No Pembelian</th>
					<th>Supplier</th>
					<th>Jumlah Jenis</th>
					<th>Total Harga</th>
				</tr>
			</thead>
			<tbody>
                @foreach ($penerimaan as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->no_penerimaan}}</td>
                        <td>{{ $p->tanggal}}</td>
                        {{-- <td>{{ $p->pembelian->supplier }}</td> --}}
                        <td>{{ count($p->pembelian->detailPembelian) }}</td>
                        <td>{{ "Rp. " . number_format($p->pembelian->total_keseluruhan) }}</td>
                    </tr>
                @endforeach
			</tbody>
		</table>
        {{-- <br>
        <table width="625">
            <tr>
                <td width="430"></td>
                <td class="text2">Wali Kelas <br><br><br><br>Bpk DASD</td>
            </tr>
        </table> --}}

    </center>
</body>
</html>
