<?php
include('../../koneksi.php');
$idgejala = $_POST['idgejala'];
$gejala = $_POST['gejala'];
$daerah = $_POST['daerah'];
$jenistanaman = "Bawang";
$error = '';
session_start();
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (isset($_POST['tambah_gejala'])) {
    $query = "INSERT INTO gejala (`idgejala`, `gejala`, `daerah`, `jenistanaman`)
    VALUES ('$idgejala', '$gejala', '$daerah', '$jenistanaman')
    ";
    $result = mysqli_query($konek_db, $query);
    if ($result) {
        // Set session untuk pesan sukses
        $_SESSION['success_message'] = "Data berhasil ditambahkan!";
    
        // Redirect ke halaman lain
        header('Location: gejala.php');
        exit();
    }
} 

if (isset($_POST['edit_gejala'])) {
    $query = "UPDATE gejala SET
    gejala='$gejala',
    daerah='$daerah',
    jenistanaman='$jenistanaman'
    WHERE idgejala = '$idgejala'
    ";
    //echo $query;
    $result = mysqli_query($konek_db, $query);
    if ($result) {
       // Set session untuk pesan sukses
       $_SESSION['success_message'] = "Data berhasil diubah!";
    
       // Redirect ke halaman lain
       header('Location: gejala.php');
       exit();
    }
}
