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
            <div class="col-8">
                <form class="form-inline" action="" method="POST">

                    <input type="text" class="form-control mb-2 mr-sm-2" name="keyword" placeholder="Cari data mahasiswa" autocomplete="off">
                    <button type="submit" class="btn btn-dark mb-2" name="cari">Cari</button>

                </form>
            </div>
        </div>



        <div class="table-responsive text-center">
            <table class="table table-hover">
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
                                <a href="hapus.php?id=<?= $mhs["id"]; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data mahasiswa ini?');">
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

        <p>
            <button class="btn btn-success w-100" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Open Chart
            </button>
        </p>
        <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <canvas id="bar-chart" width="800" height="450"></canvas>
                <script>
                    new Chart(document.getElementById("bar-chart"), {
                        type: 'bar',
                        data: {
                            labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
                            datasets: [{
                                label: "Population (millions)",
                                backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                                data: [2478, 5267, 734, 784, 433]
                            }]
                        },
                        options: {
                            legend: {
                                display: false
                            },
                            title: {
                                display: true,
                                text: 'Predicted world population (millions) in 2050'
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</body>

</html>