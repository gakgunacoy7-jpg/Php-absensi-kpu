<?php
session_start();

$koneksi = mysqli_connect("sql12.freesqldatabase.com", "sql12792283", "JBgF42AwPC", "sql12792283");

$no = $_SESSION['no'] ?? null;
$nama = $_SESSION['nama'] ?? null;

if (!$no || !$nama) {
  echo "Session tidak tersedia. Silakan absen terlebih dahulu.";
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $kegiatan = $_POST['kegiatan'];

  if (is_array($kegiatan)) {
    $kegiatan = implode("\n", array_map('trim', $kegiatan));
  } else {
    $kegiatan = trim($kegiatan);
  }

  $query = "UPDATE absensi SET kegiatan=? WHERE no=?";
  $stmt = $koneksi->prepare($query);
  $stmt->bind_param("si", $kegiatan, $no);
  $stmt->execute();

  unset($_SESSION['no'], $_SESSION['nama']);
  header("Location: riwayat.php?status=kegiatan_terisi");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kegiatan</title>
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
  </nav>

  <div class="konten4">
    <div class="judul">
      <h1>Isi kegiatan untuk: <?php echo htmlspecialchars($nama); ?></h1>
    </div>
    <br><br>
    <button id="tambah-form" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z"/>
</svg> Tambah Kegiatan</button>
    <form action="" method="post">
      <div id="kolom-container">
        <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label">Kegiatan</label>
          <div class="d-flex">
            <textarea class="form-control" name="kegiatan[]" rows="3" placeholder="silahkan isi"></textarea>
          </div>
        </div>
      </div>
      <button type="submit" name="submit" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
  <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z"/>
</svg> Kirim</button>
    </form>
  </div>

  <script>
    let counter = 0;
    document.getElementById('tambah-form').addEventListener('click', function() {
      counter++;
      var kolom = document.createElement('div');
      kolom.innerHTML = `
        <div class="mb-3">
          <label for="exampleFormControlTextarea1" class="form-label">Kegiatan</label>
          <div class="d-flex">
            <textarea class="form-control" name="kegiatan[]" rows="3" placeholder="silahkan isi"></textarea>
            <button type="button" class="btn btn-danger ms-2" onclick="hapusKolom(this)"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle-fill" viewBox="0 0 16 16">
  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1z"/>
</svg> Batal</button>
          </div>
        </div>
      `;
      document.getElementById('kolom-container').appendChild(kolom);
    });

    function hapusKolom(btn) {
      btn.parentNode.parentNode.remove();
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
