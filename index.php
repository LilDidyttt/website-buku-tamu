<?php
session_start();

require("function.php");

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

$nama = "";
$email = "";
$komentar = "";
$sukses = "";
$error = "";

$userStatus = isset($_SESSION["status"]) ? $_SESSION["status"] : 0;

if (isset($_GET['op'])) {
  $op = $_GET['op'];
} else {
  $op = "";
}

if ($op == 'delete') {
  $id = $_GET['id'];
  $sql1 = "delete from tb_komen where id = '$id'";
  $q1 = mysqli_query($conn, $sql1);
  if ($q1) {
    $sukses = "Berhasil hapus data";
  } else {
    $error = "Gagal melakukan delete data";
  }
}

if ($op == 'edit') {
  $id = $_GET['id'];
  $sql1 = "select * from tb_komen where id = '$id'";
  $q1 = mysqli_query($conn, $sql1);
  $r1 = mysqli_fetch_array($q1);
  $email = $r1['email'];
  $nama = $r1['nama'];
  $komentar = $r1['komentar'];
  $foto = $r1['foto'];

  if ($email == '') {
    $error = "Data tidak ditemukan";
  }
}

if (isset($_POST['submit'])) {
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $komentar = $_POST['komentar'];

  if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] !== "") {
    $allowedExtensions = ['jpg',
      'jpeg',
      'webp',
      'png'];
    $foto = $_FILES['foto']['name'];
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $foto_path = "foto/" . $foto;
    $fileExtension = pathinfo($foto, PATHINFO_EXTENSION);

    if (!empty($foto) && !in_array(strtolower($fileExtension), $allowedExtensions)) {
      $error = "Tipe file salah, pilih tipe file gambar!";
    } else {
      if (move_uploaded_file($foto_tmp, $foto_path)) {
        // Query insert atau update
        if ($email && $nama && $komentar && $foto) {
          if ($op == 'edit') {
            $sql1 = "update tb_komen set email = '$email', nama='$nama', komentar='$komentar', foto = '$foto' where id='$id'";
            $q1 = mysqli_query($conn, $sql1);
            if ($q1) {
              $sukses = "Data berhasil diupdate";
            } else {
              $error = "Data gagal diupdate";
            }
          } else {
            //untuk insert
            $sql1 = "insert into tb_komen(email,nama,foto,komentar) values ('$email','$nama','$foto','$komentar')";
            $q1 = mysqli_query($conn, $sql1);
            if ($q1) {
              $sukses = "Berhasil memasukkan data baru";
            } else {
              $error = "Gagal memasukkan data";
            }
          }
        } else {
          $error = "Silakan masukkan semua data";
        }
        // ...
      } else {
        // Gagal mengunggah foto, beri tahu pengguna atau lakukan tindakan lainnya
        $error = "Gagal mengunggah foto";
      }
    }
  } else {
    // Jika tidak ada file yang diunggah, lanjutkan proses tanpa foto
    if ($email && $nama && $komentar) {
      // Jika ini adalah mode edit, update data tanpa mengubah foto
      if ($op == 'edit') {
        $sql1 = "update tb_komen set email = '$email', nama='$nama', komentar='$komentar' where id='$id'";
      } else {
        // Jika ini adalah mode insert, tambahkan data tanpa foto
        $sql1 = "insert into tb_komen(email,nama,komentar) values ('$email','$nama','$komentar')";
      }

      $q1 = mysqli_query($conn, $sql1);
      if ($q1) {
        $sukses = "Berhasil memasukkan data baru";
      } else {
        $error = "Gagal memasukkan data";
      }
    } else {
      $error = "Silakan masukkan semua data";
    }
  }
}

if ($error) {
  header("refresh:5;url=index.php"); // 5 : detik
  echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
}

if ($sukses) {
  header("refresh:5;url=index.php"); // 5 : detik
  echo '<div class="alert alert-success" role="alert">' . $sukses . '</div>';
}

