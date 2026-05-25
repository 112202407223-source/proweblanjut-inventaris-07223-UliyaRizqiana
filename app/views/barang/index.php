<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Inventaris Barang</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1300px;
            margin: 0 auto;
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow-x: auto;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 4px solid #667eea;
            font-size: 28px;
        }
        .user-info {
            background: #f8f9fa;
            padding: 12px 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 6px 15px;
            text-decoration: none;
            border-radius: 6px;
        }
        .btn-add {
            background: #28a745;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }
        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th, td {
            padding: 12px 8px;
            border-bottom: 1px solid #ddd;
            vertical-align: middle; /* semua sel rata tengah vertikal */
        }
        th {
            background: #667eea;
            color: white;
            text-align: left;
        }
        /* Kolom Jumlah & Stok Min rata tengah */
        td:nth-child(4), td:nth-child(8),
        th:nth-child(4), th:nth-child(8) {
            text-align: center;
        }
        tr:hover {
            background: #f5f5f5;
        }
        .alert {
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        /* TOMBOL AKSI - tanpa flex agar vertical-align works */
        .action-buttons {
            white-space: nowrap;
        }
        .btn-edit, .btn-delete {
            display: inline-block;
            width: 65px;
            text-align: center;
            padding: 5px 0;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            border: none;
            cursor: pointer;
            vertical-align: middle; /* penting agar sejajar dengan teks lain */
            margin: 0 2px;
        }
        .btn-edit {
            background: #ffc107;
            color: #333;
        }
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        .btn-edit:hover, .btn-delete:hover {
            opacity: 0.85;
        }
        .action-buttons form {
            display: inline;
            margin: 0;
        }
        .gambar-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ccc;
            vertical-align: middle;
        }
        @media (max-width: 768px) {
            th, td { padding: 8px 4px; font-size: 12px; }
            .btn-edit, .btn-delete { width: 55px; font-size: 11px; }
            .gambar-thumb { width: 40px; height: 40px; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="user-info">
        <div>Selamat datang, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></div>
        <a href="index.php?url=auth/logout" class="logout-btn" onclick="return confirm('Yakin logout?')">Logout</a>
    </div>
    <h1>Manajemen Inventaris Barang</h1>
    <a href="index.php?url=barang/tambah" class="btn-add">+ Tambah Barang Baru</a>

    <?php if(isset($_GET['message'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['message']) ?></div>
    <?php endif; ?>
    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-error"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr><th>ID</th><th>Nama Barang</th><th>Kategori</th><th>Jumlah</th><th>Harga</th><th>Supplier</th><th>Tgl Masuk</th><th>Stok Min</th><th>Keterangan</th><th>Gambar</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        <?php foreach($data as $b): ?>
        <tr>
            <td><?= $b['id'] ?></td>
            <td><?= htmlspecialchars($b['nama_barang']) ?></td>
            <td><?= htmlspecialchars($b['kategori']) ?></td>
            <td><?= $b['jumlah'] ?></td>
            <td>Rp <?= number_format($b['harga'],0,',','.') ?></td>
            <td><?= htmlspecialchars($b['supplier']) ?></td>
            <td><?= $b['tanggal_masuk'] ?></td>
            <td><?= $b['stok_minimum'] ?></td>
            <td><?= htmlspecialchars($b['keterangan']) ?></td>
            <td class="gambar">
                <?php if(!empty($b['gambar']) && file_exists('uploads/'.$b['gambar'])): ?>
                    <img src="uploads/<?= $b['gambar'] ?>" class="gambar-thumb">
                <?php else: ?>-<?php endif; ?>
            </td>
            <td class="action-buttons">
                <a href="index.php?url=barang/edit&id=<?= $b['id'] ?>" class="btn-edit">Edit</a>
                <form method="POST" action="index.php?url=barang/hapus" onsubmit="return confirm('Yakin hapus?');">
                    <input type="hidden" name="id" value="<?= $b['id'] ?>">
                    <button type="submit" class="btn-delete">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>