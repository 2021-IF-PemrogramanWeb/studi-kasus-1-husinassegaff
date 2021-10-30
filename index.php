<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}


require 'functions.php';

$datapagination = 5;

$datasum = count(query("SELECT * FROM mahasiswa"));
$page = ceil($datasum / $datapagination);
$activepage = (isset($_GET["page"])) ?  $_GET["page"] : 1;
$index = ($datapagination * $activepage) - $datapagination;

$mahasiswa = query("SELECT * FROM mahasiswa LIMIT $index, $datapagination");

if (isset($_POST["cari"])) {
    $mahasiswa = cari($_POST["keyword"]);
}


$ipkaverage_3 = ipkaverage("SELECT ROUND(AVG(ipk),2) FROM mahasiswa WHERE semester = '3'");
$countmhs_3 = countmahasiswa("SELECT * FROM mahasiswa WHERE semester = '3'");
$ipkaverage_5 = ipkaverage("SELECT ROUND(AVG(ipk),2) FROM mahasiswa WHERE semester = '5'");
$countmhs_5 = countmahasiswa("SELECT * FROM mahasiswa WHERE semester = '5'");
$ipkaverage_7 = ipkaverage("SELECT ROUND(AVG(ipk),2) FROM mahasiswa WHERE semester = '7'");
$countmhs_7 = countmahasiswa("SELECT * FROM mahasiswa WHERE semester = '7'");



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js" integrity="sha512-GMGzUEevhWh8Tc/njS0bDpwgxdCJLQBWG3Z2Ct+JGOpVnEmjvNx6ts4v6A2XJf1HOrtOsfhv3hBKpK9kE5z8AQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Halaman Admin</title>
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
    <div class="container mt-5">
        <div class="row justify-content-between">
            <div class="col-4">
                <a href="tambah.php">
                    <button type="button" class="btn btn-dark">Add Data</button>
                </a>
            </div>
            <div class="col-5">
                <form class="form-inline" action="" method="POST">
                    <div class="row">
                        <div class="col-9">
                            <input type="text" class="form-control mb-2" name="keyword" placeholder="Cari data mahasiswa" autocomplete="off">
                        </div>
                        <div class="col-3">
                            <button type="submit" class="btn btn-dark mb-2" name="cari">Cari</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <div class="table-responsive text-center">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">NRP</th>
                        <th scope="col">Email</th>
                        <th scope="col">Semester</th>
                        <th scope="col">IPK</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1 ?>
                    <?php
                    foreach ($mahasiswa as $mhs) :
                    ?>
                        <tr>
                            <td><?= $i + $index ?></td>
                            <td><?= $mhs["nama"]; ?></td>
                            <td><?= $mhs["nrp"]; ?></td>
                            <td><?= $mhs["email"]; ?></td>
                            <td><?= $mhs["semester"]; ?></td>
                            <td><?= $mhs["ipk"]; ?></td>
                            <td>
                                <a href="ubah.php?id=<?= $mhs["id"]; ?>">
                                    <button type="button" class="btn btn-outline-warning px-0 py-1">
                                        <img src="icons/edit.png" class="img-fluid" alt="edit-icon" width="60%">
                                    </button>
                                </a>
                            </td>
                            <td>
                                <a href="hapus.php?id=<?= $mhs["id"]; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data <?= $mhs['nama']; ?>?');">
                                    <button type="button" class="btn btn-outline-danger px-0 py-1">
                                        <img src="icons/delete.png" class="img-fluid" alt="delete-icon" width="60%">
                                    </button>
                                </a>
                            </td>
                        </tr>
                        <?php $i++ ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="my-3">
            <nav aria-label="...">
                <ul class="pagination">
                    <?php if ($activepage > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $activepage - 1; ?>">
                                Previous
                            </a>
                        </li>
                    <?php elseif ($activepage == 1) : ?>
                        <li class="page-item disabled">
                            <a class="page-link" href="?page=<?= $activepage; ?>">
                                Previous
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $page; $i++) : ?>
                        <?php if ($i == $activepage) : ?>
                            <li class="page-item active">
                                <a class="page-link" href="?page=<?= $i; ?>">
                                    <?= $i; ?>
                                </a>
                            </li>
                        <?php else : ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $i; ?>">
                                    <?= $i; ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($activepage < $page) : ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $activepage + 1; ?>">
                                Next
                            </a>
                        </li>
                    <?php elseif ($activepage == $page) : ?>
                        <li class="page-item disabled">
                            <a class="page-link" href="?page=<?= $activepage; ?>">
                                Next
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </nav>
        </div>


        <!-- chartjs -->
        <div class="pt-3">
            <p>
                <button class="btn btn-success w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" name="buttonchart">
                    Open Chart
                </button>
            </p>
        </div>
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <div class="table-responsive text-center my-3">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Semester</th>
                                <th scope="col">Jumlah Mahasiswa</th>
                                <th scope="col">IPK Rata-Rata</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>3</th>
                                <td><?= $countmhs_3; ?></td>
                                <td><?= $ipkaverage_3[0]; ?></td>
                            </tr>
                            <tr>
                                <th>5</th>
                                <td><?= $countmhs_5; ?></td>
                                <td><?= $ipkaverage_5[0]; ?></td>
                            </tr>
                            <tr>
                                <th>7</th>
                                <td><?= $countmhs_7; ?></td>
                                <td><?= $ipkaverage_7[0]; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <canvas id="bar-chart" width="800" height="450"></canvas>
                <script>
                    new Chart(document.getElementById("bar-chart"), {
                        type: 'bar',
                        data: {
                            labels: ["Semester 3", "Semester 5", "Semester 7"],
                            datasets: [{
                                label: "IPK Rata-Rata",
                                backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f"],
                                data: [<?= $ipkaverage_3[0]; ?>, <?= $ipkaverage_5[0]; ?>, <?= $ipkaverage_7[0]; ?>]

                            }]
                        },
                        options: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Nilai IPK Rata-Rata Mahasiswa'
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</body>

</html>