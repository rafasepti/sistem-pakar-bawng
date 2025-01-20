<?php
// Koneksi ke database
include('../../koneksi.php');

session_start();
$iduser = $_SESSION['iduser'];

if (isset($_POST['selanjutnya'])) {
    $gejala = $_POST['gejala'];
    // Mulai transaksi
    mysqli_begin_transaction($konek_db);

    try {
        // Loop melalui array gejala
        foreach ($gejala as $idgejala) {
            $query = "INSERT INTO temp_cek (iduser, idgejala) VALUES ('$iduser', '$idgejala')";
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
        header('Location: input_cf_diagnosa.php');
        exit();
    }
}

if (isset($_POST['cek_penyakit'])) {
    // Ambil data gejala yang dipilih dari form
    $selected_gejala = $_POST['idgejala']; // Array berisi ID gejala yang dipilih
    $user_cf = $_POST['cf']; // Array tingkat keyakinan pengguna

    print_r($user_cf);

    // Siapkan variabel untuk hasil perhitungan CF
    $hasil_cf = [];

    // Iterasi untuk menghitung CF setiap penyakit
    foreach ($selected_gejala as $idgejala) {
        // Ambil data penyakit terkait gejala ini
        $query = "
            SELECT idpenyakit
            FROM basispengetahuan
            WHERE idgejala = '$idgejala'
        ";
        $result = mysqli_query($konek_db, $query);

        // Tingkat keyakinan pengguna untuk gejala ini
        $cf_user = isset($user_cf[$idgejala]) ? floatval($user_cf[$idgejala]) : 0.5; // Default 0.5 jika tidak ada
        print_r($cf_user);
        // Proses setiap hasil
        while ($row = mysqli_fetch_assoc($result)) {
            $idpenyakit = $row['idpenyakit'];

            // Nilai CF pakar (misalnya default 0.8, bisa disesuaikan)
            $cf_pakar = 0.8;

            // Gabungkan CF pakar dan pengguna
            $cf = $cf_pakar * $cf_user;

            // Jika penyakit sudah ada dalam hasil, kombinasikan CF
            if (isset($hasil_cf[$idpenyakit])) {
                $cf_sebelumnya = $hasil_cf[$idpenyakit];
                $hasil_cf[$idpenyakit] = $cf_sebelumnya + ($cf * (1 - $cf_sebelumnya));
            } else {
                // Jika belum, tambahkan penyakit ke hasil
                $hasil_cf[$idpenyakit] = $cf;
            }
        }
    }

    // Urutkan hasil CF dari yang tertinggi ke terendah
    arsort($hasil_cf);

    // Ambil informasi penyakit dengan CF tertinggi
    $penyakit_terdeteksi = key($hasil_cf);
    $cf_tertinggi = current($hasil_cf);

    // Ambil detail penyakit
    $query_penyakit = "
        SELECT namapenyakit, fisikmekanis, kulturteknis
        FROM penyakit
        WHERE idpenyakit = '$penyakit_terdeteksi'
    ";
    $result_penyakit = mysqli_query($konek_db, $query_penyakit);
    $detail_penyakit = mysqli_fetch_assoc($result_penyakit);

    $query1 = "SELECT g.idgejala, g.gejala from temp_cek tc
                INNER JOIN  gejala g on tc.idgejala = g.idgejala
                where iduser = ?";
    $stmt = $konek_db->prepare($query1);
    $stmt->bind_param("i", $_SESSION['iduser']);
    $stmt->execute();
    $result = $stmt->get_result();

    // Ambil semua data sebagai array
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Simpan data ke $_SESSION
    $_SESSION['temp_cek'] = $data;

    $hapus_query = "DELETE from temp_cek where iduser='" . $iduser . "'";
    mysqli_query($konek_db, $hapus_query);

    // Tutup koneksi
    $stmt->close();
    $konek_db->close();

    // Tampilkan hasil
    if ($detail_penyakit) {
        $_SESSION['namapenyakit'] = $detail_penyakit['namapenyakit'];
        $_SESSION['fisikmekanis'] = $detail_penyakit['fisikmekanis'];
        $_SESSION['kulturteknis'] = $detail_penyakit['kulturteknis'];
        $_SESSION['cf_tertinggi'] = round($cf_tertinggi * 100, 2);
        header('Location: hasil_diagnosa.php');
        exit();
    } else {
        $_SESSION['namapenyakit'] = "Penyakit tidak ditemukan.";
        header('Location: hasil_diagnosa.php');
        exit();
    }
}
