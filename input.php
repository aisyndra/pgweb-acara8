<?php
// Debug POST data
echo "<pre>";
print_r($_POST);
echo "</pre>";

// Mengambil nilai dari POST, jika tidak ada set dengan string kosong
$kecamatan = isset($_POST["kecamatan"]) ? $_POST["kecamatan"] : "";
$latitude = isset($_POST["latitude"]) ? $_POST["latitude"] : "";
$longitude = isset($_POST["longitude"]) ? $_POST["longitude"] : "";
$luas = isset($_POST["luas"]) ? $_POST["luas"] : "";
$jumlah_penduduk = isset($_POST["jumlah_penduduk"]) ? $_POST["jumlah_penduduk"] : "";

// Validasi sederhana: cek apakah semua field terisi
if (empty($kecamatan) || empty($latitude) || empty($longitude) || empty($luas) || empty($jumlah_penduduk)) {
    die("Semua field harus diisi.");
}

// Sesuaikan dengan setting MySQL
$servername = "localhost";
$username = "root";
$password = ""; // Pastikan password sesuai dengan pengaturan Anda
$dbname = "pgweb_acara7b";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query menggunakan prepared statement untuk mencegah SQL Injection
$stmt = $conn->prepare("INSERT INTO penduduk (kecamatan, latitude, longitude, luas, jumlah_penduduk) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sdddi", $kecamatan, $latitude, $longitude, $luas, $jumlah_penduduk);

// Mengeksekusi query dan cek apakah berhasil
if ($stmt->execute()) {
    echo "Data berhasil ditambahkan. <a href='index.php'>Kembali ke halaman utama</a>";
} else {
    echo "Error: " . $stmt->error;
}

// Tutup statement dan koneksi
$stmt->close();
$conn->close();
?>
