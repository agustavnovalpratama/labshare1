<?php
session_start();
include "../config/conn.php";

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = hash('sha256', $_POST['password']);
$pass = mysqli_real_escape_string($conn, $password);
$role = mysqli_real_escape_string($conn, $_POST['role']);

$users_check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' and role = '$role'");
// echo $users_check;
$validated_users = mysqli_fetch_array($users_check);

if ($validated_users) {
    if ($pass == $validated_users['password']) {
        $_SESSION['username'] = $validated_users['username'];
        $_SESSION['name'] = $validated_users['name'];
        $_SESSION['role'] = $validated_users['role'];
    }

    if ($role == "guru") {
        header('location:../guru/homeguru.php');

    }elseif ($role == "siswa") {
        header('location:../siswa/homesiswa.php');

    }else {
        echo "<script>alert('Sorry, Login Failed. Your password is not registered!'); document.location='../login.php'</script>";
    }

}else {
    echo "<script>alert('Sorry, Login Failed. Your Username is Not Registered!'); document.location='../login.php'</script>";
}