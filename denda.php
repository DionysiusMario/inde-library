<?php include('header3.html'); ?>
<br>
<div class="card">
    <div class="card-header h6">
        Denda
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <small>
                * Waktu peminjaman buku hanya 14 hari<br />
                * Set waktu > 14 hari sebelum tanggal sekarang<br />
                * Denda keterlambatan 1000/hari<br />
            </small>
        </div>
        <br>
        <table class="table table-striped">
            <tr>
                <th>ID Transaksi</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Denda</th>
            </tr>
            <?php
            require_once('db_login.php');
            $query = "SELECT peminjaman.idtransaksi, peminjaman.nim, anggota.nama, peminjaman.total_denda 
                      FROM peminjaman JOIN anggota ON peminjaman.nim=anggota.nim 
                      WHERE total_denda != 0 ";
            $result = $db->query($query);
            if (!$result) {
                die("Could not query the database: <br />" . $db->error . "<br />Query: " . $query);
            }
            // Fetch and display the results
            while ($row = $result->fetch_object()) {
                echo '<tr>';
                echo '<td>' . $row->idtransaksi . '</td>';
                echo '<td>' . $row->nim . '</td>';
                echo '<td>' . $row->nama . '</td>';
                echo '<td>' . $row->total_denda . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            $result->free();
            $db->close();
            ?>
        </table>
    </div>
</div>
</div>
<?php include('footer.html'); ?>