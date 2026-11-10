<?php
function validasiDataSiswa(string $nama, string $kelas, string $alamat): array
{
    $errors = [];

    if ($nama === "") {
        $errors[] = "Nama siswa wajib diisi.";
    } elseif (!preg_match('/\A(?=.{2,100}\z)(?=(?:.*\p{L}){2})[\p{L}\p{M} .\'-]+\z/u', $nama)) {
        $errors[] = "Nama harus terdiri dari minimal 2 huruf dan hanya boleh memakai huruf, spasi, titik, tanda petik, atau tanda hubung.";
    }

    if ($kelas === "") {
        $errors[] = "Kelas wajib diisi.";
    } elseif (!preg_match('/\A(?=.{1,30}\z)[\p{L}\p{M}0-9 -]+\z/u', $kelas)) {
        $errors[] = "Kelas hanya boleh memakai huruf, angka, spasi, atau tanda hubung (maksimal 30 karakter).";
    }

    if ($alamat === "") {
        $errors[] = "Alamat wajib diisi.";
    } elseif (!preg_match('/\A(?=.{5,255}\z)(?=.*\p{L})[\p{L}\p{M}0-9\s,.\'’\/#:-]+\z/u', $alamat)) {
        $errors[] = "Alamat minimal 5 karakter, harus memuat huruf, dan tidak boleh berisi simbol yang tidak valid.";
    }

    return $errors;
}
