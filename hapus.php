
<?php
require_once "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    mysqli_close($conn);
    http_response_code(400);
    exit("ID siswa tidak valid.");
}

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM siswa WHERE id = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header("Location: index.php?pesan=hapus");
        exit;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    http_response_code(404);
    exit("Data siswa tidak ditemukan.");
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
http_response_code(500);
exit("Gagal menghapus data siswa.");
