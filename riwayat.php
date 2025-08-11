<?php
session_start();
date_default_timezone_set("Asia/Jakarta");

if(isset($_POST['absen_pulang']) && isset($_POST['update_no'])) {
  $update_no = $_POST['update_no'];
  $waktu_keluar = date("H:i:s");
  $koneksi = mysqli_connect("sql12.freesqldatabase.com", "sql12792283", "JBgF42AwPC", "sql12792283");

  $result = $koneksi->query("SELECT nama_pegawai FROM absensi WHERE no = $update_no");
  $nama_pegawai = '';
  if ($result && $row = $result->fetch_assoc()) {
      $nama_pegawai = $row['nama_pegawai'];
  }

  $_SESSION['no'] = $update_no;
  $_SESSION['nama'] = $nama_pegawai;

  $update_sql = "UPDATE absensi SET waktu_keluar = '$waktu_keluar' WHERE no = $update_no";

  if ($koneksi->query($update_sql) === TRUE) {
      header("Location: kegiatan.php");
      exit();
  } else {
      echo "Error saat mengupdate data:". $koneksi->error;
  }
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
    <title>Riwayat Absensi</title>
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
        <a class="nav-link " href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="riwayat.php">Riwayat</a>
      </li>
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Lainnya
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="login.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
  <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
</svg> Login</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
</svg> Tentang</a></li>
          </ul>
        </li>
    </ul>
  </div>
</nav><br><br><br>
<div class="konten">
<div class="container mt-5">
    <h2 class="h2">Riwayat Absensi</h2><br>
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
        $tanggal_hari_ini = date('Y-m-d');
        $sqlh = "SELECT * FROM absensi WHERE tanggal = '$tanggal_hari_ini'";
        $resulth = $conn -> query($sqlh);
        if ($resulth->num_rows > 0) {
            while ($row = $resulth->fetch_assoc()) {
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
                    if($row["keterangan"] == "hadir" && $row["waktu_keluar"] == null){
                            echo "<form method='post' style='display:inline;'>
                                <input type='hidden' name='update_no' value='".$row['no']."'>
                                <button type='submit' class='btn btn-success ' name='absen_pulang' value='Absen Pulang'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-door-open' viewBox='0 0 16 16'>
                                <path d='M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1'/>
                                <path d='M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117M11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5M4 1.934V15h6V1.077z'/>
                              </svg>absen pulang
                                </button>
                            </form>";
                    }elseif ($row["keterangan"] == "sakit") {
                        echo "semoga lekas sembuh";
                    }elseif ($row["keterangan"] == "izin") {
                        echo "izin hari ini";
                    }else{
                        echo "sampai jumpa";
                    }
                echo "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='9' class='text-center'>Belum ada data absensi</td></tr>";
        }
        $conn->close();
        ?>
        </tbody>
    </table>
</div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
const nomorCells = document.querySelectorAll(".no");
        nomorCells.forEach((cell, index) => {
          cell.textContent=index+1;
        });
});
</script>

<br>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
