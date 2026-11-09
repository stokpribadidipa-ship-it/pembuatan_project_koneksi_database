
<?php
require_once "koneksi.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    http_response_code(400);
    exit("ID siswa tidak valid.");
}

$stmt = mysqli_prepare(
    $conn,
    "SELECT id, nama, kelas, alamat FROM siswa WHERE id = ?"
);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $dbId, $dbNama, $dbKelas, $dbAlamat);

if (!mysqli_stmt_fetch($stmt)) {
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    http_response_code(404);
    exit("Data siswa tidak ditemukan.");
}

mysqli_stmt_close($stmt);

$nama = $dbNama;
$kelas = $dbKelas;
$alamat = $dbAlamat;
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
            "UPDATE siswa SET nama = ?, kelas = ?, alamat = ? WHERE id = ?"
        );

        mysqli_stmt_bind_param(
            $stmt, "sssi", $nama, $kelas, $alamat, $id
        );

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: index.php?pesan=edit");
            exit;
        }

        $error = "Gagal memperbarui data siswa.";
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Siswa</h1>

    <?php if ($error !== ""): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="edit.php?id=<?= (int)$id ?>">
        <p>
            <label>Nama Siswa</label><br>
            <input type="text" name="nama" maxlength="100"
                   value="<?= htmlspecialchars($nama) ?>" required>
        </p>
        <p>
            <label>Kelas</label><br>
            <input type="text" name="kelas" maxlength="30"
                   value="<?= htmlspecialchars($kelas) ?>" required>
        </p>
        <p>
            <label>Alamat</label><br>
            <input type="text" name="alamat" maxlength="255"
                   value="<?= htmlspecialchars($alamat) ?>" required>
        </p>
        <button type="submit">Simpan Perubahan</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>
<?php mysqli_close($conn); ?>
