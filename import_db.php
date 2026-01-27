<?php

// Konfigurasi Database Railway
$host = 'crossover.proxy.rlwy.net';
$port = '42797';
$db = 'railway';
$user = 'root';
$pass = 'kUMWWdAyHmWkHVbWgAGnrlJkMgwcWYsj';

// Lokasi file SQL
$file_sql = 'C:\Users\USER\Downloads\Misc\data_apa.sql';

echo "Menghubungkan ke Database Railway...\n";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Terhubung!\n";
    echo "MEMBERSIHKAN DATABASE LAMA (Wiping)...\n";

    // Matikan Foreign Key Check agar bisa drop table sembarangan
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

    // Ambil daftar semua tabel
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

    if (count($tables) > 0) {
        foreach ($tables as $table) {
            echo " - Menghapus tabel: $table\n";
            $pdo->exec("DROP TABLE IF EXISTS `$table`");
        }
    } else {
        echo " - Database sudah kosong.\n";
    }

    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    echo "Database bersih. Membaca file SQL...\n";

    if (!file_exists($file_sql)) {
        die("Error: File SQL tidak ditemukan di: $file_sql\n");
    }

    $sql = file_get_contents($file_sql);

    echo "Sedang mengimport data (mohon tunggu)...\n";

    // Eksekusi SQL
    $pdo->exec($sql);

    echo "BERHASIL! Database telah berhasil diimport ke Railway.\n";

} catch (PDOException $e) {
    echo "Gagal: " . $e->getMessage() . "\n";
}
