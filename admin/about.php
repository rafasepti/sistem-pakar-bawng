<?php
include('../koneksi.php');
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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/css/tailwind.output.css" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <!-- jQuery (dibutuhkan oleh DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js"
        defer></script>
    <script src="../assets/js/init-alpine.js"></script>
    <script src="../assets/js/validator.js"></script>
    <script src="../assets/js/charts-lines.js" defer></script>
    <script src="../assets/js/charts-pie.js" defer></script>
</head>
<script>
    tailwind.config = {
        darkMode: 'class', // Gunakan mode 'class' tanpa pernah menambahkan kelas 'dark'
        theme: {
            extend: {},
        },
    };
</script>
<style>
    .purple_border {
        box-shadow: 4px 4px 1px rgb(126, 34, 206);
    }

    .black_border {
        box-shadow: 4px 4px 1px rgb(0, 0, 0);
    }
</style>

<body>
    <div
        class="flex h-screen bg-gray-50 dark:bg-gray-900"
        :class="{ 'overflow-hidden': isSideMenuOpen }">
        <!-- Desktop sidebar -->
        <?php include('component/sidebar_desktop.php') ?>
        <!-- Mobile sidebar -->
        <!-- Backdrop -->
        <?php include('component/sidebar_mobile.php') ?>
        <div class="flex flex-col flex-1 w-full">
            <?php include('component/header.php')
            ?>
            <main class="h-full overflow-y-auto">
                <div class="container px-6 mx-auto grid">
                    <h2
                        class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                        About
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
                            <span>Data Pengembang</span>
                        </div>
                    </div>
                    <div class="justify-center items-center">
                        <div class="flex gap-8">
                            <!-- Card 1 -->
                            <div
                                class="w-full bg-gray-100 dark:bg-gray-700 relative shadow-xl overflow-hidden hover:shadow-2xl group rounded-xl p-5 transition-all duration-500 transform">
                                <div class="flex items-center gap-4">
                                    <img src="../img/buyumarlin1.jpg"
                                        class="w-32 group-hover:w-36 group-hover:h-36 h-32 object-center object-cover rounded-full transition-all duration-500 delay-500 transform" />
                                    <div class="w-fit transition-all transform duration-500">
                                        <h1 class="text-gray-600 dark:text-gray-200 font-bold">
                                            YUMARLIN MZ.,S.Kom.,M.Pd.,M.Kom
                                        </h1>
                                        <p class="text-gray-400">Dosen Pembimbing</p>
                                        <p class="text-gray-400">Fakultas Teknik Informatika Universitas Janabadra</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Card 2 -->
                            <div
                                class="w-full bg-gray-100 dark:bg-gray-700 relative shadow-xl overflow-hidden hover:shadow-2xl group rounded-xl p-5 transition-all duration-500 transform">
                                <div class="flex items-center gap-4">
                                    <img src="../img/rp.jpg"
                                        class="w-32 group-hover:w-36 group-hover:h-36 h-32 object-center object-cover rounded-full transition-all duration-500 delay-500 transform" />
                                    <div class="w-fit transition-all transform duration-500">
                                        <h1 class="text-gray-600 dark:text-gray-200 font-bold">
                                            RENI PUTRI
                                        </h1>
                                        <p class="text-gray-400">Mahasiswa Teknik Informatika</p>
                                        <p class="text-gray-400">Universitas Janabadra</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>