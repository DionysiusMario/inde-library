<?php include ('header3.html');
session_start(); //inisialisasi session
if(!isset($_SESSION['username'])){
  header('Location: login_petugas.php');
}
?>
<br>
<div class="card">
  <div class="card-header">
    Cari Data Buku
  </div>
  <div class="card-body">
    <form method="GET">
      <input type="text" name="cari_judul" id="cari_judul" placeholder="Cari Buku" class="form-control" value="" onkeyup="forIndex2()">
    </form>
    <br>
    <div class="text-right">
      <a class="btn btn-primary" href="add_buku.php">+ Tambah Buku</a><br /><br />
    </div>
    <div id="hasil">
      <table class="table table-striped">
        <tr>
          <th>Gambar</th>
          <th>ISBN</th>
          <th>Kategori</th>
          <th>Judul</th>
          <th>Pengarang</th>
          <th>Penerbit</th>
          <th>Actions</th>
        </tr>
        <?php
        $query = "SELECT *, kategori.nama AS kategori FROM buku JOIN kategori ON buku.idkategori = kategori.idkategori order by idbuku";
        $result = $db->query($query);
        if(!$result){
          die("Could not query the database: <br />". $db->error ."<br />Query: ".$query);
        }
        // Fetch and display the results
        while ($row = $result->fetch_object()){
          echo '<tr>';
          $image = $row->file_gambar;
          echo '<td>'.'<img src="'.$image.'" width="100">'.'</td>';
          echo '<td>'.$row->isbn.'</td>';
          echo '<td>'.$row->kategori.'</td>';
          echo '<td>'.$row->judul.'</td>';
          echo '<td>'.$row->pengarang.'</td>';
          echo '<td>'.$row->penerbit.'</td>';
          echo '<td>
          <a class="btn btn-info btn-sm" href="edit_buku.php?id='.$row->idbuku.'">Edit</a>&nbsp;&nbsp;
          <a class="btn btn-danger btn-sm" href="delete_buku.php?id='.$row->idbuku.'">Delete</a>
          </td>';
          echo'</tr>';
        }
        echo '</table>';
        $result->free();
        $db->close();
        ?>
      </table>
    </div>
  </div>
</div>
<?php include ('footer.html'); ?>
