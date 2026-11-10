
<?php
require_once "koneksi.php";

$sql = "SELECT * FROM siswa ORDER BY id ASC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Gagal mengambil data siswa.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>DATA SISWA</h1>

<?php if (isset($_GET["pesan"])): ?>
    <?php
    $pesan = [
        "tambah" => "Data siswa berhasil ditambahkan.",
        "edit" => "Data siswa berhasil diperbarui.",
        "hapus" => "Data siswa berhasil dihapus."
    ];
    $kode = $_GET["pesan"];
    ?>
    <?php if (isset($pesan[$kode])): ?>
        <p class="pesan">
            <?= htmlspecialchars($pesan[$kode]) ?>
        </p>
    <?php endif; ?>
<?php endif; ?>

<a class="tombol tambah" href="tambah.php">
    + Tambah Siswa
</a>

<table>
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php $no = 1; ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row["nama"]) ?></td>
                <td><?= htmlspecialchars($row["kelas"]) ?></td>
                <td><?= htmlspecialchars($row["alamat"]) ?></td>
                <td class="aksi">
                    <a class="tombol edit"
                       href="edit.php?id=<?= (int)$row["id"] ?>">
                        Edit
                    </a>

                    <form action="hapus.php" method="POST"
                          style="display:inline"
                          onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
                        <input type="hidden" name="id"
                               value="<?= (int)$row["id"] ?>">
                        <button class="tombol hapus" type="submit">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="5" class="kosong">
                Belum ada data siswa.
            </td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

</body>
</html>
<?php mysqli_close($conn); ?>
