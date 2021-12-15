<?php
require_once('db_login.php');

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $result = $db->query("SELECT idbuku FROM detail_transaksi WHERE idtransaksi = '$id' AND tgl_kembali is NULL"); ?>
  <option value="none">--Pilih buku--</option>;
  <?php
  while ($data = $result->fetch_object()) : ?>
    <option value="<?php echo $data->idbuku ?>"><?php echo $data->idbuku ?></option>
<?php
  endwhile;
}
?>