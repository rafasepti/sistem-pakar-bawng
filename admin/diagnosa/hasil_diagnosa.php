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
    <script src="https://cdn.tailwindcss.com"></script>
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
                        Hasil Diagnosa
                    </h2>
                    <div>
                        <div class="relative m-8">
                            <span class="absolute -z-10  w-full h-full inset-1 bg-violet-500 rounded-xl"></span>
                            <button class="absolute py-1 z-10 px-3 -left-8 -top-2 -rotate-[10deg] black_border bg-violet-500 text-white font-bold disabled">
                                Gejala yang dipilih
                            </button>

                            <div class="p-8 border border-black purple_border bg-white rounded-xl z-20">
                                <?php
                                if (isset($_SESSION['temp_cek'])) {
                                    $no = 0;
                                    $temp_cek_data = $_SESSION['temp_cek'];

                                    // Tampilkan data
                                    foreach ($temp_cek_data as $row) {
                                        $no++;
                                        echo $no . ". " . $row['gejala'] . "<br>";
                                    }
                                } else {
                                    echo "Tidak ada data di session.";
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="relative m-8">
                            <span class="absolute -z-10  w-full h-full inset-1 bg-violet-500 rounded-xl"></span>
                            <button class="absolute py-1 z-10 px-3 -left-8 -top-2 -rotate-[10deg] black_border bg-violet-500 text-white font-bold disabled">
                                Nama Penyakit
                            </button>

                            <div class="p-8 border border-black purple_border bg-white rounded-xl z-20">
                                <span class="font-mono text-purple-700 font-bold"><?php echo $_SESSION['namapenyakit'] ?>.</span>
                                <?php echo $_SESSION['fisikmekanis'] ?>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="relative m-8">
                            <span class="absolute -z-10  w-full h-full inset-1 bg-violet-500 rounded-xl"></span>
                            <button class="absolute py-1 z-10 px-3 -left-8 -top-2 -rotate-[10deg] black_border bg-violet-500 text-white font-bold disabled">
                                Nilai CF
                            </button>

                            <div class="p-8 border border-black purple_border bg-white rounded-xl z-20">
                                <span class="font-mono text-purple-700 font-bold"><?php echo $_SESSION['cf_tertinggi'] ?>%</span><br>
                                Solusi: <?php echo $_SESSION['kulturteknis'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <a href="diagnosa.php" class="px-4 py-2 mt-6 mb-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                            Cek Ulang Penyakit
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>