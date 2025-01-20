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
                            <span>Pilih Gejala Tanaman Bawang</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-x-4">
                        <!-- Search Input -->

                        <div class="relative flex-grow focus-within:text-purple-500">
                            <form id="formBasis" action="" method="POST" role="form">
                                <div class="absolute inset-y-0 flex items-center pl-2">
                                    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input
                                    class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-100 border-0 rounded-md dark:placeholder-gray-500 dark:focus:shadow-outline-gray dark:focus:placeholder-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:placeholder-gray-500 focus:bg-white focus:border-purple-300 focus:outline-none focus:shadow-outline-purple form-input"
                                    type="text"
                                    name="search"
                                    id="search"
                                    placeholder="Cari Gejala"
                                    aria-label="Search" />
                            </form>
                        </div>

                    </div>
                    <form id="formDiagnosa" data-toggle="validator" action="aksi_diagnosa.php" method="POST" role="form">
                        <div id="gejalaContainer" class="mt-4">
                            <!-- Grup gejala akan dimuat dinamis -->
                        </div>
                        <span class="text-xs text-red-600 help-block with-errors dark:text-red-400"></span>
                        <div class="flex justify-end">
                            <button onclick="return confirm('Apakah Gejala Sudah Benar?');" type="submit" name="selanjutnya" class="px-4 py-2 mt-6 mb-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                Selanjutnya
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
        $('#formDiagnosa').on('submit', function(e) {
            let checked = $('input[name="gejala[]"]:checked').length;

            if (checked === 0) {
                e.preventDefault();
                $('.help-block').text('Silakan pilih minimal satu gejala.');
            } else {
                $('.help-block').text(''); // Kosongkan pesan jika validasi lulus
            }
        });

        let checkedStates = {}; // Objek untuk menyimpan status checkbox

        // Fungsi untuk mengambil data gejala melalui AJAX
        function fetchGejala(keyword = '') {
            $.ajax({
                url: 'fetch_gejala.php', // Endpoint untuk mengambil data gejala
                type: 'POST',
                data: {
                    search: keyword
                },
                success: function(response) {
                    $('#gejalaContainer').html(response);

                    // Kembalikan status centang setelah data diperbarui
                    $('.gejala-checkbox').each(function() {
                        const id = $(this).val();
                        if (checkedStates[id]) {
                            $(this).prop('checked', true);
                        }
                    });

                    // Tambahkan event listener pada checkbox baru
                    bindCheckboxEvents();
                },
                error: function() {
                    console.error('Terjadi kesalahan saat mengambil data.');
                }
            });
        }

        // Fungsi untuk menyimpan status checkbox saat berubah
        function bindCheckboxEvents() {
            $('.gejala-checkbox').on('change', function() {
                const id = $(this).val();
                checkedStates[id] = $(this).is(':checked');
            });
        }

        // Panggil fetchGejala() saat halaman pertama kali dimuat
        fetchGejala();

        // Tangkap input pencarian
        $('#search').on('input', function() {
            const keyword = $(this).val();
            fetchGejala(keyword);
        });

    });
</script>

</html>