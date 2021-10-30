<?php

$conn = mysqli_connect("localhost", "root", "", "learn-php");


function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);

    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function tambah($data)
{
    global $conn;

    $nama = htmlspecialchars($data["nama"]);
    $nrp = htmlspecialchars($data["nrp"]);
    $email = htmlspecialchars($data["email"]);
    $ipk = htmlspecialchars($data["ipk"]);
    $semester = htmlspecialchars($data["semester"]);

    $query = "INSERT INTO mahasiswa VALUES
    ('','$nrp','$nama','$email','$ipk', '$semester')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapus($id)
{
    global $conn;

    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

    return mysqli_affected_rows($conn);
}


function ubah($data)
{
    global $conn;

    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $nrp = htmlspecialchars($data["nrp"]);
    $email = htmlspecialchars($data["email"]);
    $ipk = htmlspecialchars($data["ipk"]);
    $semester = htmlspecialchars($data["semester"]);

    $query = "UPDATE mahasiswa SET
                nama = '$nama',
                nrp = '$nrp',
                email = '$email',
                ipk = '$ipk',
                semester = $semester
            WHERE id = $id
            
            ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function cari($keyword)
{
    $query = "SELECT * FROM mahasiswa WHERE
                nama LIKE '%$keyword%' OR
                nrp LIKE '%$keyword%' OR
                email LIKE '%$keyword%' OR
                semester LIKE '%$keyword%'

            ";

    return query($query);
}

function registrasi($data)
{
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    $result = mysqli_query($conn, "SELECT username FROm users WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('username telah digunakan');
                </script>";

        return false;
    }

    if ($password !== $password2) {
        echo "<script>
                alert('Konfirmasi password tidak sesuai');
                </script>";

        return false;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);


    mysqli_query($conn, "INSERT INTO users VALUES('', '$username', '$password')");

    return mysqli_affected_rows($conn);
}

function countmahasiswa($querycount)
{
    global $conn;

    $result = mysqli_query($conn, $querycount);

    return mysqli_num_rows($result);
}

function ipkaverage($querychart)
{
    global $conn;
    $result = mysqli_query($conn, $querychart);

    return mysqli_fetch_array($result);
}
