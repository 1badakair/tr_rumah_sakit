<?php
// includes/init.php
// Auto-initialize DB from database/schema.sql once.
// Assumsi: file schema.sql ada di ../database/schema.sql dari folder includes.

$schemaFile = realpath(__DIR__ . "/../database/schema.sql");
$flagFile   = __DIR__ . "/.db_initialized";

// Pastikan file schema ada
if (!$schemaFile || !file_exists($schemaFile)) {
    // Tampilkan pesan jelas agar mudah debug
    error_log("init.php: schema.sql not found at expected path: " . (__DIR__ . "/../database/schema.sql"));
    return; // jangan die, biar halaman tetap bisa diload (db mungkin dibuat manual)
}

// Hanya jalankan sekali
if (!file_exists($flagFile)) {

    // Baca isi SQL
    $sql = file_get_contents($schemaFile);
    if ($sql === false) {
        die("Gagal membaca file schema.sql");
    }

    // Connect ke MySQL **tanpa** memilih database (karena DB belum ada)
    $mysqli = new mysqli("localhost", "root", "", ""); // sesuaikan user/pass jika bukan root
    if ($mysqli->connect_error) {
        die("Koneksi MySQL gagal: " . $mysqli->connect_error);
    }
    $mysqli->set_charset("utf8mb4");

    // multi_query untuk mengeksekusi banyak statement di schema.sql
    if ($mysqli->multi_query($sql)) {
        // perlu flush semua result sets
        do {
            if ($res = $mysqli->store_result()) {
                $res->free();
            }
        } while ($mysqli->more_results() && $mysqli->next_result());

        // cek error akhir
        if ($mysqli->errno) {
            // hapus jika ada partial creation? jangan otomatis hapus DB.
            die("Terjadi error saat menjalankan schema.sql: (" . $mysqli->errno . ") " . $mysqli->error);
        }

        // tandai sudah di-init
        file_put_contents($flagFile, date('c') . " initialized\n");
    } else {
        die("Gagal menjalankan schema.sql: " . $mysqli->error);
    }

    $mysqli->close();
}
