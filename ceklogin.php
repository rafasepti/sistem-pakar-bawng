<?php
include('koneksi.php');
$username = $_POST['username'];
$password = $_POST['password'];
$error = '';
session_start();
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$user = mysqli_query($konek_db, "SELECT * FROM user WHERE username='$username' and password='$password'");
$cek = mysqli_num_rows($user);

if ($cek > 0) {
    session_start();
    $data = mysqli_fetch_assoc($user);
    // cek jika user login sebagai admin
    if ($data['level'] == "admin") {

        // buat session login dan username
        $_SESSION['login_user'] = $username;
        $_SESSION['level'] = "admin";
        header('location:admin/homeadmin.php');
    } else if ($data['level'] == "user") {

        $_SESSION['login_user'] = $username;
        $_SESSION['level'] = "user";
        header('location:index.php');
    }
} else {
    session_start();
    $_SESSION['error'] = "Username atau password salah!";
    header('location:login.php');
}
