<?php
session_start();
if (!isset($_SESSION['kontak'])) {
    $_SESSION['kontak'] = [];
}

if (isset($_GET['id'])) {
    
    $id = $_GET['id'];

    if (!isset($_SESSION['kontak'][$id])) {
        $_SESSION['message'] = "Gagal menghapus: Kontak tidak ditemukan!";
        $_SESSION['msg_type'] = "bg-red-500";
    } else {
        unset($_SESSION['kontak'][$id]);
        $_SESSION['message'] = "Kontak berhasil dihapus!";
        $_SESSION['msg_type'] = "bg-yellow-500";
    }

} else {
    $_SESSION['message'] = "Aksi tidak diizinkan!";
    $_SESSION['msg_type'] = "bg-red-500";
}

header('Location: index.php');
exit;
?>