<?php
session_start();
if (!isset($_SESSION['kontak'])) {
    $_SESSION['kontak'] = [];
}

function validasi($data) {
    if (empty($data['nama']) || empty($data['email']) || empty($data['telepon'])) {
        return "Semua kolom wajib diisi!";
    }
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        return "Format email tidak valid!";
    }
    if (strlen($data['telepon']) < 5) {
        return "Nomor telepon sepertinya terlalu pendek.";
    }
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $data_baru = [
        'nama' => $_POST['nama'],
        'email' => $_POST['email'],
        'telepon' => $_POST['telepon']
    ];

    $hasil_validasi = validasi($data_baru);

    if ($hasil_validasi === true) {
        $_SESSION['kontak'][] = $data_baru;
        $_SESSION['message'] = "Kontak berhasil ditambahkan!";
        $_SESSION['msg_type'] = "bg-green-500";
    } else {
        $_SESSION['message'] = $hasil_validasi;
        $_SESSION['msg_type'] = "bg-red-500";
    }

} else {
    $_SESSION['message'] = "Aksi tidak diizinkan!";
    $_SESSION['msg_type'] = "bg-red-500";
}

header('Location: index.php');
exit;
?>