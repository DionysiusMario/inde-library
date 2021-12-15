<?php
//File      : edit_buku.php
//Deskripsi : menampilkan form edit data buku dan mengupdate ke database

require_once('db_login.php');
$id = $_GET['id']; //mendapatkan idbuku yang dilewatkan ke url

// mengecek apakah user belum menekan tombol submit
if (!isset($_POST["submit"])){
    $query = " SELECT *, kategori.nama FROM buku JOIN kategori ON buku.idkategori=kategori.idkategori WHERE idbuku=" .$id. " ";
    //execute the query
    $result = $db->query($query);
    if (!$result){
        die ("Could not the query database: <br />" . $db->error);
    } else {
        while ($row = $result->fetch_object()){
            $file_gambar = $row->file_gambar;
            $isbn = $row->isbn;
            $judul = $row->judul;
            $kategori = $row->nama;
            $pengarang = $row->pengarang;
            $penerbit = $row->penerbit;
            $kota_terbit = $row->kota_terbit;
            $editor = $row->editor;
        }
    }
} else{
    $valid = TRUE; //flag validasi
    $isbn = test_input($_POST['isbn']);
    if ($isbn == ''){
        $error_isbn = "IBSN harus diisi";
        $valid = FALSE;
    }

    $kategori = $_POST['kategori'];
    if ($kategori == 'none'){
        $error_kategori = "Kategori harus diisi";
        $valid = FALSE;
    }

    $judul = test_input($_POST['judul']);
    if ($judul == ''){
        $error_judul = "Judul harus diisi";
        $valid = FALSE;
    }

    $pengarang = test_input($_POST['pengarang']);
    if ($pengarang == ''){
        $error_pengarang = "Pengarang harus diisi";
        $valid = FALSE;
    }

    $file_gambar = $_POST['file_gambar'];

    $penerbit = test_input($_POST['penerbit']);
    if ($penerbit == ''){
        $error_penerbit = "Penerbit harus diisi";
        $valid = FALSE;
    }

    $kota_terbit = test_input($_POST['kota_terbit']);
    if ($kota_terbit == ''){
        $error_kota_terbit = "Kota terbit harus diisi";
        $valid = FALSE;
    }

    $editor = test_input($_POST['editor']);
    if ($editor == ''){
        $error_editor = "Editor harus diisi";
        $valid = FALSE;
    }

    //update data into database
    if ($valid){
        //escape inputs data
        //$judul = $db->real_escape_string($judul); //menghapus tanda petik
        //asign a query
        if($file_gambar != ''){
          $query = " UPDATE buku SET file_gambar='".$file_gambar."', isbn='".$isbn."', idkategori='".$kategori."', judul='".$judul."', pengarang='".$pengarang."', penerbit='".$penerbit."', kota_terbit='".$kota_terbit."', editor='".$editor."' WHERE idbuku=".$id." ";
          $result = $db->query($query);
        }else{
          $query = " UPDATE buku SET isbn='".$isbn."', idkategori='".$kategori."', judul='".$judul."', pengarang='".$pengarang."', penerbit='".$penerbit."', kota_terbit='".$kota_terbit."', editor='".$editor."' WHERE idbuku=".$id." ";
          $result = $db->query($query);
        }
        //execute the query
        if (!$result){
            die ("Could not the query the database: <br />" . $db->error . '<br>Query:' .$query);
        } else{
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
        <div class="card-header">Edit Data Buku</div>
        <div class="card-body">
            <form method="POST" autocomplete="on" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]).'?id=' .$id; ?>">
            <div class="form-group">
                <label for="cover_buku">Cover Buku:</label>
                <br>
                <input type="file" id="file_gambar" name="file_gambar" value="">
                <div class="text-danger"><?php if (isset($error_file_gambar)) echo $error_file_gambar;?></div>
            </div>

            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo $isbn;?>">
                <div class="text-danger"><?php if (isset($error_isbn)) echo $error_isbn;?></div>
            </div>

            <div class="form-group">
                <label for="kategori">Kategori:</label>
                <select name="kategori" id="kategori" class="form-control">
                    <option value="none" <?php if (isset($kategori)) echo 'selected="true"';?>>--Pilih kategori--</option>
                    <?php
                    require_once('db_login.php');
                    //Asign a query
                    $query = " SELECT * FROM kategori ORDER BY idkategori";
                    $result = $db->query( $query );
                    if (!$result){
                        die ("Could not query the database: <br />". $db->error);
                    }
                    // Fetch and display the results
                    while ($row = $result->fetch_object()){
                        echo '<option value="'.$row->idkategori.'">'.$row->nama.'</option>';
                    }
                    $result->free();
                    ?>
                </select>
                <div class="text-danger"><?php if(isset($error_kategori)) echo $error_kategori;?></div>
            </div>

            <div class="form-group">
                <label for="judul">Judul:</label>
                <input class="form-control" id="judul" name="judul" rows="5" value="<?php echo $judul;?>">
                <div class="text-danger"><?php if (isset($error_judul)) echo $error_judul;?></div>
            </div>

            <div class="form-group">
                <label for="pengarang">Pengarang:</label>
                <input class="form-control" id="pengarang" name="pengarang" rows="5" value="<?php echo $pengarang;?>">
                <div class="text-danger"><?php if (isset($error_pengarang)) echo $error_pengarang;?></div>
            </div>

            <div class="form-group">
                <label for="penerbit">Penerbit:</label>
                <input class="form-control" id="penerbit" name="penerbit" rows="5" value="<?php echo $penerbit;?>">
                <div class="text-danger"><?php if (isset($error_penerbit)) echo $error_penerbit;?></div>
            </div>

            <div class="form-group">
                <label for="kotaterbit">Kota Terbit:</label>
                <input class="form-control" id="kota_terbit" name="kota_terbit" rows="5" value="<?php echo $kota_terbit;?>">
                <div class="text-danger"><?php if (isset($error_kota_terbit)) echo $error_kota_terbit;?></div>
            </div>

            <div class="form-group">
                <label for="editor">Editor:</label>
                <input class="form-control" id="editor" name="editor" rows="5" value="<?php echo $editor;?>">
                <div class="text-danger"><?php if (isset($error_editor)) echo $error_editor;?></div>
            </div>

            <br>
            <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
            <a href="index2.php" class="btn btn-secondary">Cancel</a>
        </form>
        </div>
    </div>
</div>
<?php include('footer.html') ?>
<?php
$db->close();
?>
