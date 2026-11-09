
<?php
require_once "koneksi.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = trim($_POST["nama"] ?? "");
    $kelas = trim($_POST["kelas"] ?? "");
    $alamat = trim($_POST["alamat"] ?? "");

    if ($nama === "" || $kelas === "" || $alamat === "") {
        $error = "Semua kolom wajib diisi.";
    } else {
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

        $error = "Gagal menambahkan data siswa.";
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

    <?php if ($error !== ""): ?>
        <p style="color:red">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="tambah.php">
        <p>
            <label>Nama Siswa</label><br>
            <input type="text" name="nama" maxlength="100"
                   value="<?= htmlspecialchars($_POST["nama"] ?? "") ?>"
                   required>
        </p>
        <p>
            <label>Kelas</label><br>
            <input type="text" name="kelas" maxlength="30"
                   value="<?= htmlspecialchars($_POST["kelas"] ?? "") ?>"
                   required>
        </p>
        <p>
            <label>Alamat</label><br>
            <input type="text" name="alamat" maxlength="255"
                   value="<?= htmlspecialchars($_POST["alamat"] ?? "") ?>"
                   required>
        </p>
        <button type="submit">Simpan</button>
        <a href="index.php">Kembali</a>
    </form>
</body>
</html>
<?php mysqli_close($conn); ?>
