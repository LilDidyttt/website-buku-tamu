<?php
session_start();
require 'function.php';

$sukses = "";
$error = "";

if (isset($_SESSION["login"])) {
  header("Location: index.php");
  exit;
}

if ( isset($_POST["register"]) ) {

  if ( registrasi($_POST) > 0 ) {
    echo "<script>
				alert('user baru berhasil ditambahkan!');
			  </script>";
  } else {
    echo mysqli_error($conn);
  }

}

if ($error) {
  echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
}

if ($sukses) {
  echo '<div class="alert alert-success" role="alert">' . $sukses . '</div>';
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
  <title>Register Akun</title>
  <style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    }

    footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 10px;
    position: fixed;
    bottom: 0;
    width: 100%;
    }

    .container {
    max-width: 800px;
    width: 650px;
    height: 500px;
    }

    .card {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    height: 540px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
    text-align: center;
    color: #333;
    }

    ul {
    list-style: none;
    padding: 0;
    }

    li {
    margin-bottom: 15px;
    }

    label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    }

    input {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    margin-bottom: 10px;
    box-sizing: border-box;
    }

    button {
    background-color: #4caf50;
    color: #fff;
    padding: 10px 15px;
    margin-top: 30px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    }

    .register-link {
    text-align: center;
    margin-top: 10px;
    }

    .register-link a {
    color: hsl(130.1,79.8%,23.6%);
    text-decoration: none;
    }

    .register-link a:hover {
    text-decoration: underline;
    }


  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <h1>REGISTER</h1>
      <form action="" method="POST">
        <ul>
          <li>
            <label for="username">Username :</label>
            <input type="text" name="username">
          </li>
          <li>
            <label for="password">Password :</label>
            <input type="password" name="password">
          </li>
          <li>
            <label for="passowrd2">Konfirmasi password :</label>
            <input type="password" name="password2">
          </li>
          <li>
            <button type="submit" name="register">Daftar</button>
          </li>
        </ul>
      </form>
      <div class="register-link">
        <p>
          Sudah memiliki akun? <a href="login.php">Login</a>
        </p>
      </div>
    </div>
  </div>
  <footer>
    &copy; 2024 Website Kelompok 2
  </footer>
</body>
</html>