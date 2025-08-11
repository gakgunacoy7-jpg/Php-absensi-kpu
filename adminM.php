<?php
session_start();

if (empty($_SESSION['nama'])) {
  echo "<script>
      alert('Silakan login terlebih dahulu');
      window.location.href = 'login.php';
  </script>";
  exit;
}
$koneksi = mysqli_connect("sql12.freesqldatabase.com", "sql12792283", "JBgF42AwPC", "sql12792283");
date_default_timezone_set("Asia/Jakarta");

    if(isset($_POST['absen_pulang']) && isset($_POST['update_no']))
    {
        $update_no = $_POST['update_no'];
        $waktu_keluar = date("H:i:s");
        $koneksi = mysqli_connect("sql12.freesqldatabase.com", "sql12792283", "JBgF42AwPC", "sql12792283");
        $update_sql = "UPDATE absensi
                       SET waktu_keluar = '$waktu_keluar',
                       WHERE no = $update_no";

        if ($koneksi->query($update_sql) === TRUE){
            header("Location: adminM.php");
            exit();
        } else {
            echo "Error saat mengupdate data:". $koneksi->error;
        }
    }
  
$koneksi1 = mysqli_connect("sql12.freesqldatabase.com", "sql12792283", "JBgF42AwPC", "sql12792283");
if (isset($_POST['delete'])) {
    $no = $_POST['no'];
    $query1 = "DELETE FROM absensi WHERE no='$no'";  
    mysqli_query($koneksi1, $query1);
    mysqli_query($koneksi1, "SET @no := 0");
    mysqli_query($koneksi1, "UPDATE absensi SET no = @no := @no +1");
    header("Location: adminM.php");
    exit();
}



$koneksi3 = mysqli_connect("sql12.freesqldatabase.com", "sql12792283", "JBgF42AwPC", "sql12792283");
$waktu_reset = date('H');
$sekarang = date('H');

if ($sekarang == $waktu_reset) {
  $query4 = "UPDATE absensi SET no = no - (SELECT MIN(no) - 1 FROM absensi)";
  mysqli_query($koneksi3, $query4);
  $query4 = "ALTER TABLE absensi AUTO_INCREMENT = 1";
  mysqli_query($koneksi3, $query4);
}
sleep(1);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Absensi Minggu Ini</title>
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
      <li class="nav-item">
        <a class="nav-link active" href="admin.php">Riwayat</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="admink.php">Data Kegiatan</a>
      </li>
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Lainnya
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="index.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
  <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
</svg> Keluar</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
</svg> Tentang</a></li>
          </ul>
        </li>
    </ul>
    
  </div>
</nav>

<br><br><br>
<div class="konten">
<div class="container mt-5">
    <h2 class="h2">Riwayat Absensi Minggu Ini</h2><br>
    <div class="d-grid-6 gap-2 col-3">
    <a href="data_kehadiran.php" class="btn btn-success" type="button" class="bi bi-bar-chart-line-fill">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bar-chart-line-fill" viewBox="0 0 16 16">
    <path d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1z"/>
  </svg>
      Statistik Kehadiran</a>
    </div>
<br>
  <div class="btn-group">
  <a href="admin.php" class="btn btn-primary" aria-current="page">Hari ini</a>
  <a href="adminM.php" class="btn btn-primary active"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-week-fill" viewBox="0 0 16 16">
  <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5m9.954 3H2.545c-.3 0-.545.224-.545.5v1c0 .276.244.5.545.5h10.91c.3 0 .545-.224.545-.5v-1c0-.276-.244-.5-.546-.5M8.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm3 0a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM3 10.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5m3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
</svg>  Minggu ini</a>
  <a href="adminB.php" class="btn btn-primary">Bulan ini</a>
</div><br><br>

    <table>
            <tr>
                <th class="nama">No</th>
                <th class="nama">NIP</th>
                <th class="nama">Nama</th>
                <th class="nama">Tanggal</th>
                <th class="nama">Waktu Masuk</th>
                <th class="nama">Waktu Keluar</th>
                <th class="nama">Keterangan</th>
                <th class="nama">Deskripsi</th>
                <th class="nama">Bukti</th>
                <th class="nama">Aksi</th>
            </tr>
        <tbody>
        <?php
        $conn = new mysqli("sql12.freesqldatabase.com", "sql12792283", "JBgF42AwPC", "sql12792283");
        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }
        $awal_minggu = date('Y-m-d', strtotime('monday this week'));
        $akhir_minggu = date('Y-m-d', strtotime('sunday this week'));
        $sqlm = "SELECT * FROM absensi WHERE tanggal BETWEEN '$awal_minggu' AND '$akhir_minggu'";
        $resultm = $conn -> query($sqlm);
        if ($resultm->num_rows > 0) {
            while ($row = $resultm->fetch_assoc()) {
                echo "<tr>
                        <td class='no'></td>
                        <td>{$row['nip']}</td>
                        <td>{$row['nama_pegawai']}</td>
                        <td>{$row['tanggal']}</td>
                        <td>{$row['waktu_masuk']}</td>
                        <td>{$row['waktu_keluar']}</td>
                        <td>{$row['keterangan']}</td>
                        <td>{$row['deskripsi']}</td>
                        
                        <td>";
                if (!empty($row['gambar'])) {
                    echo "<a href='uploads/{$row['gambar']}' target='_blank'>Lihat</a>";
                } else {
                    echo "-";
                }
                echo"<td>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='no' value='".$row['no']."'>";
                echo "<button type='submit' class='btn btn-danger' name='delete'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash3' viewBox='0 0 16 16'>
                <path d='M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5'/>
              </svg>Hapus</button>";
                echo "</form>";
                echo "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='9' class='text-center'>Belum ada data absensi</td></tr>";
        }

        $conn->close();
        ?>
        </tbody>
    </table>

    <br>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
     <button class="btn btn-warning" id="reset" type="button" >
     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z"/>
  <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466"/>
</svg>Reset Nomor</button>
<br>

</div>
</div>

      <script> 
      function reset() {
        const nomorCells = document.querySelectorAll(".no");
        nomorCells.forEach((cell, index) => {
          cell.textContent=index+1;
        });
      }
      document.getElementById("reset").addEventListener("click" , reset);
      window.addEventListener("DOMContentLoaded", reset);
      reset();
    
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
