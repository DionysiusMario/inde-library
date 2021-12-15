<?php include('header3.html');
// if (isset($_POST['submit'])) {
//     // untuk disimpan didatabase
//     $tgl_pinjam = $_POST['tgl_pinjam'];
//     $tgl_kembali = strtotime("+14 day", strtotime($tgl_pinjam)); // +14 hari dari tgl peminjaman
//     $tgl_kembali = date('Y-m-d', $tgl_kembali); // format tgl peminjaman tahun-bulan-hari

//     $result = $db->query("INSERT INTO peminjaman (tgl_pinjam, tgl_kembali) VALUES ('$tgl_pinjam', '$tgl_kembali')");
//     unset($_POST['submit']);
// }
?>
<br>
<div class="card">
  <div class="card-header h6">
    Anggota Belum Mengembalikan Buku
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
        <th>Tanggal Pinjam</th>
        <th>Tanggal Harus Kembali</th>
        <th>Denda</th>
        <th>ID Petugas</th>
      </tr>
      <?php
      require_once('db_login.php');
      $query_detail_transaksi = "SELECT * FROM detail_transaksi ;";
      $result_detail_transaksi = $db->query($query_detail_transaksi);
      if (!$result_detail_transaksi) {
        die("Could not query the database: <br />" . $db->error . "<br />Query: " . $query_detail_transaksi);
      }

      $query_peminjaman = "SELECT * FROM peminjaman ;";
      $result_peminjaman = $db->query($query_peminjaman);
      if (!$result_peminjaman) {
        die("Could not query the database: <br />" . $db->error . "<br />Query: " . $query_peminjaman);
      }
      // buat mengakali fetch_object hanya sekali, jadi dimasukkan ke dalam array yang diinisialisasi disini
      $peminjaman_array = array();

      // Fetch and display the results
      while ($detail_transaksi = $result_detail_transaksi->fetch_object()) {

        // yang tampil yg detail_transaksi->tgl_kembali nya NULL
        if (!isset($detail_transaksi->tgl_kembali)) {

          if (empty($peminjaman_array)) {
            while ($peminjaman = $result_peminjaman->fetch_object()) {
              array_push($peminjaman_array, $peminjaman);

              // idtransaksi peminjaman === idtransaksi detail_transaksi
              if ($peminjaman->idtransaksi === $detail_transaksi->idtransaksi) {

                echo '<tr>';
                echo '<td>' . $peminjaman->idtransaksi . '</td>';
                echo '<td>' . $peminjaman->nim . '</td>';
                echo '<td>' . $peminjaman->tgl_pinjam . '</td>';

                $tgl_kembali = strtotime("+14 day", strtotime($peminjaman->tgl_pinjam)); // +14 hari dari tgl peminjaman
                $tgl_kembali = date('Y-m-d', $tgl_kembali); // format tgl peminjaman tahun-bulan-hari
                echo '<td>' . $tgl_kembali . '</td>';

                // penghitungan denda ada kl misalkan tgl sekarang <= tgl_kembali
                if (date('Y-m-d') <= $tgl_kembali) {
                  echo '<td>0</td>';
                } else {
                  // penghitungan total denda
                  $t = date_create($tgl_kembali);
                  $n = date_create(date('Y-m-d'));
                  $terlambat = date_diff($t, $n);
                  $hari = $terlambat->format("%a");

                  $total_denda = $hari * 1000;
                  echo '<td>' . $total_denda . '</td>';
                }

                echo '<td>' . $peminjaman->idpetugas . '</td>';
                echo '</tr>';
              }
            }
          } else {
            foreach($peminjaman_array as $peminjaman){

              // idtransaksi peminjaman === idtransaksi detail_transaksi
              if ($peminjaman->idtransaksi === $detail_transaksi->idtransaksi) {
  
                echo '<tr>';
                echo '<td>' . $peminjaman->idtransaksi . '</td>';
                echo '<td>' . $peminjaman->nim . '</td>';
                echo '<td>' . $peminjaman->tgl_pinjam . '</td>';
  
                $tgl_kembali = strtotime("+14 day", strtotime($peminjaman->tgl_pinjam)); // +14 hari dari tgl peminjaman
                $tgl_kembali = date('Y-m-d', $tgl_kembali); // format tgl peminjaman tahun-bulan-hari
                echo '<td>' . $tgl_kembali . '</td>';
  
                // penghitungan denda ada kl misalkan tgl sekarang <= tgl_kembali
                if (date('Y-m-d') <= $tgl_kembali) {
                  echo '<td>0</td>';
                } else {
                  // penghitungan total denda
                  $t = date_create($tgl_kembali);
                  $n = date_create(date('Y-m-d'));
                  $terlambat = date_diff($t, $n);
                  $hari = $terlambat->format("%a");
  
                  $total_denda = $hari * 1000;
                  echo '<td>' . $total_denda . '</td>';
                }
  
                echo '<td>' . $peminjaman->idpetugas . '</td>';
                echo '</tr>';
              }
            }
          }
        }
      }
      echo '</table>';

      $result_peminjaman->free();
      $result_detail_transaksi->free();
      $db->close();
      ?>
    </table>
  </div>
</div>
</div>
<?php include('footer.html'); ?>