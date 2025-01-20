<?php
include('../../koneksi.php');

if (isset($_POST['search'])) {
    $keyword = mysqli_real_escape_string($konek_db, $_POST['search']);
} else {
    $keyword = '';
}

$daerah_list = ['akar', 'batang', 'daun', 'buah/umbi', 'bunga', 'biji'];
$jenistanaman = 'Bawang'; // Ganti sesuai kebutuhan

foreach ($daerah_list as $daerah) {
    echo "<div class='mt-4 min-w-0 bg-white rounded-lg shadow-xs border border-gray-300 dark:bg-gray-800'>
            <h4 class='font-semibold text-white bg-purple-600 rounded-t-lg p-4 dark:text-gray-300'>
                " . ucfirst($daerah) . "
            </h4>
            <div class='p-4 dark:text-gray-400'>
                <div class='grid grid-cols-3 gap-2'>";

    $query = "SELECT * FROM gejala WHERE daerah='$daerah' AND jenistanaman='$jenistanaman'";
    if (!empty($keyword)) {
        $query .= " AND gejala LIKE '%$keyword%'";
    }

    $result = mysqli_query($konek_db, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $idgejala = $row['idgejala'];
            $gejala = $row['gejala'];

            echo "<label class='flex items-center space-x-2'>
                <input type='checkbox' value='$idgejala' id='checkbox-$idgejala' data-id='$idgejala' name='gejala[]' class='gejala-checkbox rounded border-gray-300 text-purple-600 focus:ring-purple-500'/>
                <h4>$gejala</h4>
            </label>";
        }
    } else if (!empty($keyword)) {
        echo "<p class='text-gray-500'>Tidak ada gejala ditemukan.</p>";
    }

    echo "  </div>
          </div>
        </div>";
}
