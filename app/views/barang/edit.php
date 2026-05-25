<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 15px; }
        h2 { color: #2c3e50; margin-bottom: 25px; border-bottom: 3px solid #667eea; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 8px; }
        .btn-add { background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; }
        .btn-back { background: #6c757d; color: white; padding: 8px 16px; text-decoration: none; border-radius: 8px; display: inline-block; margin-bottom: 20px; }
        .alert-error { background: #f8d7da; color: #721c24; padding: 12px; border-radius: 8px; margin-bottom: 20px; }
        .gambar-lama { max-width: 100px; margin-bottom: 10px; }
    </style>
</head>
<body>
<div class="container">
    <a href="index.php?url=barang/index" class="btn-back">← Kembali</a>
    <h2>Edit Barang</h2>
    <?php if(!empty($errors)): ?>
        <div class="alert-error">
            <?php foreach($errors as $err): ?>
                <p><?= htmlspecialchars($err) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data" action="index.php?url=barang/edit&id=<?= $id ?>">
        <div class="form-group"><label>Nama Barang *</label><input type="text" name="nama_barang" required value="<?= htmlspecialchars($old_input['nama_barang'] ?? $barang['nama_barang']) ?>"></div>
        <div class="form-group"><label>Kategori</label><input type="text" name="kategori" value="<?= htmlspecialchars($old_input['kategori'] ?? $barang['kategori']) ?>"></div>
        <div class="form-group"><label>Jumlah *</label><input type="number" name="jumlah" required min="0" value="<?= htmlspecialchars($old_input['jumlah'] ?? $barang['jumlah']) ?>"></div>
        <div class="form-group"><label>Harga *</label><input type="number" name="harga" required min="0" value="<?= htmlspecialchars($old_input['harga'] ?? $barang['harga']) ?>"></div>
        <div class="form-group"><label>Supplier</label><input type="text" name="supplier" value="<?= htmlspecialchars($old_input['supplier'] ?? $barang['supplier']) ?>"></div>
        <div class="form-group"><label>Tanggal Masuk</label><input type="date" name="tanggal_masuk" value="<?= htmlspecialchars($old_input['tanggal_masuk'] ?? $barang['tanggal_masuk']) ?>"></div>
        <div class="form-group"><label>Stok Minimum</label><input type="number" name="stok_minimum" min="0" value="<?= htmlspecialchars($old_input['stok_minimum'] ?? $barang['stok_minimum']) ?>"></div>
        <div class="form-group"><label>Keterangan</label><textarea name="keterangan"><?= htmlspecialchars($old_input['keterangan'] ?? $barang['keterangan']) ?></textarea></div>
        <div class="form-group">
            <label>Gambar Saat Ini</label><br>
            <?php if(!empty($barang['gambar']) && file_exists('uploads/'.$barang['gambar'])): ?>
                <img src="uploads/<?= $barang['gambar'] ?>" class="gambar-lama"><br>
            <?php else: ?>Tidak ada gambar<br><?php endif; ?>
            <label>Ganti Gambar</label>
            <input type="file" name="gambar" accept="image/jpeg,image/png">
            <small>Kosongkan jika tidak ingin mengubah</small>
        </div>
        <button type="submit" class="btn-add">Update</button>
    </form>
</div>
</body>
</html>