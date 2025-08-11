<?php
session_start();
date_default_timezone_set("Asia/Jakarta");

if (isset($_POST['submit'])) {
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $keterangan = strtolower($_POST['keterangan']);
    $tanggal = date('Y-m-d');
    $waktu_masuk = ($keterangan == 'hadir') ? date('H:i:s') : NULL;

    $status = ($keterangan == 'sakit' || $keterangan == 'izin') ? ucfirst($keterangan) : 'Hadir';

    $gambar_nama = NULL;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $gambar_nama = basename($_FILES['gambar']['name']);
        $upload_path = 'uploads/' . $gambar_nama;
        move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path);
    }

    $deskripsi = !empty($_POST['deskripsi']) ? $_POST['deskripsi'] : NULL;

    $conn = new mysqli("sql12.freesqldatabase.com", "sql12792283", "JBgF42AwPC", "sql12792283");
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO absensi (nip, nama_pegawai, tanggal, waktu_masuk,keterangan, gambar, deskripsi)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nip, $nama, $tanggal, $waktu_masuk,$keterangan, $gambar_nama, $deskripsi);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    echo "<script>alert('Absen berhasil!'); window.location='index.php';</script>";
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Absen Karyawan KPU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script>
        function toggleExtraFields() {
            const ket = document.getElementById('keterangan').value.toLowerCase();
            const extra = document.getElementById('extraFields');
            if (ket === 'sakit' || ket === 'izin') {
                extra.style.display = 'block';
            } else {
                extra.style.display = 'none';
            }
        }
    </script>
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
        <a class="nav-link active" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="riwayat.php">Riwayat</a>
        
      </li>
      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Lainnya
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="login.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
  <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
</svg> Login</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="tentang.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
</svg> Tentang</a></li>
          </ul>
        </li>
    </ul>
  </div>
</nav><br><br><br><br>

<div class="konten2">
  <h1 style="text-align: center; color: white;">Absen Karyawan KPU</h1>
  <form method="POST" enctype="multipart/form-data" action="index.php" id="absenForm" class="form-container">
    <div class="mb-3">
      <label for="nip" class="form-label">NIP:</label>
      <input type="text" class="form-control" name="nip" required>
    </div>
    <div class="mb-3">
      <label for="nama" class="form-label">Nama:</label>
      <input type="text" class="form-control" name="nama" required>
    </div>
    <div class="mb-3">
      <label for="keterangan" class="form-label">Keterangan:</label>
      <select class="form-control" name="keterangan" id="keterangan" onchange="toggleExtraFields()" required>
        <option value="">Pilih</option>
        <option value="Hadir">Hadir</option>
        <option value="Sakit">Sakit</option>
        <option value="Izin">Izin</option>
      </select>
    </div>
    <div id="extraFields" style="display:none;">
      <div class="mb-3">
        <label for="gambar" class="form-label">Upload Bukti (gambar):</label>
        <input type="file" class="form-control" name="gambar" accept="image/*">
      </div>
      <div class="mb-3">
        <label for="deskripsi" class="form-label">Deskripsi:</label>
        <textarea class="form-control" name="deskripsi" rows="3"></textarea>
      </div>
    </div>
    <button type="submit" name="submit" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
</svg> Absen</button>
  </form>
</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
