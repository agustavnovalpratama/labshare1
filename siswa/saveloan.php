<?php
// include '../config/conn.php';
// $id = $_POST['id'] ?? ''; // Menggunakan null coalescing untuk menghindari error jika tidak ada data
// $borrower = $_POST['borrower_name'] ?? '';
// $idalat = $_POST['tools_id'] ?? '';
// $jumlah = $_POST['number_tools'] ?? '';
// $tgl_pinjam = $_POST['tgl_pinjam'] ?? '';
// $tgl_kembali = $_POST['tgl_kembali'] ?? '';
// $status = $_POST['status'];

// $sql = "INSERT INTO peminjaman VALUES(null, '$borrower', '$idalat', '$jumlah', '$tgl_pinjam', '$tgl_kembali', '$status')";
// $exe = mysqli_query($conn, $sql);
// // echo $sql;
// if ($exe) {
//    echo "Data Berhasil Disimpan";
//    header("location:peminjamansiswa.php");
// } else {
//    echo "Gagal Disimpan";
// }
include '../config/conn.php';

$id = $_POST['id'] ?? '';
$borrower = $_POST['borrower_name'] ?? '';
$idalat = $_POST['tools_id'] ?? '';
$jumlah = $_POST['number_tools'] ?? '';
$tgl_pinjam = $_POST['tgl_pinjam'] ?? '';
$tgl_kembali = $_POST['tgl_kembali'] ?? '';
$status = $_POST['status'] ?? 'check';
$actual_return_date = null; // Inisialisasi nilai default

// SQL untuk memasukkan data peminjaman
$sql = "INSERT INTO peminjaman (borrower_name, tools_id, number_tools, loan_date, return_date, status, actual_return_date) VALUES ('$borrower', '$idalat', '$jumlah', '$tgl_pinjam', '$tgl_kembali', '$status', '$actual_return_date')";

$exe = mysqli_query($conn, $sql);

if ($exe) {
   echo "Data Berhasil Disimpan";
   header("location:peminjamansiswa.php");
} else {
   echo "Gagal Disimpan";
}
