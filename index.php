<?php
// hubungkan dengan file koneksi.php
require_once('koneksi.php');
// pagination
$halaman = 1;
$batas = 5; // jumlah data per halaman
$mulai_dari = ($halaman-1) * $batas;

// 1. sistem read data
function read_data() {

  global $mysqli;
  global $mulai_dari;
  global $batas;

  $query = "SELECT * FROM tb_buku_2201010538 LIMIT $mulai_dari, $batas";
  $result = mysqli_query($mysqli, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
      $data[] = $row;
    }
    
    return $data;
  } else {
    // jika query kosong, kembalikan array kosong
    return array();
  }
}


// 2. sistem hapus data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id_buku = $_POST['id_buku'];

  // Query untuk menghapus data buku berdasarkan ID
  $query = "DELETE FROM tb_buku_2201010538 WHERE ID_buku_2201010538 = '$id_buku'";

  // Eksekusi query
  if(mysqli_query($mysqli, $query)) {
    // Redirect ke halaman sebelumnya
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
  } else {
    echo "Error deleting record: " . mysqli_error($conn);
  }

  // Tutup koneksi
  mysqli_close($conn);
}


// 3. sistem cari data
function read_by_search() {
  global $mysqli;
  global $mulai_dari;
  global $batas;

  // Retrieve search query parameter
  $search_query = isset($_GET['search']) ? $_GET['search'] : '';

  // Prepare and execute search query
  $sql = "SELECT * FROM tb_buku_2201010538 WHERE Judul_buku_2201010538 LIKE '%$search_query%' LIMIT $mulai_dari, $batas";
  $result = mysqli_query($mysqli, $sql);

  // Fetch search results
  if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
      }
      return $data;
  } else {
      return array();
  }
}

// panggil fungsi untuk membaca data
if (isset($_GET['search'])) {
  $data_tabel = read_by_search();
} else {
  $data_tabel = read_data();
}


// 4. sistem halaman buku

// pagination bootstrap
$query_jumlah = mysqli_query($mysqli, "SELECT COUNT(*) AS jumlah FROM tb_buku_2201010538");
$jumlah_data = mysqli_fetch_array($query_jumlah)['jumlah'];
$jumlah_halaman = ceil($jumlah_data / $batas);

?>

<?php 
  // memanggil header.php
  require_once('header.php');
?>

 <!-- konten -->

<main class="container my-5">
  <!-- search bar -->
  <div class="p-1 rounded rounded-pill shadow mb-4">
    <form adction="index.php" method="GET" class="input-group">
      <input type="search" name="search" placeholder="What're you searching for?" aria-describedby="button-addon1" class="form-control border-0 bg-white rounded-pill">
      <div class="input-group-append">
        <button id="button-addon1" type="submit" class="btn btn-link text-primary">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
          </svg>
        </button>
      </div>
    </form>
  </div>

  <!-- table -->
  <div class="p-2 shadow">
    <table class="table table-striped">
      <thead>
        <tr>
          <th class="scope">ID Buku</th>
          <th class="scope">Judul Buku</th>
          <th class="scope">Kategori Buku</th>
          <th class="scope">Penerbit</th>
          <th class="scope">Penulis</th>
          <th class="scope">Stok</th>
          <th class="scope">Harga</th>
          <th class="scope">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php 
          for($i = 0; $i < count($data_tabel); $i++) {
        ?>
        <tr>
          <th scope="row"><?= $data_tabel[$i]['ID_buku_2201010538'] ?></th>
          <th scope="row"><?= $data_tabel[$i]['Judul_buku_2201010538'] ?></th>
          <th scope="row"><?= $data_tabel[$i]['Kategori_buku_2201010538'] ?></th>
          <th scope="row"><?= $data_tabel[$i]['Penerbit_2201010538'] ?></th>
          <th scope="row"><?= $data_tabel[$i]['Penulis_2201010538'] ?></th>
          <th scope="row"><?= $data_tabel[$i]['Stok_2201010538'] ?></th>
          <th scope="row"><?= $data_tabel[$i]['Harga_2201010538'] ?></th>
          <th scope="row">
            <div class="row">
              <div class="col">
                <a href="detail.php?id=<?= $data_tabel[$i]['ID_buku_2201010538'] ?>" style="width:100%" class="btn btn-outline-primary">
                Detail
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journals" viewBox="0 0 16 16">
                  <path d="M5 0h8a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2 2 2 0 0 1-2 2H3a2 2 0 0 1-2-2h1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1H1a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v9a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1H3a2 2 0 0 1 2-2z"/>
                  <path d="M1 6v-.5a.5.5 0 0 1 1 0V6h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V9h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 2.5v.5H.5a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1H2v-.5a.5.5 0 0 0-1 0z"/>
                </svg>
                </a>
              </div>
              <div class="col">
                <a href="update.php?id=<?= $data_tabel[$i]['ID_buku_2201010538'] ?>" style="width:100%" class="btn btn-outline-secondary">
                Update
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-check" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                  <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                  <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
                </svg>
                </a>
              </div>
              <div class="col">
                <form action="index.php" method="POST">
                  <input type="hidden" value="<?= $data_tabel[$i]['ID_buku_2201010538'] ?>" name="id_buku">
                  <button type="submit" onclick="return confirm('yakin ingin di hapus?')" style="width:100%" class="btn btn-outline-danger">
                    Hapus
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                      <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                    </svg>
                  </button>
                </form>
              </div>
            </div>
          </th>
        </tr>
        <?php 
          }
        ?>
      </tbody>
    </table>
    <!-- pagination -->
    <nav aria-label="...">
          <ul class="pagination">
            <li class="page-item '.($halaman <= 1 ? 'disabled' : '').'">
              <a class="page-link" href="?halaman='.($halaman-1).'" tabindex="-1" aria-disabled="'.($halaman <= 1 ? 'true' : 'false').'">Previous</a>
            </li>';

  <?php 
  for ($i=1; $i<=$jumlah_halaman; $i++) {
    $link_active = ($i == $halaman) ? 'active' : '';
    echo '<li class="page-item '.$link_active.'"><a class="page-link" href="?halaman='.$i.'">'.$i.'</a></li>';
  } ?>

  <li class="page-item '.($halaman >= $jumlah_halaman ? 'disabled' : '').'">
          <a class="page-link" href="?halaman='.($halaman+1).'">Next</a>
        </li>
      </ul>
    </nav>

  </div>

</main>


<?php 
  // memanggil footer.php
  require_once('footer.php');
?>
