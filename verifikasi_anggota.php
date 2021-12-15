<?php

require_once('db_login.php');

if (! isset($_GET['nim'])) {
    echo false;
} else {
    $nim = test_input($_GET['nim']);
    $result = $db->query("SELECT peminjaman.nim
                        FROM peminjaman JOIN detail_transaksi
                        ON peminjaman.idtransaksi = detail_transaksi.idtransaksi
                        WHERE detail_transaksi.tgl_kembali IS NULL AND
                        peminjaman.nim= $nim");
    if($result->num_rows > 0){
      echo "Tidak boleh meminjam";
    }
}
