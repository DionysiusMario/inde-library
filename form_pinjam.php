<?php include('header3.html');
require_once('db_login.php');
?>
<br>
<div class="card">
    <div class="card-header">Form Peminjaman</div>
    <div class="card-body">
        <?php
        //File      : add_buku.php
        //Deskripsi : menampilkan form add data buku dan mengupdate ke database

        if (isset($_POST["submit"])) {
            $valid = TRUE; //flag validasi

            // $idtransaksi = $_POST['idtransaksi'];
            // if ($idtransaksi == '') {
            //     $error_idtransaksi = "ID Transaksi harus diisi";
            //     $valid = FALSE;
            // }

            $nama = $_POST['nama'];
            if ($nama == 'none') {
                $error_nama = "Nama harus diisi";
                $valid = FALSE;
            }

            $judul = $_POST['judul'];
            $judul2 = $_POST['judul2'];
            if ($judul == 'none') {
                $error_judul = "Judul harus diisi";
                $valid = FALSE;
            } else if ($judul == $judul2) {
                $error_judul2 = "Tidak boleh meminjam buku yang sama";
                $valid = FALSE;
            }

            $tgl_pinjam = $_POST['tgl_pinjam'];
            if ($tgl_pinjam == '') {
                $error_tgl_pinjam = "Tanggal pinjam harus diisi";
                $valid = FALSE;
            }

            $petugas = $_POST['petugas'];
            if ($petugas == 'none') {
                $error_petugas = "Nama petugas harus diisi";
                $valid = FALSE;
            }

            //update data into database
            if ($valid) {
                //escape inputs data
                //asign a query
                $query = " INSERT INTO peminjaman (nim, tgl_pinjam, idpetugas) VALUES ($nama, '$tgl_pinjam', $petugas) ";
                $query2 = " INSERT INTO detail_transaksi (idtransaksi, idbuku, tgl_kembali)
                        VALUES (
                            (SELECT MAX(idtransaksi) FROM peminjaman),
                            (SELECT idbuku FROM buku WHERE idbuku=" . $judul . "),
                            NULL
                        )";
                //execute the query
                $result = $db->query($query);
                $result2 = $db->query($query2);
                if ($judul2 != 'none') {
                    $query3 = " INSERT INTO detail_transaksi (idtransaksi, idbuku, tgl_kembali)
                        VALUES (
                            (SELECT MAX(idtransaksi) FROM peminjaman),
                            (SELECT idbuku FROM buku WHERE idbuku=" . $judul2 . "),
                            NULL
                        )";
                    $result3 = $db->query($query3);
                    if (!$result3) {
                        die("Could not the query the database: <br />" . $db->error . '<br>Query:' . $query3);
                    }
                }
                if (!$result) {
                    die("Could not the query the database: <br />" . $db->error . '<br>Query:' . $query);
                } else if (!$result2) {
                    die("Could not the query the database: <br />" . $db->error . '<br>Query:' . $query2);
                } else {
                    echo '<div class="alert alert-success">Data berhasil ditambahkan.</div>';
                }
            }
        }
        ?>
        <form method="POST" autocomplete="on">
            <!-- <div class="form-group">
            <label for="idtransaksi">ID Transaksi:</label>
            <input type="number" class="form-control" id="idtransaksi" name="idtransaksi" size="30" value="">
            <div class="text-danger"><?php if (isset($error_idtransaksi)) echo $error_idtransaksi; ?></div>
        </div> -->
            <div class="form-group">
                <label for="nama">Nama anggota:</label>
                <select name="nama" id="nama" class="form-control" onchange="cekNim(this.value)">
                    <option value="0">--Pilih nama--</option>
                    <?php
                    //Asign a query
                    $query = " SELECT * FROM anggota ORDER BY nim ";
                    $result = $db->query($query);
                    if (!$result) {
                        die("Could not query the database: <br />" . $db->error);
                    }
                    // Fetch and display the results
                    while ($row = $result->fetch_object()) {
                        echo '<option value="' . $row->nim . '">' . $row->nama . '</option>';
                    }
                    $result->free();
                    ?>
                </select>
                <div class="text-danger"><?php if (isset($error_nama)) echo $error_nama; ?></div>
                <div class="text-danger" id="error_anggota"></div>
            </div>
            <div class="form-group">
                <label for="judul">Judul buku 1:</label>
                <select name="judul" id="judul" class="form-control">
                    <option value="none" <?php if (isset($judul)) echo 'selected="true"'; ?>>--Pilih judul--</option>
                    <?php
                    //Asign a query
                    $query = " SELECT * FROM buku ORDER BY idbuku";
                    $result = $db->query($query);
                    if (!$result) {
                        die("Could not query the database: <br />" . $db->error);
                    }
                    // Fetch and display the results
                    while ($row = $result->fetch_object()) {
                        echo '<option value="' . $row->idbuku . '">' . $row->judul . '</option>';
                    }
                    $result->free();
                    ?>
                </select>
                <div class="text-danger"><?php if (isset($error_judul)) echo $error_judul; ?></div>
            </div>
            <div class="form-group">
                <label for="judul2">Judul buku 2:</label>
                <select name="judul2" id="judul2" class="form-control">
                    <option value="none" <?php if (isset($judul2)) echo 'selected="true"'; ?>>--Pilih judul--</option>
                    <?php
                    //Asign a query
                    $query = " SELECT * FROM buku ORDER BY idbuku";
                    $result = $db->query($query);
                    if (!$result) {
                        die("Could not query the database: <br />" . $db->error);
                    }
                    // Fetch and display the results
                    while ($row = $result->fetch_object()) {
                        echo '<option value="' . $row->idbuku . '">' . $row->judul . '</option>';
                    }
                    $result->free();
                    ?>
                </select>
                <div class="text-danger"><?php if (isset($error_judul2)) echo $error_judul2; ?></div>
            </div>
            <div class="form-group">
                <label for="tgl_pinjam">Tanggal Pinjam:</label>
                <input type="date" class="form-control" id="tgl_pinjam" name="tgl_pinjam" size="30" value="">
                <div class="text-danger"><?php if (isset($error_tgl_pinjam)) echo $error_tgl_pinjam; ?></div>
            </div>
            <div class="form-group">
                <label for="petugas">Nama Petugas:</label>
                <select name="petugas" id="petugas" class="form-control">
                    <option value="none" <?php if (isset($petugas)) echo 'selected="true"'; ?>>--Pilih petugas--</option>
                    <?php
                    //Asign a query
                    $query = " SELECT * FROM petugas ORDER BY idpetugas";
                    $result = $db->query($query);
                    if (!$result) {
                        die("Could not query the database: <br />" . $db->error);
                    }
                    // Fetch and display the results
                    while ($row = $result->fetch_object()) {
                        echo '<option value="' . $row->idpetugas . '">' . $row->nama . '</option>';
                    }
                    $result->free();
                    $db->close();
                    ?>
                </select>
                <div class="text-danger"><?php if (isset($error_petugas)) echo $error_petugas; ?></div>
            </div>
            <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
        </form>
    </div>
</div>
<?php include('footer.html'); ?>