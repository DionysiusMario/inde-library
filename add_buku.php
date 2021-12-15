<?php
//File      : add_buku.php
//Deskripsi : menampilkan form add data buku dan mengupdate ke database

require_once('db_login.php');
if (isset($_POST["submit"])){
    $valid = TRUE; //flag validasi
    $isbn = test_input($_POST['isbn']);
    if ($isbn == ''){
        $error_isbn = "ISBN harus diisi";
        $valid = FALSE;
    }

    $judul = test_input($_POST['judul']);
    if ($judul == ''){
        $error_judul = "Judul harus diisi";
        $valid = FALSE;
    }

    $kategori = test_input($_POST['kategori']);
    if ($kategori == '' || $kategori == 'none'){
        $error_kategori = "Kategori harus diisi";
        $valid = FALSE;
    }

    $pengarang = test_input($_POST['pengarang']);
    if ($pengarang == ''){
        $error_pengarang = "Pengarang harus diisi";
        $valid = FALSE;
    }

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

    $pengarang = test_input($_POST['pengarang']);
    if ($pengarang == ''){
        $error_pengarang = "Pengarang harus diisi";
        $valid = FALSE;
    }

    $file_gambar = $_POST['file_gambar'];
    if ($file_gambar == ''){
        $error_file_gambar = "Gambar harus ditautkan";
        $valid = FALSE;
    }

    $tgl_insert = test_input($_POST['tgl_insert']);
    if ($tgl_insert == ''){
        $error_tgl_insert = "Tanggal insert buku harus diisi";
        $valid = FALSE;
    }

    $tgl_update = test_input($_POST['tgl_update']);
    if ($tgl_update == ''){
        $error_tgl_update = "Tanggal update buku harus diisi";
        $valid = FALSE;
    }

    $stok = $_POST['stok'];
    if ($stok == ''){
        $error_stok = "Stok harus diisi";
        $valid = FALSE;
    } else if ($stok<0){
        $error_stok = "Stok tidak boleh negatif";
        $valid = FALSE;
    }

    $stok_tersedia = $_POST['stok_tersedia'];
    if ($stok_tersedia == ''){
        $error_stok_tersedia = "Stok tersedia harus diisi";
        $valid = FALSE;
    } else if ($stok_tersedia<0){
        $error_stok_tersedia = "Stok tersedia tidak boleh negatif";
        $valid = FALSE;
    }

    //update data into database
    if ($valid){
        //escape inputs data
        $address = $db->real_escape_string($_POST['address']); //menghapus tanda petik
        //asign a query
        $query = " INSERT INTO buku (file_gambar, isbn, judul, idkategori, pengarang, penerbit, kota_terbit, editor, tgl_insert, tgl_update, stok, stok_tersedia)
                   VALUES ('$file_gambar', $isbn, '$judul', $kategori, '$pengarang', '$penerbit', '$kota_terbit', '$editor', '$tgl_insert', '$tgl_update', $stok, $stok_tersedia) ";
        //execute the query
        $result = $db->query($query);
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
        <div class="card-header">Tambah Buku</div>
        <div class="card-body">
            <form method="POST" autocomplete="on" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
            <div class="form-group">
                <label for="cover_buku">Cover Buku:</label>
                <br>
                <input type="file" id="file_gambar" name="file_gambar">
                <div class="text-danger"><?php if (isset($error_file_gambar)) echo $error_file_gambar;?></div>
            </div>

            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" class="form-control" id="isbn" name="isbn" value="<?php if(isset($isbn)) echo $isbn;?>">
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
                <input type="text" class="form-control" id="judul" name="judul" value="<?php if(isset($judul)) echo $judul;?>">
                <div class="text-danger"><?php if (isset($error_judul)) echo $error_judul;?></div>
            </div>

            <div class="form-group">
                <label for="pengarang">Pengarang:</label>
                <input type="text" class="form-control" id="pengarang" name="pengarang" value="<?php if(isset($pengarang)) echo $pengarang;?>">
                <div class="text-danger"><?php if (isset($error_pengarang)) echo $error_pengarang;?></div>
            </div>

            <div class="form-group">
                <label for="penerbit">Penerbit:</label>
                <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?php if(isset($penerbit)) echo $penerbit;?>">
                <div class="text-danger"><?php if (isset($error_penerbit)) echo $error_penerbit;?></div>
            </div>

            <div class="form-group">
                <label for="kota_terbit">Kota Terbit:</label>
                <input type="text" class="form-control" id="kota_terbit" name="kota_terbit" value="<?php if(isset($kota_terbit)) echo $kota_terbit;?>">
                <div class="text-danger"><?php if (isset($error_kota_terbit)) echo $error_kota_terbit;?></div>
            </div>

            <div class="form-group">
                <label for="editor">Editor:</label>
                <input type="text" class="form-control" id="editor" name="editor" value="<?php if(isset($editor)) echo $editor;?>">
                <div class="text-danger"><?php if (isset($error_editor)) echo $error_editor;?></div>
            </div>

            <div class="form-group">
                <label for="tgl_insert">Tanggal insert buku:</label>
                <input type="date" class="form-control" id="tgl_insert" name="tgl_insert" value="<?php if(isset($tgl_insert)) echo $tgl_insert;?>">
                <div class="text-danger"><?php if (isset($error_tgl_insert)) echo $error_tgl_insert;?></div>
            </div>

            <div class="form-group">
                <label for="tgl_update">Tanggal update buku:</label>
                <input type="date" class="form-control" id="tgl_update" name="tgl_update" value="<?php if(isset($tgl_update)) echo $tgl_update;?>">
                <div class="text-danger"><?php if (isset($error_tgl_update)) echo $error_tgl_update;?></div>
            </div>

            <div class="form-group">
                <label for="stok">Stok:</label>
                <input type="number" class="form-control" id="stok" name="stok" value="<?php if(isset($stok)) echo $stok;?>">
                <div class="text-danger"><?php if (isset($error_stok)) echo $error_stok;?></div>
            </div>

            <div class="form-group">
                <label for="stok_tersedia">Stok tersedia:</label>
                <input type="number" class="form-control" id="stok_tersedia" name="stok_tersedia" value="<?php if(isset($stok_tersedia)) echo $stok_tersedia;?>">
                <div class="text-danger"><?php if (isset($error_stok_tersedia)) echo $error_stok_tersedia;?></div>
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
