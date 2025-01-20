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
                        Tambah Data
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
                            <span>Basis Pengetahuan</span>
                        </div>
                    </div>
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
                                    data-error="Penyakit wajib diisi.">
                                    <option value="">Pilih Penyakit</option>
                                    <?php
                                    $tampil = "select * from penyakit where jenistanaman = 'Bawang'";
                                    $query1 = mysqli_query($konek_db, $tampil);
                                    while ($hasil = mysqli_fetch_array($query1)) {
                                        echo "<option value='" . $hasil['idpenyakit'] . "'>" . $hasil['idpenyakit'] . " " . $hasil['namapenyakit'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <span class="text-xs text-red-600 help-block with-errors dark:text-red-400"></span>
                            </label>
                            <h6
                                class="mb-2 mt-4 text-l font-semibold text-gray-600 dark:text-gray-300">
                                Gejala
                                <span class="text-xs text-red-600 help-block1 with-errors dark:text-red-400"></span>
                            </h6>
                            <div
                                class="mt-4 min-w-0 bg-white rounded-lg shadow-xs border border-gray-300 dark:bg-gray-800">
                                <h4 class="font-semibold text-white bg-purple-600 rounded-t-lg p-4 dark:text-gray-300">
                                    Akar
                                </h4>
                                <div class="p-4 dark:text-gray-400">
                                    <div class="grid grid-cols-3 gap-2"> <!-- Atur grid dan jarak antar checkbox -->
                                        <?php
                                        $tampil = "SELECT * from gejala where daerah='akar' and jenistanaman= 'Bawang'";
                                        $query = mysqli_query($konek_db, $tampil);
                                        while ($hasil = mysqli_fetch_array($query)) {
                                            echo "<label class='flex items-center space-x-2'>
                                            <input type='checkbox' value='" . $hasil['idgejala'] . "' name='gejala[]' class='rounded border-gray-300 text-purple-600 focus:ring-purple-500' />
                                            <h4>" . $hasil['gejala'] . "</h4>
                                        </label>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="mt-4 min-w-0 bg-white rounded-lg shadow-xs border border-gray-300 dark:bg-gray-800">
                                <h4 class="font-semibold text-white bg-purple-600 rounded-t-lg p-4 dark:text-gray-300">
                                    Batang
                                </h4>
                                <div class="p-4 dark:text-gray-400">
                                    <div class="grid grid-cols-3 gap-2"> <!-- Atur grid dan jarak antar checkbox -->
                                        <?php
                                        $tampil = "SELECT * from gejala where daerah='batang' and jenistanaman= 'Bawang'";
                                        $query = mysqli_query($konek_db, $tampil);
                                        while ($hasil = mysqli_fetch_array($query)) {
                                            echo "<label class='flex items-center space-x-2'>
                                            <input type='checkbox' value='" . $hasil['idgejala'] . "' name='gejala[]' class='rounded border-gray-300 text-purple-600 focus:ring-purple-500' />
                                            <h4>" . $hasil['gejala'] . "</h4>
                                        </label>";
                                        }
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
                                        $tampil = "SELECT * from gejala where daerah='daun' and jenistanaman= 'Bawang'";
                                        $query = mysqli_query($konek_db, $tampil);
                                        while ($hasil = mysqli_fetch_array($query)) {
                                            echo "<label class='flex items-center space-x-2'>
                                            <input type='checkbox' value='" . $hasil['idgejala'] . "' name='gejala[]' class='rounded border-gray-300 text-purple-600 focus:ring-purple-500' />
                                            <h4>" . $hasil['gejala'] . "</h4>
                                        </label>";
                                        }
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
                                        $tampil = "SELECT * from gejala where daerah='buah/umbi' and jenistanaman= 'Bawang'";
                                        $query = mysqli_query($konek_db, $tampil);
                                        while ($hasil = mysqli_fetch_array($query)) {
                                            echo "<label class='flex items-center space-x-2'>
                                            <input type='checkbox' value='" . $hasil['idgejala'] . "' name='gejala[]' class='rounded border-gray-300 text-purple-600 focus:ring-purple-500' />
                                            <h4>" . $hasil['gejala'] . "</h4>
                                        </label>";
                                        }
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
                                        $tampil = "SELECT * from gejala where daerah='bunga' and jenistanaman= 'Bawang'";
                                        $query = mysqli_query($konek_db, $tampil);
                                        while ($hasil = mysqli_fetch_array($query)) {
                                            echo "<label class='flex items-center space-x-2'>
                                            <input type='checkbox' value='" . $hasil['idgejala'] . "' name='gejala[]' class='rounded border-gray-300 text-purple-600 focus:ring-purple-500' />
                                            <h4>" . $hasil['gejala'] . "</h4>
                                        </label>";
                                        }
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
                                        $tampil = "SELECT * from gejala where daerah='biji' and jenistanaman= 'Bawang'";
                                        $query = mysqli_query($konek_db, $tampil);
                                        while ($hasil = mysqli_fetch_array($query)) {
                                            echo "<label class='flex items-center space-x-2'>
                                            <input type='checkbox' value='" . $hasil['idgejala'] . "' name='gejala[]' class='rounded border-gray-300 text-purple-600 focus:ring-purple-500' />
                                            <h4>" . $hasil['gejala'] . "</h4>
                                        </label>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" name="tambah_basis" class="px-4 py-2 mt-6 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </main>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('#formBasis').validator().on('invalid.bs.validator', function(e) {
            const input = $(e.relatedTarget);
            const errorMessage = input.attr('data-error');

            // Tambahkan styling error
            input.addClass('border-red-600 focus:border-red-400 focus:shadow-outline-red');

            // Cari elemen <span> yang sesuai dengan input berdasarkan name atau id
            const errorElement = input.siblings('span');
            errorElement.text(errorMessage).removeClass('hidden');
        }).on('valid.bs.validator', function(e) {
            const input = $(e.relatedTarget);

            // Hapus styling error
            input.removeClass('border-red-600 focus:border-red-400 focus:shadow-outline-red');

            // Sembunyikan pesan error jika valid
            const errorElement = input.siblings('span');
            errorElement.addClass('hidden');
        });
        $('#formBasis').on('submit', function (e) {
            let checked = $('input[name="gejala[]"]:checked').length;

            if (checked === 0) {
                e.preventDefault();
                $('.help-block1').text('Silakan pilih minimal satu gejala.');
            } else {
                $('.help-block1').text(''); // Kosongkan pesan jika validasi lulus
            }
        });
    });
</script>

</html>