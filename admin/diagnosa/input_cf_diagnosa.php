<?php
include('../../koneksi.php');
session_start();
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
            <?php include('../component/header.php') 
            ?>
            <main class="h-full overflow-y-auto">
                <div class="container px-6 mx-auto grid">
                    <h2
                        class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                        Diagnosa Penyakit
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
                            <p>Seberapa yakin anda dengan gejala tersebut pada tanaman anda?</p>
                        </div>
                    </div>
                    <form id="formDiagnosa" data-toggle="validator" action="aksi_diagnosa.php" method="POST" role="form">
                        <div class="grid gap-6 mb-8 md:grid-cols-2">
                            <?php
                            $no = 0;
                            $tampil = "SELECT g.idgejala, g.gejala from temp_cek tc
                            INNER JOIN  gejala g on tc.idgejala = g.idgejala
                            where iduser='" . $_SESSION['iduser'] . "'";
                            $query = mysqli_query($konek_db, $tampil);
                            while ($hasil = mysqli_fetch_array($query)) {
                                $no++;
                            ?>
                                <div class="mt-4 min-w-0 bg-white rounded-lg shadow-xs border border-gray-300 dark:bg-gray-800">
                                    <p class="font-semibold text-xs text-white bg-purple-600 rounded-t-lg p-4 dark:text-gray-300">
                                        <?php echo $no ?>. <?php echo $hasil['gejala'] ?>
                                    </p>
                                    <input type="hidden" value="<?php echo $hasil['idgejala'] ?>" name="idgejala[]">
                                    <div class="p-4 dark:text-gray-400">
                                        <div class="grid grid-cols-1 gap-4">
                                            <label class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                                                <input type="radio" class="form-radio w-5 h-5 border-gray-300 text-purple-600 focus:ring-purple-500" name="cf[<?php echo $hasil['idgejala'] ?>]" value="1.0">
                                                <p>Sangat Yakin</p>
                                            </label>
                                            <label class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                                                <input type="radio" class="form-radio w-5 h-5 border-gray-300 text-purple-600 focus:ring-purple-500" name="cf[<?php echo $hasil['idgejala'] ?>]" value="0.8">
                                                <p>Yakin</p>
                                            </label>
                                            <label class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
                                                <input type="radio" class="form-radio w-5 h-5 border-gray-300 text-purple-600 focus:ring-purple-500" name="cf[<?php echo $hasil['idgejala'] ?>]" value="0.5">
                                                <p>Ragu-ragu</p>
                                            </label>
                                        </div>
                                        <span class="text-xs text-red-600 help-block with-errors dark:text-red-400"></span>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="flex justify-end">
                            <button onclick="return confirm('Apakah Gejala Sudah Benar?');" type="submit" name="cek_penyakit" class="px-4 py-2 mt-6 mb-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Cek Penyakit
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('#formDiagnosa').validator().on('invalid.bs.validator', function(e) {
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
    });
</script>

</html>