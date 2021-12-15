<?php include ('header.html'); ?>
<br>
<div class="card"> 
  <div class="card-header">
    Cari Data Buku
  </div>
  <div class="card-body">
    <form method="GET">
      <input type="text" name="search_title" id="search_title" placeholder="Cari Buku" class="form-control" value="" onkeyup="forIndex()">
    </form>
    <br>
    <div id="result">
      <table class="table table-striped">
        <tr>
          <th>Gambar</th>
          <th>ISBN</th>
          <th>Kategori</th>
          <th>Judul</th>
          <th>Pengarang</th>
          <th>Penerbit</th>
        </tr>
        <?php
        require_once('db_login.php');
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
<!-- ajax -->
<script src="ajax.js"></script>
<!-- ini adalah codingan untuk index yang ada di branch baru-->