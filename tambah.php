
<?php
require_once "koneksi.php";
require_once "validasi_siswa.php";

$nama = "";
$kelas = "";
$alamat = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = isset($_POST["nama"]) && is_string($_POST["nama"]) ? trim($_POST["nama"]) : "";
    $kelas = isset($_POST["kelas"]) && is_string($_POST["kelas"]) ? trim($_POST["kelas"]) : "";
    $alamat = isset($_POST["alamat"]) && is_string($_POST["alamat"]) ? trim($_POST["alamat"]) : "";
    $errors = validasiDataSiswa($nama, $kelas, $alamat);

    if ($errors === []) {
        $stmt = mysqli_prepare(
            $conn,
            "INSERT INTO siswa (nama, kelas, alamat) VALUES (?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $stmt, "sss", $nama, $kelas, $alamat
        );

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: index.php?pesan=tambah");
            exit;
        }

        $errors[] = "Gagal menambahkan data siswa.";
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Tambah Siswa</h1>

    <?php if ($errors !== []): ?>
        <div class="pesan-error" role="alert">
            <strong>Data belum dapat disimpan:</strong>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="tambah.php">
        <p>
            <label for="nama">Nama Siswa</label><br>
            <input type="text" id="nama" name="nama" minlength="2" maxlength="100"
                   value="<?= htmlspecialchars($nama, ENT_QUOTES, "UTF-8") ?>"
                   required>
        </p>
        <p>
            <label for="kelas">Kelas</label><br>
            <input type="text" id="kelas" name="kelas" maxlength="30"
                   value="<?= htmlspecialchars($kelas, ENT_QUOTES, "UTF-8") ?>"
                   required>
        </p>
        <p>
            <label for="alamat">Alamat</label><br>
            <input type="text" id="alamat" name="alamat" minlength="5" maxlength="255"
                   value="<?= htmlspecialchars($alamat, ENT_QUOTES, "UTF-8") ?>"
                   required>
        </p>
        <button type="submit">Simpan</button>
        <a href="index.php">Kembali</a>
    </form>
</body>
</html>
<?php mysqli_close($conn); ?>
