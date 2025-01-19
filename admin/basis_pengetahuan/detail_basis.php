<?php
include('../../koneksi.php');
?>
<!DOCTYPE html>
<html x-data="data()" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SBP</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.9.2/tailwind.min.css">
    <link rel="stylesheet" href="../../assets/css/tailwind.output.css" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <!-- jQuery (dibutuhkan oleh DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
        defer></script>
    <script src="../../assets/js/init-alpine.js"></script>
    <script src="../../assets/js/validator.js"></script>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
        defer></script>
    <script src="../../assets/js/charts-lines.js" defer></script>
    <script src="../../assets/js/charts-pie.js" defer></script>
</head>

<body>
    <div
        class="flex h-screen bg-gray-50 dark:bg-gray-900"
        :class="{ 'overflow-hidden': isSideMenuOpen }">
        <!-- Desktop sidebar -->
        <?php include('../component/sidebar_desktop.php') ?>
        <!-- Mobile sidebar -->
        <!-- Backdrop -->
        <?php include('../component/sidebar_mobile.php') ?>
        <div class="flex flex-col flex-1 w-full">
            <?php include('../component/header.php') ?>
            <main class="h-full overflow-y-auto">
                <div class="container px-6 mx-auto grid">
                    <h2
                        class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                        Detail Data
                    </h2>
                    <!-- CTA -->
                    <div
                        class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
                        href="https://github.com/estevanmaito/windmill-dashboard">
                        <div class="flex items-center">
                            <svg
                                class="w-5 h-5 mr-2"
                                fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span>Penyakit</span>
                        </div>
                    </div>
                    <?php
                    $id = $_GET['id'];

                    // Pastikan $id divalidasi, misalnya hanya angka:
                    // Validasi: Pastikan $id hanya berisi huruf dan angka
                    if (!preg_match('/^[a-zA-Z0-9]+$/', $id)) {
                        die("ID tidak valid.");
                    }

                    $sql = " SELECT 
                            p.idpenyakit, 
                            p.namapenyakit,
                            GROUP_CONCAT(g.idgejala SEPARATOR ', ') AS daftar_gejala
                        FROM 
                            basispengetahuan bp
                        INNER JOIN 
                            penyakit p ON bp.idpenyakit = p.idpenyakit
                        INNER JOIN 
                            gejala g ON bp.idgejala = g.idgejala
                        GROUP BY 
                            p.idpenyakit;";
                    $result = mysqli_query($konek_db, $sql);

                    while ($data = $result->fetch_assoc()) {
                    ?>
                        <div
                            class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                            <form id="formBasis" data-toggle="validator" action="aksi_basis.php" method="POST" role="form">
                                <label class="block mt-4 text-sm">
                                    <h5 class="text-gray-700 dark:text-gray-400">
                                        Hama/Penyakit
                                    </h5>
                                    <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                        name="idpenyakit"
                                        id="idpenyakit"
                                        required
                                        disabled
                                        data-error="Penyakit wajib diisi.">
                                        <option value="">Pilih Penyakit</option>
                                        <?php
                                        $tampil = "select * from penyakit where jenistanaman = 'Bawang'";
                                        $query1 = mysqli_query($konek_db, $tampil);
                                        while ($hasil = mysqli_fetch_array($query1)) {
                                            echo "<option value='" . $hasil['idpenyakit'] . "'" . ($hasil['idpenyakit'] == $data['idpenyakit'] ? 'selected' : '') . ">" . $hasil['idpenyakit'] . " " . $hasil['namapenyakit'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <span class="text-xs text-red-600 help-block with-errors dark:text-red-400"></span>
                                </label>
                                <h6
                                    class="mb-2 mt-4 text-l font-semibold text-gray-600 dark:text-gray-300">
                                    Gejala
                                </h6>
                                <?php
                                function tampilkanGejala($daerah, $jenistanaman, $gejala_array, $konek_db)
                                {
                                    // Query untuk menampilkan gejala berdasarkan daerah dan jenis tanaman
                                    $tampil = "SELECT * FROM gejala WHERE daerah='$daerah' AND jenistanaman='$jenistanaman'";
                                    $query = mysqli_query($konek_db, $tampil);

                                    // Tampilkan checkbox
                                    while ($hasil = mysqli_fetch_array($query)) {
                                        $idgejala = $hasil['idgejala'];
                                        $gejala = $hasil['gejala'];

                                        // Periksa apakah idgejala ada di dalam array gejala_array
                                        $checked = in_array($idgejala, $gejala_array) ? 'checked' : '';

                                        echo "<label class='flex items-center space-x-2'>
                                            <input type='hidden' value='$idgejala' name='gejala[]' />
                                            <input type='checkbox' value='$idgejala' style='appearance: none; width: 1.25rem; height: 1.25rem; background-color: " . ($checked ? '#805AD5' : '#e5e7eb') . "; border: 2px solid " . ($checked ? '#805AD5' : '#d1d5db') . ";' class='rounded focus:ring-purple-500' $checked disabled />
                                            <h4 class='text-sm flex-grow'>$gejala</h4>
                                        </label>";
                                    }
                                }
                                ?>
                                <div class="mt-4 min-w-0 bg-white rounded-lg shadow-xs border border-gray-300 dark:bg-gray-800">
                                    <h4 class="font-semibold text-white bg-purple-600 rounded-t-lg p-4 dark:text-gray-300">
                                        Akar
                                    </h4>
                                    <div class="p-4 dark:text-gray-400">
                                        <div class="grid grid-cols-3 gap-2">
                                            <?php
                                            // Daftar gejala terpilih (contoh data)
                                            $daftar_gejala = $data['daftar_gejala']; // Data masih berupa string
                                            $gejala_array = explode(', ', $daftar_gejala); // Ubah menjadi array

                                            // Panggil fungsi untuk daerah 'akar'
                                            tampilkanGejala('akar', 'Bawang', $gejala_array, $konek_db);
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 min-w-0 bg-white rounded-lg shadow-xs border border-gray-300 dark:bg-gray-800">
                                    <h4 class="font-semibold text-white bg-purple-600 rounded-t-lg p-4 dark:text-gray-300">
                                        Batang
                                    </h4>
                                    <div class="p-4 dark:text-gray-400">
                                        <div class="grid grid-cols-3 gap-2">
                                            <?php
                                            // Panggil fungsi untuk daerah 'batang'
                                            tampilkanGejala('batang', 'Bawang', $gejala_array, $konek_db);
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="mt-4 min-w-0 bg-white rounded-lg shadow-xs border border-gray-300 dark:bg-gray-800">
                                    <h4 class="font-semibold text-white bg-purple-600 rounded-t-lg p-4 dark:text-gray-300">
                                        Daun
                                    </h4>
                                    <div class="p-4 dark:text-gray-400">
                                        <div class="grid grid-cols-3 gap-2"> <!-- Atur grid dan jarak antar checkbox -->
                                        <?php
                                            // Panggil fungsi untuk daerah 'batang'
                                            tampilkanGejala('daun', 'Bawang', $gejala_array, $konek_db);
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="mt-4 min-w-0 bg-white rounded-lg shadow-xs border border-gray-300 dark:bg-gray-800">
                                    <h4 class="font-semibold text-white bg-purple-600 rounded-t-lg p-4 dark:text-gray-300">
                                        Buah
                                    </h4>
                                    <div class="p-4 dark:text-gray-400">
                                        <div class="grid grid-cols-3 gap-2"> <!-- Atur grid dan jarak antar checkbox -->
                                            <?php
                                            // Panggil fungsi untuk daerah 'batang'
                                            tampilkanGejala('buah/umbi', 'Bawang', $gejala_array, $konek_db);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="mt-4 min-w-0 bg-white rounded-lg shadow-xs border border-gray-300 dark:bg-gray-800">
                                    <h4 class="font-semibold text-white bg-purple-600 rounded-t-lg p-4 dark:text-gray-300">
                                        Bunga
                                    </h4>
                                    <div class="p-4 dark:text-gray-400">
                                        <div class="grid grid-cols-3 gap-2"> <!-- Atur grid dan jarak antar checkbox -->
                                            <?php
                                            // Panggil fungsi untuk daerah 'batang'
                                            tampilkanGejala('bunga', 'Bawang', $gejala_array, $konek_db);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="mt-4 min-w-0 bg-white rounded-lg shadow-xs border border-gray-300 dark:bg-gray-800">
                                    <h4 class="font-semibold text-white bg-purple-600 rounded-t-lg p-4 dark:text-gray-300">
                                        Biji
                                    </h4>
                                    <div class="p-4 dark:text-gray-400">
                                        <div class="grid grid-cols-3 gap-2"> <!-- Atur grid dan jarak antar checkbox -->
                                        <?php
                                            // Panggil fungsi untuk daerah 'batang'
                                            tampilkanGejala('biji', 'Bawang', $gejala_array, $konek_db);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </main>
        </div>
    </div>
</body>

</html>