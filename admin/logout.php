<?php
session_start();
session_destroy(); // Hapus semua data session
header('location:../index.php'); // Arahkan ke halaman login
exit();
