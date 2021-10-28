<?php

session_start();
require 'functions.php';

if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    $result = mysqli_query($conn, "SELECT username FROM users WHERE id = $id");

    $row = mysqli_fetch_assoc($result);

    if ($key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
    }
}

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row["password"])) {

            $_SESSION["login"] = true;

            if (isset($_POST['remember'])) {


                setcookie('id', $row['id'], time() + 360);
                setcookie('key', hash('sha256', $row['username']), time() + 360);
            }

            header("Location: index.php");
            exit;
        }
    }
    $error = true;
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <title>Login Page</title>
</head>

<body>
    <div class="container mt-5 mb-5 d-flex justify-content-center">
        <div class="card px-1 py-4 justify-content-center">
            <div class="card-body">
                <h1 class="text-center">Login</h1>

                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger" role="alert">
                        Username atau password salah
                    </div>
                <?php endif; ?>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group mb-4">
                                <label for="username">Username</label>
                                <input class="form-control" type="text" placeholder="Input your username" id="username" name="username">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group mb-4">
                                <label for="password">Password</label>
                                <input class="form-control" type="password" placeholder="Input your password" id="password" name="password">
                            </div>
                        </div>
                    </div>
                    <div class="row px-3 mb-4">
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input id="remember" type="checkbox" name="remember" class="custom-control-input">
                            <label for="remember" class="custom-control-label text-sm">Remember me</label>
                        </div>
                    </div>
                    <div class="text-center mb-2">
                        <button type="submit" class="btn btn-primary confirm-button px-4 w-100" name="login">Login</button>
                    </div>
                    <div class="row mb-4 px-3"> <small class="font-weight-bold">Don't have an account? <a class="text-primary" href="registrasi.php">Register</a></small> </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>