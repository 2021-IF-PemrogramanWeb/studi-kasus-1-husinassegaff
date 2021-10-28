<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}


require 'functions.php';

$mahasiswa = query("SELECT * FROM mahasiswa");

if (isset($_POST["cari"])) {
    $mahasiswa = cari($_POST["keyword"]);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Halaman Admin</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">Admin Page</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <button type="button" class="btn btn-light">Logout</button>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container pt-4">


        <form action="" method="POST">
            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control" name="keyword" size="50" autofocus placeholder="Masukkan data mahasiswa" autocomplete="off">
                </div>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-secondary mb-2" name="cari">Cari</button>
            </div>
        </form>


        <a href="tambah.php">
            <button type="button" class="btn btn-dark">Tambah Data</button>
        </a>



        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">NRP</th>
                        <th scope="col">Email</th>
                        <th scope="col">IPK</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1 ?>
                    <?php
                    foreach ($mahasiswa as $mhs) :
                    ?>
                        <tr>
                            <td><?= $index ?></td>
                            <td><?= $mhs["nama"]; ?></td>
                            <td><?= $mhs["nrp"]; ?></td>
                            <td><?= $mhs["email"]; ?></td>
                            <td><?= $mhs["ipk"]; ?></td>
                            <td>
                                <a href="ubah.php?id=<?= $mhs["id"]; ?>">
                                    <button type="button" class="btn btn-warning">
                                        Edit
                                    </button>
                                </a>
                            </td>
                            <td>
                                <a href="hapus.php?id=<?= $mhs["id"]; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data mahasiswa ini?');">
                                    <button type="button" class="btn btn-danger">
                                        Delete
                                    </button>
                                </a>
                            </td>
                        </tr>
                        <?php $index++ ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>