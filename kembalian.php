<?php require_once('header.html') ?>
<?php
error_reporting(0);
//include our login information 
require_once('db_login.php');
//exexute query 
$idtransaksi = $_GET['idtransaksi'];
$tgl_pinjam = $_GET['tgl_pinjam'];
if (isset($_POST["submit"])) {
  $valid = TRUE; //flag validasi 
  $tgl_kembali1 = test_input($_POST['tgl_kembali1']);
  $tgl_kembali = strtotime("+14 day", strtotime($tgl_pinjam)); //batas kembali smestinya 
  if ($tgl_kembali1 == '') {
    $error_tgl_kembali1 = "tanggal pengembalian buku belum diisi";
    $valid = FALSE;
  }
  $denda = 0;
  $tgl_kembali12 = strtotime($_POST['tgl_kembali1']);
  if ($tgl_kembali12 > $tgl_kembali) {
    $diff = $tgl_kembali12 - $tgl_kembali;
    $hari = round($diff / (60 * 60 * 24));
    $denda = $hari * 1000;
  }

  $idbuku1 = test_input($_POST['idbuku1']);
  //cek apakah user meminjam 2 buku jika iya maka menginisalisai idbuku2 
  if ($_POST['idbuku2'] != '') {
    $idbuku2 = test_input($_POST['idbuku2']);
    $tgl_kembali2 = test_input($_POST['tgl_kembali2']);
    if ($tgl_kembali2 == '') {
      $error_tgl_kembali2 = "tanggal pengembalian buku belum diisi";
      $valid = FALSE;
    }
    $denda2 = 0;
    $tgl_kembali22 = strtotime($_POST['tgl_kembali2']);
    if ($tgl_kembali22 > $tgl_kembali) {
      $diff2 = $tgl_kembali22 - $tgl_kembali;
      $hari2 = round($diff2 / (60 * 60 * 24));
      $denda2 = $hari2 * 1000;
    }
  }

  if ($valid) {
    //escape inputs data
    $id_buku1 = $db->real_escape_string($idbuku1);
    $tgl_kembali1 = $db->real_escape_string($tgl_kembali1);
    $stok_tersedia1 = "SELECT stok_tersedia FROM buku WHERE idbuku = '" . $id_buku1 . "'";
    $stok_tersedia1 = $db->query($stok_tersedia1);
    $stok_tersedia1 = $stok_tersedia1->fetch_object();
    $stok_tersedia1 = $stok_tersedia1->stok_tersedia;
    $stok_tersedia1 = $stok_tersedia1 + 1;
    $query1 = "UPDATE detail_transaksi JOIN buku ON detail_transaksi.idbuku = buku.idbuku SET detail_transaksi.tgl_kembali='" . $tgl_kembali1 . "', detail_transaksi.denda ='" . $denda . "', buku.stok_tersedia = '" . $stok_tersedia1 . "' WHERE detail_transaksi.idtransaksi='" . $idtransaksi . "' AND detail_transaksi.idbuku='" . $id_buku1 . "'";
    $result = $db->query($query1);
    $qtd1 = "UPDATE peminjaman SET total_denda = '" . $denda . "' WHERE idtransaksi='" . $idtransaksi . "'";
    $rqtd1 = $db->query($qtd1);
    if (isset($idbuku2)) {
      $id_buku2 = $db->real_escape_string($idbuku2);
      $tgl_kembali2 = $db->real_escape_string($tgl_kembali2);
      $stok_tersedia2 = "SELECT stok_tersedia FROM buku WHERE idbuku = '" . $id_buku2 . "'";
      $stok_tersedia2 = $db->query($stok_tersedia2);
      $stok_tersedia2 = $stok_tersedia2->fetch_object();
      $stok_tersedia2 = $stok_tersedia2->stok_tersedia;
      $stok_tersedia2 = $stok_tersedia2 + 1;
      $query2 = "UPDATE detail_transaksi JOIN buku ON detail_transaksi.idbuku = buku.idbuku SET detail_transaksi.tgl_kembali='" . $tgl_kembali2 . "', denda ='" . $denda2 . "', buku.stok_tersedia='" . $stok_tersedia2 . "' WHERE detail_transaksi.idtransaksi='" . $idtransaksi . "' AND detail_transaksi.idbuku='" . $id_buku2 . "'";
      $result2 = $db->query($query2);
      $total_denda = $denda + $denda2;
      $qtd = "UPDATE peminjaman SET total_denda = '" . $total_denda . "' WHERE idtransaksi='" . $idtransaksi . "'";
      $rqtd = $db->query($qtd);
      if (!$result2) {
        die("Could not query to datebase: <br />" . $db->error . '<br>Query:' . $query2);
      }
    }
    if (!$result) {
      die("Could not query to datebase: <br />" . $db->error . '<br>Query:' . $query1);
    } else {
      $db->close();
      header('Location: view_transaksi_peminjaman.php');
    }
    $db->close();
  }
}
?>
<br>
<br>
<div class="card">
  <div class="card-header">
    Pengembalian buku
  </div>
  <div class="card-body">
    <table class="table table-striped">
      <tr>
        <th>ID</th>
        <th>Tanggal Kembali</th>
      </tr>
      <?php
      $query5 = " SELECT idbuku, tgl_kembali FROM detail_transaksi WHERE idtransaksi='" . $idtransaksi . "'";
      $result5 = $db->query($query5);
      if (!$result5) {
        die("could not query database : <br />" . $db->error . "<br>Query:" . $query5);
      }
      ?>
      <form method="POST" autocomplete="on">
        <?php
        $i = 1;
        while ($row = $result5->fetch_object()) {
          echo '<tr>';
          echo '<div class="form-group">';
          echo '<td><input type="text" name="idbuku' . $i . '" id="idbuku' . $i . '" value="' . $row->idbuku . '"  readonly></td>';
          echo '<td><input type="text" name="tgl_kembali' . $i . '" id="tgl_kembali' . $i . '" class="form-control" value="">';

        ?>
          <div class="error"><?php if (isset($error_tgl_kembali1)) echo $error_tgl_kembali1 ?></div>
          </td>
        <?php echo '</div>';
          echo '</tr>';
          $i++;
        }
        ?>
    </table>
    <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>&nbsp;&nbsp;
    <a href="pinjam.php" class="btn btn-secondary">Cancel</a>
    </form>
    <?php
    echo '<br />';
    $result5->free();
    // $db->close();
    ?>

  </div>
</div>
<br>
<?php require_once('footer.html') ?>