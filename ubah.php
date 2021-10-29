<?php

session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

$id = $_GET["id"];

$mhs  = query("SELECT * FROM mahasiswa WHERE id = $id")[0];


if (isset($_POST["submit"])) {

    if (ubah($_POST) > 0) {
        echo "
            <script>
                alert('data berhasil diubah');

                document.location.href = 'index.php';

            </script>
        ";
    } else {
        echo "
        <script>
            alert('data gagal diubah');
        </script>
    ";
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Ubah Data</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <div class="h4">
                    Admin Page
                </div>
            </a>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <button type="button" class="btn btn-light">Logout</button>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5 mb-5 justify-content-center">

        <h2 class="text-center">Ubah Data Mahasiswa</h2>
        <form action="" method="post">
            <input type="hidden" name="id" required value="<?= $mhs["id"]; ?>">
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group mb-4">
                        <label for="nama">Nama Lengkap</label>
                        <input class="form-control" type="text" name="nama" id="nama" required value="<?= $mhs["nama"]; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group mb-4">
                        <label for="nrp">NRP</label>
                        <input class="form-control" type="text" name="nrp" id="nrp" required value="<?= $mhs["nrp"]; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group mb-4">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" name="email" id="email" required value="<?= $mhs["email"]; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group mb-4">
                        <label for="semester">Semester</label>
                        <input class="form-control" type="number" name="semester" id="semester" required value="<?= $mhs["semester"]; ?>">
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group mb-4">
                        <label for="ipk">IPK</label>
                        <input class="form-control" type="number" name="ipk" id="ipk" step="0.01" required value="<?= $mhs["ipk"]; ?>">
                    </div>
                </div>
            </div>
            <div class="text-center mb-2">
                <button class="btn btn-warning confirm-button px-4 w-100" name="submit" type="submit"><strong>Ubah</strong></button>
            </div>
        </form>
</body>

</html>