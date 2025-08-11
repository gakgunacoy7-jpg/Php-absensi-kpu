<?php
$koneksi = mysqli_connect("sql12.freesqldatabase.com", "sql12792283", "JBgF42AwPC", "sql12792283");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Data Kehadiran Bulan Ini</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="/absen_karyawan/asset/KPU_Logo.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
      Komisi Pemilihan Umum Kota Cimahi
    </a>
    <ul class="nav nav-underline">
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Lainnya
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.php"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
  <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
</svg> Keluar</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href=""><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
          </svg> Tentang</a></li>
          </ul>
        </li>
    </ul>
  </div>
</nav>

<br><br>
<div class="konten6">
 
<a href="admin.php"  type="button" class="btn btn-danger">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
</svg>kembali</a>
  <h1 class="text-center mb-5">Data Kehadiran Bulan Ini</h1>
  <section>
    <div class="row">
      <div class="col">
        <canvas id="myChart" style="height:40vh; width:40vw; margin:0 auto;"></canvas>
      </div>
      <div class="col">
        <table class=" mx-auto" style="width: 400px;">
          <tr>
            <th class="nama">No</th>
            <th class="nama">NIP</th>
            <th class="nama">Nama</th>
			      <th class="nama">Keterangan</th>
          </tr>
          <?php
          $no = 1;
          $qry = $koneksi->query("SELECT * FROM absensi");
          while ($data = $qry->fetch_assoc()) {
          ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $data['nip']; ?></td>
              <td><?= $data['nama_pegawai']; ?></td>
			  <td><?= $data['keterangan']; ?></td>
            </tr>
          <?php } ?>
        </table>
      </div>
    </div>
</div>
  </section>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
  <script>
    const data = {
      labels: ['Hadir', 'Sakit', 'Izin'],
      datasets: [{
        label: 'Data Kehadiran',
        data: [
          <?php
          $hadir = $koneksi->query("SELECT * FROM absensi WHERE keterangan='hadir'")->num_rows;
          $sakit = $koneksi->query("SELECT * FROM absensi WHERE keterangan='sakit'")->num_rows;
          $izin = $koneksi->query("SELECT * FROM absensi WHERE keterangan='izin'")->num_rows;
          echo "$hadir, $sakit, $izin";
          ?>],
        backgroundColor: [
          'rgb(54, 162, 235)',
          'rgb(255, 99, 132)',
          'rgb(255, 205, 86)'
        ],
        hoverOffset: 4
      }]
    };

    const config = {
      type: 'pie',
      data: data,
    };

    const myChart = new Chart(
      document.getElementById('myChart'),
      {
    type: 'pie',
    data: data,
    options: {
      plugins: {
        legend: {
          labels: {
            color: 'white'
          }
        },
        tooltip: {
          titleColor: 'white',
          bodyColor: 'white'
        }
      }
    }
  }
);
  </script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
