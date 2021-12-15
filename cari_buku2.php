<?php
require_once('db_login.php');
$judul = $_GET['judul'];
$query = "SELECT *, kategori.nama AS kategori FROM buku JOIN kategori ON buku.idkategori = kategori.idkategori 
  WHERE judul LIKE '%$judul%' OR kategori.nama LIKE '%$judul%' OR pengarang LIKE '%$judul%' OR penerbit LIKE '%$judul%'
  ORDER BY judul ASC";
$result = $db->query($query);
?>
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
  if (!$result) {
    die("Could not query the database: <br />" . $db->error . "<br />Query: " . $query);
  }
  // Fetch and display the results
  while ($row = $result->fetch_object()) {
    echo '<tr>';
    $image = $row->file_gambar;
    echo '<td>' . '<img src="' . $image . '" width="100">' . '</td>';
    echo '<td>' . $row->isbn . '</td>';
    echo '<td>' . $row->kategori . '</td>';
    echo '<td>' . $row->judul . '</td>';
    echo '<td>' . $row->pengarang . '</td>';
    echo '<td>' . $row->penerbit . '</td>';
    echo '<td>
    <a class="btn btn-info btn-sm" href="edit_buku.php?id=' . $row->idbuku . '">Edit</a>&nbsp;&nbsp;
    <a class="btn btn-danger btn-sm" href="delete_buku.php?id=' . $row->idbuku . '">Delete</a>
    </td>';
    echo '</tr>';
  }
  echo '</table>';
  $result->free();
  $db->close();
  ?>
</table>
<script src="ajax.js"></script>