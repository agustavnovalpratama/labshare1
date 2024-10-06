<?php
session_start();
include "../config/conn.php";
if (empty($_SESSION['username']) || empty($_SESSION['role'])) {
    echo "<script>alert('Untuk Membuka Halaman Ini, Silahkan Login Terlebih Dahulu!');document.location='login.php'</script>";
    exit();
}
$query = "SELECT id, name FROM barang WHERE item_stock > 0"; // Hanya menampilkan alat yang masih tersedia
$result = mysqli_query($conn, $query);

$name = $_SESSION['name'];
$query2 = "SELECT peminjaman.*, barang.name FROM peminjaman INNER JOIN barang ON peminjaman.tools_id = barang.id WHERE borrower_name = '$name' AND status = 'check' OR status = 'borrowed'";
$exe = mysqli_query($conn, $query2);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Peminjaman</title>
    <script src="https://kit.fontawesome.com/f8a09ade68.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/classic.css">
    <link rel="stylesheet" href="css/classic.date.css">
    <link rel="stylesheet" href="homestyle.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>

<body>
    <!--Navbar START-->
    <nav class="navbar navbar-expand-lg bg-secondary fw-bolder sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand me-xl-4" href="#"><img class="logo" src="../assets/image/logolab - Copy.png"
                    style="height: 70px;" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="homesiswa.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle" href="form/index.html" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Form
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="peminjaman_mhs.php">Peminjaman</a></li>
                            <li><a class="dropdown-item" href="pengembalian_mhs.php">Pengembalian</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="pelaporan_mhs.php">Pelaporan</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="info_mhs.php">Informasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="contact_mhs.php">Contact</a>
                    </li>
                </ul>

                <form class="logout d-flex mt-3" role="submit">
                    <p class="me-2"><i class="fa-solid fa-user-graduate"></i> Hello, <?= $_SESSION['name'] ?></p>
                    <p class="me-2">|</p>
                    <a href="../controller/logout.php" role="button"><i class="fa-solid fa-right-from-bracket">Log
                            out</i></a>
                </form>
            </div>
        </div>
    </nav>
    <!--Navbar END-->

    <!--Container START-->
    <div class="container-fluid text-light" style="height: 100vh;">
        <div class="nav row justify-content-evenly text-center align-items-center">
            <div class="col-sm-6">
                <div class="card text-bg-secondary mb-3">
                    <div class="card-body">
                        <h3 class="card-title fw-bold">WELCOME TO THE LABORATORY <p>REKAYASA PERANGKAT LUNAK</h3>
                        <p class="card-text">You can enjoy the service online <i class="fa-solid fa-clock"></i></p>
                    </div>
                </div>
            </div>
        </div>

        <!--Data START-->
        <div class="row justify-content-evenly align-items-center text-center">
            <div class="col-sm-8">
                <div class="card">
                    <button type="button" class="btn btn-secondary bold" data-bs-toggle="modal" data-bs-target="#add">
                        Add Borrow Items
                    </button>
                    <div class="card-body">
                        <div style="max-height: 240px; overflow-y: auto;">
                            <table class="table table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Tools</th>
                                        <th>Loan Amount</th>
                                        <th>Loan Date</th>
                                        <th>Return Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = '1';
                                    while ($data = mysqli_fetch_array($exe)) {
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data['borrower_name'] ?></td>
                                        <td><?= $data['name'] ?></td>
                                        <td><?= $data['number_tools'] ?> Items</td>
                                        <td><?= $data['loan_date'] ?></td>
                                        <td><?= $data['return_date'] ?></td>
                                        <td>
                                            <?php if ($data['status'] === 'borrowed'): ?>
                                            Borrowed
                                            <?php elseif ($data['status'] === 'returned'): ?>
                                            Returned
                                            <?php elseif ($data['status'] === 'check'): ?>
                                            <button class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#show" onclick="loadData(<?= $data['id'] ?>)">
                                                Check
                                            </button>
                                            <?php else: ?>
                                            <?= $data['status'] ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <span
                            class="position-absolute top-0 start-30 translate-middle badge rounded-pill bg-secondary text-white"><i
                                class="fa-solid fa-desktop"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <!--Data END-->
    </div>
    <!--Container END-->

    <!-- Modal Add Data-->
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Loan Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="saveloan.php" method="post">
                        <div class="form-row">
                            <div class="form-group">
                                <input type="hidden" name="id_borrow" class="form-control" id="id" required value="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <!-- <label>Borrower Name</label> -->
                                <input type="text" name="borrower_name" class="form-control" id="nim" required
                                    value="<?php echo $_SESSION['name'] ?>" hidden>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group">
                                <label>Id Tools</label>
                                <select class="form-select" name="tools_id" id="idalat" required>
                                    <option value="" disabled selected>Pilih Alat</option>
                                    <?php
                                    // Periksa apakah $result sudah diatur dan hasil kueri valid
                                    if (isset($result) && mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled>Tidak ada alat tersedia</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group">
                                <label>Number of Tools</label>
                                <input type="text" name="number_tools" class="form-control" id="jumlah" required
                                    placeholder="Enter The Number of Tools">
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group">
                                <label for="input_from"><i class="fa-solid fa-calendar-days"></i> Loan Date</label>
                                <input type="text" name="tgl_pinjam" class="form-control" id="input_from"
                                    placeholder="Start Date" style="width: 180px;" required>
                            </div>
                            <div class="form-group mt-2">
                                <label for="input_to"><i class="fa-solid fa-calendar-days"></i> Return Date</label>
                                <input type="text" name="tgl_kembali" class="form-control" id="input_to"
                                    placeholder="End Date" style="width: 180px;" required>
                            </div>
                        </div>
                        <input type="hidden" value="check" name="status">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Show Data -->
    <script>
    function loadData(id) {
        // Lakukan AJAX untuk mengambil data berdasarkan id
        fetch(`getData.php?id=${id}`)
            .then(response => response.text())
            .then(data => {
                // Masukkan data yang diterima ke dalam modal
                document.getElementById('modalContent').innerHTML = data;
            })
            .catch(error => console.error('Error fetching data:', error));
    }
    </script>
    <div class="modal fade" id="show" tabindex="-1" aria-labelledby="checkModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkModalLabel">Loan Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Data akan dimuat di sini -->
                    <div id="modalContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!--Footer START-->
    <!--Footer END-->

    <a id="back-to-top" href="#" class="btn btn-warning btn-md back-to-top" role="button"><i
            class="fas fa-chevron-up"></i></a>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/picker.js"></script>
    <script src="js/picker.date.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
    <script src="home.js"></script>

</body>

</html>