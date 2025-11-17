<?php
session_start();
if (!isset($_SESSION['kontak'])) {
    $_SESSION['kontak'] = [];
}
$total_kontak = count($_SESSION['kontak']);

$is_edit = false;
$id_edit = null;
$data_edit = [
    'nama' => '',
    'email' => '',
    'telepon' => ''
];

if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
    $id_edit = $_GET['id'];
    if (isset($_SESSION['kontak'][$id_edit])) {
        $is_edit = true;
        $data_edit = $_SESSION['kontak'][$id_edit];
    } else {
        $_SESSION['message'] = "Kontak tidak ditemukan!";
        $_SESSION['msg_type'] = "bg-red-500";
        header('Location: index.php');
        exit;
    }
}

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
?><!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kontak (Material UI)</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .m-card {
            border-radius: 14px;
            box-shadow:
              0 1px 1px rgba(0,0,0,0.04),
              0 8px 24px rgba(0,0,0,0.08);
            transition: transform .18s ease, box-shadow .18s ease;
        }
        .m-card:hover {
            transform: translateY(-2px);
            box-shadow:
              0 1px 1px rgba(0,0,0,0.04),
              0 16px 32px rgba(0,0,0,0.12);
        }
        .bg-grid {
            background-image:
              radial-gradient(circle at 1px 1px, rgba(100,100,255,0.12) 1px, transparent 0),
              radial-gradient(circle at 1px 1px, rgba(100,100,255,0.08) 1px, transparent 0);
            background-size: 24px 24px, 48px 48px;
        }
    </style>
