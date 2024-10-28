<?php
// Sesuaikan dengan setting MySQL
$servername = "localhost";
$username = "root";
$password = ""; // Ganti dengan password MySQL root jika ada
$dbname = "pgweb_acara7b";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete operation
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Siapkan query untuk menghapus
    $stmt = $conn->prepare("DELETE FROM penduduk WHERE id = ?");
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "Record with id $delete_id deleted successfully";
    } else {
        echo "Error deleting record: " . $stmt->error;
    }

    // Tutup statement
    $stmt->close();
}

// Query untuk mengambil semua data dari tabel penduduk
$sql = "SELECT * FROM penduduk";
$result = $conn->query($sql);

// Tampilkan data dalam tabel
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penduduk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #FFB6C1; /* Baby Pink */
            color: white;
        }
        tr:nth-child(even) {
            background-color: #ADD8E6; /* Baby Blue */
        }
        tr:nth-child(odd) {
            background-color: #ffffff; /* White for odd rows */
        }
        tr:hover {
            background-color: #FFC0CB; /* Light Pink on hover */
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>

<?php
if ($result->num_rows > 0) {
    echo "<h2>Data Penduduk</h2>";
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr>
            <th>ID</th>
            <th>Kecamatan</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Luas</th>
            <th>Jumlah Penduduk</th>
            <th>Aksi</th>
          </tr>";

    // Output data dari setiap baris
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["kecamatan"] . "</td>
                <td>" . $row["latitude"] . "</td>
                <td>" . $row["longitude"] . "</td>
                <td>" . $row["luas"] . "</td>
                <td align='right'>" . $row["jumlah_penduduk"] . "</td>
                <td><a href='?delete_id=" . $row["id"] . "' onclick='return confirm(\"Are you sure you want to delete this item?\");'>Delete</a></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Tidak ada data yang tersedia.";
}

// Tutup koneksi
$conn->close();
?>

</body>
</html>
