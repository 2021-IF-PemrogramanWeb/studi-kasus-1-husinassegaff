<?php
require 'functions.php';

if (isset($_POST["register"])) {
    if (registrasi($_POST) > 0) {
        echo "<script>
                alert('Pengguna berhasil melakukan registrasi');
                </script>
            ";
    } else {
        echo mysqli_error($conn);
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Register Page</title>
</head>

<body>

    <div class="container mt-5 mb-5 d-flex justify-content-center">
        <div class="card px-1 py-4 justify-content-center">
            <div class="card-body">
                <h1 class="text-center">Register</h1>

                <form action="" method="post">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group mb-4">
                                <label for="username">Username</label>
                                <input class="form-control" type="text" name="username" id="username">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group mb-4">
                                <label for="password">Password</label>
                                <input class="form-control" type="password" name="password" id="password">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group mb-4">
                                <label for="password2">Konfirmasi Password</label>
                                <input class="form-control" type="password" name="password2" id="password2">
                            </div>
                        </div>
                    </div>
                    <div class="text-center mb-2">
                        <button class="btn btn-primary confirm-button px-4 w-100" name="register">Register</button>
                    </div>
                    <div class="row mb-4 px-3"> <small class="font-weight-bold">Have an account? <a class="text-primary" href="login.php">Login</a></small> </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>