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
                        <font size="4">Laporan Daftar Pembelian</font><br>
                        <font size="5">PT GOLDEN ASIA</font><br>
                        @if (count($pembelian) > 0)
                            <font size="2">{{ $pembelian->last()->tanggal }} s/d {{ $pembelian->first()->tanggal }}</font><br>
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
        <table class='table data' cellspacing="0" style="font-size: 9pt; width: 18.5cm;">
			<thead>
				<tr style="background-color: #fffafa;">
					<th>No</th>
					<th>No Pembelian</th>
					<th>Tanggal</th>
					<th>Supplier</th>
					<th>Jumlah Jenis</th>
					<th>Karyawan Input</th>
					<th>Total Harga</th>
				</tr>
			</thead>
			<tbody>
                @foreach ($pembelian as $p)
                    <tr class="tr">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->no_pembelian}}</td>
                        <td>{{ $p->tanggal}}</td>
                        <td>{{ $p->supplier->nama }}</td>
                        <td>{{ count($p->detailPembelian) }}</td>
                        <td>{{ $p->karyawan->nama }}</td>
                        <td>{{ "Rp. " . number_format($p->total_keseluruhan) }}</td>
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
