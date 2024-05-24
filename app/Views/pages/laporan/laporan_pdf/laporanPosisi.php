<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Posisi Persediaan di Neraca</title>

    <style>
      .header {
        text-align: center;
      }
      .namaUnit {
        text-align: left;
      }
      .table {
        border-collapse: separate;
        width: 100%;
      }
      .table,
      .table th {
        border: 1px solid #ddd;
        padding: 8px;
      }
      .table tr:nth-child(even) {
        background-color: #f2f2f2;
      }

      .table tr:hover {
        background-color: #ddd;
      }

      .table th {
        padding-top: 10px;
        padding-bottom: 10px;
        text-align: left;
        background-color: #4caf50;
        color: white;
      }

      .center {
        margin-left: auto;
        margin-right: auto;
      }
    </style>
  </head>
  <body>
    <header class="header">
      <h2>Laporan Posisi Persediaan Di Neraca</h2>
      <h3>Untuk Periode Yang Berakhir Tanggal:</h3>
      <h3>Tahun Anggaran:</h3>
    </header>

    <div class="namaUnit">
      <h4>Nama Unit:</h4>
    </div>

    <table class="table center">
      <thead>
        <tr>
          <th scope="col">No.</th>
          <th scope="col">Uraian</th> <!-- dari parent-->
          <th scope="col">Nilai</th> <!--nilai/total rupiah dari tiap parent-->
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </body>
</html>
