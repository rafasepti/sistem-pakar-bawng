<?php
include('../../koneksi.php');

session_start();

$query="DELETE from gejala where idgejala='".$_GET['id']."'";
mysqli_query($konek_db, $query);

// Set session untuk pesan sukses
$_SESSION['success_message'] = "Data berhasil dihapus!";
    
// Redirect ke halaman lain
header('Location: gejala.php');
exit();
?>