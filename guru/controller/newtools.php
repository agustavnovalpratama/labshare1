<?php
include '../../config/conn.php';
$id = $_POST['id'] ?? ''; // Menggunakan null coalescing untuk menghindari error jika tidak ada data
$item_code = $_POST['item_code'] ?? '';
$item_name = $_POST['name'] ?? '';
$amount = $_POST['item_stock'] ?? '';


$sql = "INSERT INTO barang VALUES(null, '$item_code', '$item_name', '$amount')";
$exe = mysqli_query($conn, $sql);
// echo $sql;
if ($exe) {
    echo "Data Has Been Save";
    header("location:../inputtools.php");
} else {
    echo "Failed To Save Data";
}
