<?php include('header3.html');
require_once('db_login.php')
?>
<br>
<div class="card">
  <div class="card-header">
    Form Pengembalian
  </div>
  <div class="card-body">
    <?php
    if(isset($_POST['submit'])){
      $idt = test_input($_POST['idt']);
      $idb = test_input($_POST['buku']);
      $tglBalik = $_POST['tglBalik'];

      $result = $db->query("SELECT tgl_pinjam FROM peminjaman WHERE idtransaksi = $idt");
      $hari0 = $result->fetch_object();
      $hari = new DateTime($hari0->tgl_pinjam);
      $hari2 = new DateTime($tglBalik);
      $jml = $hari2->diff($hari)->format("%a");
      if($jml>14){
        $jml = $jml - 14;
        $result2 = $db->query("UPDATE detail_transaksi SET tgl_kembali = '".$tglBalik."', denda = $jml * 1000 WHERE idtransaksi = $idt AND idbuku = $idb");
        $result3 = $db->query("UPDATE peminjaman SET total_denda = total_denda + $jml * 1000 WHERE idtransaksi = $idt");
      }else{
        $result2 = $db->query("UPDATE detail_transaksi SET tgl_kembali = '".$tglBalik."', denda = 0 WHERE idtransaksi = $idt AND idbuku = $idb ");
        $result3 = $db->query("UPDATE peminjaman SET total_denda = total_denda + 0 WHERE idtransaksi = $idt ");
      }
      if($result){
        echo '<div class="alert alert-success">Data berhasil disimpan</div>';
      }
    }
    ?>
    <form class="" method="post">
      <div class="form-group">
        <label for="idTransaksi">ID Transaksi:</label>
        <select name="idt" id="idt" class="form-control" onchange="pilihBuku(this.value)">
            <option value="none">--Pilih transaksi--</option>
            <?php
            require_once('db_login.php');
            //Asign a query
            $query = " SELECT DISTINCT peminjaman.idtransaksi FROM peminjaman JOIN detail_transaksi ON peminjaman.idtransaksi = detail_transaksi.idtransaksi WHERE detail_transaksi.tgl_kembali is NULL ORDER BY peminjaman.idtransaksi";
            $result = $db->query( $query );
            if (!$result){
                die ("Could not query the database: <br />". $db->error);
            }
            // Fetch and display the results
            while ($row = $result->fetch_object()){
                echo '<option value="'.$row->idtransaksi.'">'.$row->idtransaksi.'</option>';
            }
            $result->free();
            ?>
        </select>
      </div>
      <div class="form-group">
        <label for="idBuku">ID Buku:</label>
        <select name="buku" id="buku" class="form-control">
            <option value="none">--Pilih buku--</option>;
        </select>
      </div>
      <div class="form-group">
          <label for="tglBalik">Tanggal Pengembalian:</label>
          <input type="date" class="form-control" id="tglBalik" name="tglBalik">
      </div>
      <button type="submit" class="btn btn-primary" value="submit" name="submit">Submit</button>
    </form>
  </div>
</div>
<?php include ('footer.html'); ?>
