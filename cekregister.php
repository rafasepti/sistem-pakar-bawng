<?php
include('koneksi.php');
$username = $_POST['username'];
$nama = $_POST['nama'];
$password = $_POST['password'];
$level       = 'user';
$error = '';
session_start();
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$user = mysqli_query($konek_db, "SELECT * FROM user WHERE username='$username'");
$cek = mysqli_num_rows($user);

if ($cek > 0) {
    session_start();
    $_SESSION['error'] = "Username sudah ada";
    header('location:register.php');
} else {
    $query = "INSERT INTO user SET username='$username',password='$password',nama='$nama',level='$level'";
    $result = mysqli_query($konek_db, $query);
    if ($result) {
        echo '<script language="javascript">';
        session_start();
        $_SESSION['login_user'] = $username;
        $_SESSION['level'] = "user";
        header('location:homeuser.php');
        echo '</script>';
    }
}
