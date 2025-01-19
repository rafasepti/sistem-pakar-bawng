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
        $_SESSION['success_message'] = "Data berhasil ditambahkan!";
        header('Location: basis.php');
        exit();
    }
} 

if (isset($_POST['edit_basis'])) {
    // Mulai transaksi
    mysqli_begin_transaction($konek_db);

    try {
        $idpenyakit = $_POST['idpenyakit'];
        $gejala_baru = isset($_POST['gejala']) ? $_POST['gejala'] : [];

        // Ambil gejala lama dari database
        $query_lama = "SELECT idgejala FROM basispengetahuan WHERE idpenyakit='$idpenyakit'";
        $result_lama = mysqli_query($konek_db, $query_lama);
        $gejala_lama = [];

        while ($row = mysqli_fetch_assoc($result_lama)) {
            $gejala_lama[] = $row['idgejala'];
        }

        // Gejala yang akan ditambahkan (ada di gejala_baru tapi tidak di gejala_lama)
        $gejala_tambah = array_diff($gejala_baru, $gejala_lama);

        // Gejala yang akan dihapus (ada di gejala_lama tapi tidak di gejala_baru)
        $gejala_hapus = array_diff($gejala_lama, $gejala_baru);

        // Tambahkan gejala baru
        foreach ($gejala_tambah as $idgejala) {
            $query_tambah = "INSERT INTO basispengetahuan (idpenyakit, idgejala) VALUES ('$idpenyakit', '$idgejala')";
            mysqli_query($konek_db, $query_tambah);
        }

        // Hapus gejala yang tidak dipilih
        foreach ($gejala_hapus as $idgejala) {
            $query_hapus = "DELETE FROM basispengetahuan WHERE idpenyakit='$idpenyakit' AND idgejala='$idgejala'";
            mysqli_query($konek_db, $query_hapus);
        }

        // Commit transaksi
        $result = mysqli_commit($konek_db);

        if ($result) {
            $_SESSION['success_message'] = "Data berhasil diubah!";
            header('Location: basis.php');
            exit();
        }
    } catch (Exception $e) {
        // Rollback jika terjadi error
        mysqli_rollback($konek_db);

        echo "Terjadi kesalahan: " . $e->getMessage();
    }
}
