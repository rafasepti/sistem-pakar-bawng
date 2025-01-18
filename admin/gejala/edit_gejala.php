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
                        Edit Data
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
                            <span>Gejala</span>
                        </div>
                    </div>
                    <?php
                    $id = $_GET['id'];
                    $sql = "SELECT * FROM gejala WHERE idgejala = '$id'";
                    $result = $konek_db->query($sql);
                    while ($data = mysqli_fetch_array($result)) {
                    ?>
                    <div
                        class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <form id="formGejala" data-toggle="validator" action="aksi_gejala.php" method="POST" role="form">
                            <label class="block text-sm">
                                <h5 class="text-gray-700 dark:text-gray-400">ID</h5>
                                <input
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    name="idgejala" id="idgejala"
                                    placeholder="Jane Doe" readonly value="<?php echo $data[0] ?>" />
                            </label>
                            <label class="block mt-4 text-sm">
                                <h5 class="text-gray-700 dark:text-gray-400">Nama Gejala</h5>
                                <input
                                    type="text"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                    placeholder="Isi nama gejala"
                                    name="gejala"
                                    id="gejala"
                                    required
                                    data-error="Nama gejala wajib diisi." value="<?php echo $data[1] ?>"/>
                                    <span class="text-xs text-red-600 help-block with-errors dark:text-red-400"></span>
                            </label>
                            <label class="block mt-4 text-sm">
                                <h5 class="text-gray-700 dark:text-gray-400">
                                    Daerah
                                </h5>
                                <select class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                                    name="daerah"
                                    id="daerah"
                                    required
                                    data-error="Daerah wajib diisi.">
                                    <option value="">Pilih Daerah</option>
                                    <option <?php echo ($data[2] == 'Akar') ? 'selected' : ''; ?>>Akar</option>
                                    <option <?php echo ($data[2] == 'Batang') ? 'selected' : ''; ?>>Batang</option>
                                    <option <?php echo ($data[2] == 'Daun') ? 'selected' : ''; ?>>Daun</option>
                                    <option <?php echo ($data[2] == 'Bunga') ? 'selected' : ''; ?>>Bunga</option>
                                    <option <?php echo ($data[2] == 'Buah') ? 'selected' : ''; ?>>Buah</option>
                                </select>
                                <span class="text-xs text-red-600 help-block with-errors dark:text-red-400"></span>
                            </label>
                            <div class="flex justify-end">
                                <button type="submit" name="edit_gejala" class="px-4 py-2 mt-6 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                    Simpan
                                </button>
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
<script>
    $(document).ready(function () {
        $('#formGejala').validator().on('invalid.bs.validator', function (e) {
            const input = $(e.relatedTarget);
            const errorMessage = input.attr('data-error');
            
            // Tambahkan styling error pada input atau textarea
            input.addClass('border-red-600 focus:border-red-400 focus:shadow-outline-red');
            
            // Cari elemen <span> yang sesuai dengan input berdasarkan name atau id
            const errorElement = input.siblings('span');
            errorElement.text(errorMessage).removeClass('hidden');
        }).on('valid.bs.validator', function (e) {
            const input = $(e.relatedTarget);
            
            // Hapus styling error dari input atau textarea
            input.removeClass('border-red-600 focus:border-red-400 focus:shadow-outline-red');
            
            // Sembunyikan pesan error jika valid
            const errorElement = input.siblings('span');
            errorElement.addClass('hidden');
        });
    });
</script>

</html>