</head>
<body class="text-slate-800 bg-gradient-to-br from-slate-50 to-indigo-50 dark:from-slate-900 dark:to-slate-950 bg-grid min-h-screen">

    <header class="sticky top-0 z-10 backdrop-blur supports-[backdrop-filter]:bg-white/60 dark:supports-[backdrop-filter]:bg-slate-900/50 border-b border-slate-200/60 dark:border-slate-700/50">
      <div class="mx-auto max-w-6xl px-5 md:px-10 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div>
              <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white">Sistem Manajemen</h1>
              <p class="text-sm text-slate-500 dark:text-slate-400"> Kontak Sederhana</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
          <span class="hidden sm:inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300">
            Total: <?php echo $total_kontak; ?>
          </span>
        </div>
      </div>
    </header>

    <main class="container mx-auto max-w-6xl p-5 md:p-10">

        <?php if (isset($_SESSION['message'])): ?>
            <div id="toast" class="mb-8 p-4 rounded-xl text-white font-medium flex items-start gap-3 shadow-lg <?php echo $_SESSION['msg_type']; ?> bg-opacity-90">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12 2a10 10 0 1010 10A10.011 10.011 0 0012 2zm1 15h-2v-2h2zm0-4h-2V7h2z"/>
                </svg>
                <div class="flex-1">
                    <?php
                        echo $_SESSION['message'];
                        unset($_SESSION['message']);
                        unset($_SESSION['msg_type']);
                    ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-8 lg:gap-10">
            <div class="md:col-span-2">
                <div id="formKontak" class="m-card p-6 md:p-8 bg-white/90 dark:bg-slate-800/80 border border-slate-200/60 dark:border-slate-700/50 sticky top-28"> 
                    <h2 class="text-xl md:text-2xl font-bold text-indigo-700 dark:text-indigo-300 mb-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 opacity-80" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4a2 2 0 00-2 2v11a3 3 0 003 3h14a3 3 0 003-3V6a2 2 0 00-2-2zm-7 12H7v-2h6zm4-4H7V10h10zm0-4H7V6h10z"/></svg>
                        <?php echo $is_edit ? 'Edit Kontak' : 'Tambah Kontak Baru'; ?>
                    </h2>
                    
                    <form action="<?php echo $is_edit ? 'update.php' : 'tambah.php'; ?>" method="POST" class="space-y-5">
                        
                        <?php if ($is_edit): ?>
                            <input type="hidden" name="id" value="<?php echo $id_edit; ?>">
                        <?php endif; ?>

                        <div>
                            <label for="nama" class="block text-sm font-semibold text-slate-600 dark:text-slate-300 mb-2">Nama Lengkap</label>
                            <div class="relative">
                              <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 10-5-5 5 5 0 005 5zm0 2c-5.33 0-8 2.67-8 4v2h16v-2c0-1.33-2.67-4-8-4z"/></svg>
                              </span>
                              <input type="text" id="nama" name="nama" class="w-full pl-10 pr-3 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white/80 dark:bg-slate-900/40 text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" value="<?php echo htmlspecialchars($data_edit['nama']); ?>" required>
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-slate-600 dark:text-slate-300 mb-2">Email</label>
                            <div class="relative">
                              <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 4l-8 5-8-5V6l8 5 8-5z"/></svg>
                              </span>
                              <input type="email" id="email" name="email" class="w-full pl-10 pr-3 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white/80 dark:bg-slate-900/40 text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" value="<?php echo htmlspecialchars($data_edit['email']); ?>" required>
                            </div>
                        </div>

                        <div>
                            <label for="telepon" class="block text-sm font-semibold text-slate-600 dark:text-slate-300 mb-2">Nomor Telepon</label>
                            <div class="relative">
                              <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79a15.09 15.09 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24 11.36 11.36 0 003.56.57 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1 11.36 11.36 0 00.57 3.56 1 1 0 01-.24 1.01z"/></svg>
                              </span>
                              <input type="tel" id="telepon" name="telepon" class="w-full pl-10 pr-3 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white/80 dark:bg-slate-900/40 text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" value="<?php echo htmlspecialchars($data_edit['telepon']); ?>" required>
                            </div>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <?php
                                $btn_class = $is_edit
                                    ? 'bg-amber-500 hover:bg-amber-600'
                                    : 'bg-indigo-600 hover:bg-indigo-700';
                            ?>
                            <button type="submit" class="w-full font-semibold py-3 px-4 rounded-lg text-white <?php echo $btn_class; ?> shadow-sm">
                                <?php echo $is_edit ? 'Update Kontak' : 'Simpan Kontak'; ?>
                            </button>

                            <?php if ($is_edit): ?>
                                <a href="index.php" class="w-1/2 text-center bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-100 font-semibold py-3 px-4 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600">Batal</a>
                            <?php else: ?>
                                <button type="reset" class="w-1/2 text-center bg-slate-100 dark:bg-slate-700 text-slate-800 dark:text-slate-100 font-semibold py-3 px-4 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600">Reset</button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <div class="md:col-span-3">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
                  <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Daftar Kontak</h2>
                  <form method="GET" class="relative w-full md:w-80">
                      <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M21 20l-5.2-5.2a7 7 0 10-1.4 1.4L20 21zM5 10a5 5 0 115 5 5 5 0 01-5-5z"/></svg>
                      </span>
                      <input name="q" value="<?php echo htmlspecialchars($q); ?>" type="text" placeholder="Cari nama, email, telepon..." class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white/80 dark:bg-slate-900/40 text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                  </form>
                </div>

                <?php
                    $kontak_terurut = array_reverse($_SESSION['kontak'], true);
                    if ($q !== '') {
                        $q_lc = mb_strtolower($q);
                        $kontak_terurut = array_filter($kontak_terurut, function($k) use ($q_lc) {
                          $nama = mb_strtolower($k['nama'] ?? '');
                          $email = mb_strtolower($k['email'] ?? '');
                          $tel = mb_strtolower($k['telepon'] ?? '');
                          return (strpos($nama, $q_lc) !== false) || (strpos($email, $q_lc) !== false) || (strpos($tel, $q_lc) !== false);
                        });
                    }
                ?>

                <?php if (empty($kontak_terurut)): ?>
                    <div class="m-card p-10 text-center bg-white/90 dark:bg-slate-800/80 border border-dashed border-indigo-300/60 dark:border-indigo-400/30">
                        <div class="mx-auto mb-4 h-20 w-20 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-300">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 10-5-5 5 5 0 005 5zm0 2c-5.33 0-8 2.67-8 4v2h16v-2c0-1.33-2.67-4-8-4z"/></svg>
                        </div>
                        <p class="text-slate-600 dark:text-slate-300 font-medium">
                            <?php echo $q !== '' ? 'Kontak tidak ditemukan.' : 'Belum ada kontak tersimpan.'; ?>
                        </p>
                        <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">
                            <?php echo $q !== '' ? 'Coba kata kunci lain.' : 'Tambah kontak pertama kamu di panel kiri.'; ?>
                        </p>
                    </div>
                <?php else: ?>
                    <div id="listKontak" class="space-y-6">
                        <?php foreach ($kontak_terurut as $id => $kontak): ?>
                        <?php
                            $nama = isset($kontak['nama']) ? $kontak['nama'] : '';
                            $parts = preg_split('/\s+/', trim($nama));
                            $initials = strtoupper(substr($parts[0] ?? '', 0, 1) . substr($parts[count($parts) > 1 ? 1 : 0] ?? '', 0, 1));
                            $palette = ['indigo','sky','emerald','rose','amber','violet'];
                            $hashBase = is_numeric($id) ? intval($id) : abs(crc32((string)$id));
                            $color = $palette[$hashBase % count($palette)];
                            $avatarBg = "bg-{$color}-100 dark:bg-{$color}-900/40";
                            $avatarFg = "text-{$color}-700 dark:text-{$color}-300";
                        ?>

                        <div class="m-card bg-white/90 dark:bg-slate-800/80 border border-slate-200/60 dark:border-slate-700/50 overflow-hidden">
                            <div class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200/60 dark:border-slate-700/50">
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-12 rounded-full flex items-center justify-center font-bold <?php echo $avatarBg . ' ' . $avatarFg; ?>">
                                      <?php echo htmlspecialchars($initials ?: 'KO'); ?>
                                    </div>
                                    <div>
                                      <h3 class="text-lg md:text-xl font-bold text-slate-900 dark:text-white"><?php echo htmlspecialchars($kontak['nama']); ?></h3>
                                      <p class="text-xs text-slate-500 dark:text-slate-400">ID: <?php echo htmlspecialchars((string)$id); ?></p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="index.php?action=edit&id=<?php echo $id; ?>" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-amber-700 bg-amber-100 hover:bg-amber-200 dark:text-amber-200 dark:bg-amber-900/30 dark:hover:bg-amber-900/50">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1 1 0 000-1.41l-2.34-2.34a1 1 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                      Edit
                                    </a>
                                    <a onclick="return confirm('Hapus kontak ini?')" href="hapus.php?id=<?php echo $id; ?>" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-rose-700 bg-rose-100 hover:bg-rose-200 dark:text-rose-200 dark:bg-rose-900/30 dark:hover:bg-rose-900/50">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M6 7h12v14H6z" opacity=".4"/><path d="M19 4h-3.5l-1-1h-5l-1 1H5v2h14z"/></svg>
                                      Hapus
                                    </a>
                                </div>
                            </div>

                            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="flex items-start gap-3">
                                    <div class="h-9 w-9 rounded-lg bg-slate-100 dark:bg-slate-700/70 flex items-center justify-center text-slate-500 dark:text-slate-300">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4a2 2 0 00-2 2v12a2 2 0 002 2h16a2 2 0 002-2V6a2 2 0 00-2-2zm0 4l-8 5-8-5V6l8 5 8-5z"/></svg>
                                    </div>
                                    <div class="min-w-0">
                                      <span class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">Email</span>
                                      <p class="text-slate-700 dark:text-slate-200 mt-1 truncate">
                                        <a class="hover:underline text-indigo-600 dark:text-indigo-300 break-all" href="mailto:<?php echo htmlspecialchars($kontak['email']); ?>">
                                          <?php echo htmlspecialchars($kontak['email']); ?>
                                        </a>
                                      </p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="h-9 w-9 rounded-lg bg-slate-100 dark:bg-slate-700/70 flex items-center justify-center text-slate-500 dark:text-slate-300">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79a15.09 15.09 0 006.59 6.59l2.2-2.2a1 1 0 011.01-.24 11.36 11.36 0 003.56.57 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 4a1 1 0 011-1h3.5a1 1 0 011 1 11.36 11.36 0 00.57 3.56 1 1 0 01-.24 1.01z"/></svg>
                                    </div>
                                    <div class="min-w-0">
                                      <span class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">Telepon</span>
                                      <p class="text-slate-700 dark:text-slate-200 mt-1 truncate">
                                        <a class="hover:underline text-indigo-600 dark:text-indigo-300" href="tel:<?php echo htmlspecialchars($kontak['telepon']); ?>">
                                          <?php echo htmlspecialchars($kontak['telepon']); ?>
                                        </a>
                                      </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>