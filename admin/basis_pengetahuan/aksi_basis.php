<?php
include('../../koneksi.php');
$idpenyakit = $_POST['idpenyakit'];
$gejala = $_POST['gejala'];
$error = '';
session_start();
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (isset($_POST['tambah_basis'])) {
    // Mulai transaksi
    mysqli_begin_transaction($konek_db);

    try {
        // Loop melalui array gejala
        foreach ($gejala as $idgejala) {
            $query = "INSERT INTO basispengetahuan (idpenyakit, idgejala) VALUES ('$idpenyakit', '$idgejala')";
            mysqli_query($konek_db, $query);
        }

        // Commit transaksi
        $result = mysqli_commit($konek_db);

        echo "Data berhasil disimpan.";
    } catch (Exception $e) {
        // Rollback jika terjadi error
        mysqli_rollback($konek_db);

        echo "Terjadi kesalahan: " . $e->getMessage();
    }
    if ($result) {
        // Set session untuk pesan sukses
        $_SESSION['success_message'] = "Data berhasil ditambahkan!";
    
        // Redirect ke halaman lain
        //header('Location: basis.php');
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
       // Set session untuk pesan sukses
       $_SESSION['success_message'] = "Data berhasil diubah!";
    
       // Redirect ke halaman lain
       header('Location: penyakit.php');
       exit();
    }
}
