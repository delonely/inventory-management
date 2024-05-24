<?= '<style>' . file_get_contents("assets/bootstrap-pdf.css") . '</style>'; ?>
<head>
    <title>Data Barang</title>

    <style>
        @page {
            margin-top: 30px;
        }
        
        .header {
            text-align: center;
        }
        /* body {
            margin: 0px;
        } */

        /* .garis_tepi {
            border: 1px solid black;
        } */

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        table{
            width: 100%;
        }

        @font-face {
            font-family: 'Times New Roman';
            font-style: normal;
            font-weight: normal;
            src: ("<?= base_url('assets') ?>/font/times.ttf") format('truetype');
        }

        html,
        body {
            font-family: 'Times New Roman' !important;
        }
    </style>
</head>

<body>
    <header class="header">
        <h2>Laporan Persediaan</h2>
        <h4>Untuk Periode Yang Berakhir Tanggal: </h4><!--tanggal diisi dengan tanggal yang dipilih user-->
    </header>

    <div class="namaUnit">
        <h4>Nama Unit: </h4><!-- nama unit diisi dengan nama gudang-->
    </div>

    <div class="row">
        <table>
            <thead>
                <th>Kode Barang</th> <!-- diisi id barang-->
                <th>Uraian</th><!-- diisi Parent, Kategori, dan nama barang-->
                <th>Nilai per: </th><!--tanggal diisi dengan tanggal yang dipilih user-->

                <!-- <th>No.</th>
                <th>Kategori Barang</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Satuan</th> -->
            </thead>
            <tbody>
                <tr>
                    <td>01</td><!-- ID parent kategori -->
                    <td>Barang Konsumsi</td> <!-- parent kategori -->
                    <td></td>
                </tr>
                <tr>
                    <td>01</td><!-- ID kategori barang-->
                    <td>Alat Tulis</td><!--kategori barang -->
                    <td>Rp.16.000.000</td><!--total rupiah dari barang yang masuk di kategori barang alat tulis sebagai contoh (pergudang) -->
                </tr>
                <tr>
                    <td>01</td><!-- ID barang-->
                    <td>Snowman V5</td><!--nama barang -->
                    <td>Rp.230.000</td><!-- total rupiah dari nama barang (per gudang)-->
                </tr>
                <tr>
                    <td colspan="2">Jumlah</td>
                    <td>Rp.200.000.000</td>
                </tr>
               <!-- <?php
                foreach ($data as $da){
                    echo '<tr>';
                    echo '<td>1</td>'; //no urut auto
                    echo '<td>'.$da->namaKategori.'</td>';
                    echo '<td>'.$da->nama.'</td>';
                    echo '<td>'.$da->estimasiStok.'</td>';
                    echo '<td>'.$da->namaSatuanTerkecil.'</td>';
                    echo '</tr>';
                }
                ?> -->
            </tbody>
        </table>
    </div>
</body>