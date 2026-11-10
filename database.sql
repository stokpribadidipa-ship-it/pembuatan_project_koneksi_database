CREATE DATABASE IF NOT EXISTS `db_sekolah`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `db_sekolah`;

CREATE TABLE IF NOT EXISTS `siswa` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nama` VARCHAR(100) NOT NULL,
    `kelas` VARCHAR(30) NOT NULL,
    `alamat` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;
