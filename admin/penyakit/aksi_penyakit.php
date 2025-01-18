<?php
include('../../koneksi.php');
$idpenyakit = $_POST['idpenyakit'];
$namapenyakit = $_POST['namapenyakit'];
$kulturteknis = $_POST['kulturteknis'];
$fisikmekanis = $_POST['fisikmekanis'];
$kimiawi = $_POST['kimiawi'];
$hayati = $_POST['hayati'];
$error = '';
session_start();
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (isset($_POST['tambah_penyakit'])) {
    $query = "INSERT INTO penyakit SET idpenyakit='$idpenyakit',
    namapenyakit='$namapenyakit',
    kulturteknis='$kulturteknis',
    jenistanaman='Bawang',
    fisikmekanis='$fisikmekanis',
    kimiawi='$kimiawi',
    hayati='$hayati'
    ";
    $result = mysqli_query($konek_db, $query);
    if ($result) {
        // Set session untuk pesan sukses
        $_SESSION['tambah_success_message'] = "Data berhasil ditambahkan!";
    
        // Redirect ke halaman lain
        header('Location: penyakit.php');
        exit();
    }
} 

if (isset($_POST['edit_penyakit'])) {
    $query = "UPDATE penyakit SET
    namapenyakit='$namapenyakit',
    kulturteknis='$kulturteknis',
    fisikmekanis='$fisikmekanis',
    kimiawi='$kimiawi',
    hayati='$hayati'
    WHERE idpenyakit = '$idpenyakit'
    ";
    //echo $query;
    $result = mysqli_query($konek_db, $query);
    if ($result) {
        echo '<script language="javascript">';
        header('location:penyakit.php');
        echo '</script>';
    }
}
