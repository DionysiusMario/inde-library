<?php include('header2.html'); ?>
<br>
<div class="card">
  <div class="card-header">
    Login Anggota
  </div>
  <div class="card-body">
    <?php
    //File      : login_petugas.php
    //Deskripsi : menampilkan form login dan melakukan login ke halaman index2.php

    session_start(); //inisialisasi session
    require_once('db_login.php');

    //cek apakah user sudah submit form
    if (isset($_POST["submit"])) {
      $valid = TRUE; //flag validasi

      //cek validasi nama
      $nama = test_input($_POST['nama']);
      if ($nama == '') {
        $error_nama = "Name is required";
        $valid = FALSE;
      }

      //cek validasi password
      $password = test_input($_POST['password']);
      if ($password == '') {
        $error_password = "Password is required";
        $valid = FALSE;
      }

      //cek validasi
      if ($valid) {
        //asign a query
        $query = " SELECT * FROM anggota WHERE nama='" . $nama . "' AND password='" . $password . "' ";
        //excute the query
        $result = $db->query($query);
        if (!$result) {
          die("Could not query the database: <br />" . $db->error);
        } else {
          if ($result->num_rows > 0) { //login berhasil
            $_SESSION['username'] = $nama;
            header('Location: index.php');
            exit;
          } else {  //login gagal
            echo '<div class="alert alert-danger"> Combination of name and password incorrect. </div>';
          }
        }
        //close db connection
        $db->close();
      }
    }
    ?>
    <form method="POST" autocomplete="on" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="form-group">
        <label for="nama">Nama</label>
        <input type="nama" class="form-control" id="nama" name="nama" size="30" value="">
        <div class="text-danger"><?php if (isset($error_nama)) echo $error_nama; ?></div>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" size="30" value="">
        <div class="text-danger"><?php if (isset($error_password)) echo $error_password; ?></div>
      </div>
      <button type="submit" class="btn btn-primary" name="submit" value="submit">Login</button>
      <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
  </div>
</div>
<?php include('footer.html'); ?>