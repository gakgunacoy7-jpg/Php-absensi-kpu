<?php
session_start();
if (isset($_POST['submit'])) {
$koneksi = mysqli_connect("sql12.freesqldatabase.com", "sql12792283", "JBgF42AwPC", "sql12792283");

$nama= $_POST['nama'];
$password = $_POST['password'];

$nama = mysqli_real_escape_string($koneksi, $nama);
$password = mysqli_real_escape_string($koneksi, $password);

$query = "SELECT * FROM user WHERE nama = '$nama' AND password = md5('$password')";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) == 0) { 
echo"<script>alert('Nama atau password salah!');
window.location.assign('login.php');</script>";
exit();
} else {
  $data = mysqli_fetch_assoc($result);
  $_SESSION["nama"] = $data['nama'];
  $_SESSION["status"] = $data['status'];

  if($data['status'] == 'admin'){
  header("Location: admin.php");
  exit();
}else{
  echo"<script>alert('status tidak dikenali');
  window.location.assign('login.php');</script>";
}
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>
<body class="body">
 
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
<br>

<div class="konten3">

<div class="login-container">
<h1 class="login">Silahkan login</h1>
  <form action="login.php" method="post">
    <table class="tabel">
      <tr>
        <td>Nama:</td>
        <td><input type="text" class="input1" name="nama" required></td>
      </tr>
      <tr>
        <td>Password:</td>
        <td><input type="password" class="input1" name="password" required></td>
      </tr>
      <tr>
        <td colspan="2" style="text-align:center;">
        <button type="submit" value="login" name="submit" class="btn btn-primary" ><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z"/>
  <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
</svg> login
        </button>
        </td>
      </tr>
    </table>
  </form>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>