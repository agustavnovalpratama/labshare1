<?php
include "../../config/conn.php";

$id = $_POST['id'];
$item_code = $_POST['item_code'];
$item_name = $_POST['name'];
$amount = $_POST['item_stock'];

// Perbaiki query update
$sql = "UPDATE barang SET item_code= '$item_code', name = '$item_name', item_stock = '$amount' WHERE id = '$id'";
$exe = mysqli_query($conn, $sql);

if($exe){
    echo "<script>alert('Data Item Has been Updated');window.location='../inputtools.php';</script>";
}else{
    echo "<script>alert('Error: Can't Update Data Item');window.location='../inputtools.php';</script>";
}
?>
