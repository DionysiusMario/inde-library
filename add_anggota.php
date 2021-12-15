<?php
//File      : add_anggota.php
//Deskripsi : menampilkan form add anggota dan mengupdate ke database

require_once('db_login.php');
if (isset($_POST["submit"])) {
    $valid = TRUE; //flag validasi
    $nim = test_input($_POST['nim']);
    if ($nim == '') {
        $error_nim = "nim harus diisi";
        $valid = FALSE;
    } else {
        $query = " SELECT * FROM anggota WHERE nim='" . $nim . "'";
        $result = $db->query($query);
        if ($result->num_rows > 0) { //nim sudah ada
            $error_nim = "nim sudah ada";
            $valid = FALSE;
        }
    }

    $nama = test_input($_POST['nama']);
    if ($nama == '') {
        $error_nama = "nama harus diisi";
        $valid = FALSE;
    }

    $password = test_input($_POST['password']);
    if ($password == '') {
        $error_password = "Password harus diisi";
        $valid = FALSE;
    }

    $alamat = test_input($_POST['alamat']);
    if ($alamat == '') {
        $error_alamat = "Alamat harus diisi";
        $valid = FALSE;
    }

    $kota = test_input($_POST['kota']);
    if ($kota == '') {
        $error_kota = "Kota harus diisi";
        $valid = FALSE;
    }

    $email = test_input($_POST['email']);
    if ($email == '') {
        $error_email = "email harus diisi";
        $valid = FALSE;
    }

    $no_telp = test_input($_POST['no_telp']);
    if ($no_telp == '') {
        $error_no_telp = "No Telepon harus diisi";
        $valid = FALSE;
    }

    //update data into database
    if ($valid) {
        //escape inputs data
        $address = $db->real_escape_string($_POST['address']); //menghapus tanda petik
        //asign a query
        $query = " INSERT INTO anggota (nim, nama, password, alamat, kota, email, no_telp)
                   VALUES ('$nim', '$nama', '$password', '$alamat', '$kota', '$email', '$no_telp') ";
        //execute the query
        $result = $db->query($query);
        if (!$result) {
            die("Could not the query the database: <br />" . $db->error . '<br>Query:' . $query);
        } else {
            $db->close();
            header('Location: index2.php');
        }
    }
}
?>
<?php include('header3.html'); ?>
<br>
<div class="container">
    <div class="card">
        <div class="card-header">Tambah Anggota</div>
        <div class="card-body">
            <form method="POST" autocomplete="on" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">

                <div class="form-group">
                    <label for="nim">NIM:</label>
                    <input type="text" class="form-control" id="nim" name="nim" value="<?php if (isset($nim)) echo $nim; ?>">
                    <div class="text-danger"><?php if (isset($error_nim)) echo $error_nim; ?></div>
                </div>

                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php if (isset($nama)) echo $nama; ?>">
                    <div class="text-danger"><?php if (isset($error_nama)) echo $error_nama; ?></div>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" value="<?php if (isset($password)) echo $password; ?>">
                    <div class="text-danger"><?php if (isset($error_password)) echo $error_password; ?></div>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?php if (isset($alamat)) echo $alamat; ?>">
                    <div class="text-danger"><?php if (isset($error_alamat)) echo $error_alamat; ?></div>
                </div>

                <div class="form-group">
                    <label for="kota">Kota:</label>
                    <input type="text" class="form-control" id="kota" name="kota" value="<?php if (isset($kota)) echo $kota; ?>">
                    <div class="text-danger"><?php if (isset($error_kota)) echo $error_kota; ?></div>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?php if (isset($email)) echo $email; ?>">
                    <div class="text-danger"><?php if (isset($error_email)) echo $error_email; ?></div>
                </div>

                <div class="form-group">
                    <label for="no_telp">No Telepon:</label>
                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?php if (isset($no_telp)) echo $no_telp; ?>">
                    <div class="text-danger"><?php if (isset($error_no_telp)) echo $error_no_telp; ?></div>
                </div>


                <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
                <a href="index2.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
<?php
$db->close();
?>