$role = $_SESSION["status"];

if ($role == 1) {
  $role = "admin";
} else {
  $role = "user";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
  <title>Website Kelompok</title>
</head>

<body>

  <nav>
    <a href="#about">Tentang</a>
    <a href="#portfolio">Anggota</a>
    <a href="#contact">Kontak</a>
    <a href="#comments">Komentar</a>
  </nav>

  <div class="container" id="logout">
    <h1>Selamat datang, <?php echo $_SESSION['username']; ?></h1>
    <h4>Kamu login sebagai <?php echo $role ?></h4>
    <a href="logout.php" class="logout-btn" onclick="return confirm('Yakin mau log out?')">Logout</a>
  </div>


  <div class="container" id="about">
    <h2>Tentang Kami</h2>
    <p>
      Selamat datang di Website Kelompok kami. Ini adalah website dari tugas Pak Wahib Mudhofir.
    </p>
  </div>

  <div class="container" id="portfolio">
    <h2>Nama Anggota</h2>
    <br>
    <div class="portfolio-item">
      <h3>• Rhadit Mika Rahil</h3>
    </div>
    <div class="portfolio-item">
      <h3>• Gilang</h3>
    </div>
    <div class="portfolio-item">
      <h3>• Diana</h3>
    </div>
    <div class="portfolio-item">
      <h3>• Alvita</h3>
    </div>
    <div class="portfolio-item">
      <h3>• Rayna</h3>
    </div>
  </div>

  <div class="container" id="contact">
    <h2>Kontak</h2>
    <p>
      Kontak kami email : rhdt.rhl@gmail.com
    </p>

    <form method="POST" action="" enctype="multipart/form-data">
      <label for="guestName">Nama :</label>
      <input type="text" id="nama" name="nama" required value="<?php echo $nama ?>">

      <label for="guestName">Email :</label>
      <input type="email" id="email" name="email" required value="<?php echo $email ?>">

      <label for="guestName">Foto (opsional) : </label>
      <input type="file" id="foto" name="foto">

      <div class="input-komen">
        <label for="guestComment">Komentar :</label>
        <input value="<?php echo $komentar ?>" id="komentar" name="komentar" type="text" required>
      </div>

      <button type="submit" id="submit" name="submit">Submit</button>
    </form>
  </div>

  <div class="container" id="comments">
    <h2>Komentar</h2>
    <div class="card">
      <div class="card-body">
        <?php
        $sql2 = "select * from tb_komen order by id desc";
        $q2 = mysqli_query($conn, $sql2);
        $urut = 1;
        while ($r2 = mysqli_fetch_array($q2)) {
          $id = $r2['id'];
          $nama = $r2['nama'];
          $email = $r2['email'];
          $komentar = $r2['komentar'];

          ?>
          <div class="comment-container">
            <div class="user-avatar">
              <img src="foto/<?php echo $r2['foto'] ? $r2['foto'] : 'foto.jpg'; ?>" alt="User Avatar" width="50" height="50" style="border-radius: 50%">
            </div>

            <div class="comment-content">
              <div class="user-info">
                <span class="user-name"><?php echo $urut++ ?>. <?php echo $nama ?></span>
              </div>
              <div class="email-info">
                <span class="user-name"><?php echo $email ?></span>
              </div>
              <p class="comment-text">
                <?php echo $komentar ?>
              </p>


              <div class="comment-actions">
                <?php
                // Periksa status admin sebelum menampilkan tombol
                $isAdmin = ($_SESSION["status"] == 1);

                if ($isAdmin) {
                  ?>
                  <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                  <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                  <?php
                }
                ?>
              </div>
            </div>
          </div>
          <?php
        }
        ?>
      </div>
    </div>
  </div>

  <br>
  <br>
  <footer>
    &copy; 2024 Website Kelompok 2
  </footer>

</body>

</html>