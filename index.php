<?=
// koneksi database
$server = "localhost";
$user = "root";
$pass = "";
$database = "arkademy";

$koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));

// jika tombol simpan diklik
if (isset($_POST['btambah'])) {

  //pengujian jika edit maka ganti atau simpan baru
  if ($_GET['hal'] == "edit") {
    // data akan di edit
    $tambah = mysqli_query($koneksi, "UPDATE produk set
                                    nama_produk = '$_POST[tnama]',
                                    keterangan = '$_POST[tketerangan]',
                                    harga = '$_POST[tharga]',
                                    jumlah= '$_POST[tjumlah]'
                                    WHERE id_barang = '$_GET[id]'
                                    ");

    if ($tambah) // jika edit sukses
    {
      echo  "<script>
          alert('Edit Data Sukses!');
          document.location('index.php');
    </script>";
    } else {
      echo  "<script>
          alert('Edit Data Gagal!');
          document.location('index.php');
    </script>";
    }
  } else {
    // data tamtab baru
    $tambah = mysqli_query($koneksi, "INSERT INTO produk(nama_produk,keterangan,harga,jumlah)
                                    VALUE ('$_POST[tnama]',
                                    '$_POST[tketerangan]',
                                    '$_POST[tharga]',
                                    '$_POST[tjumlah]')
                                    ");
    if ($tambah) // jika tambah sukses maka munculkan ini
    {
      echo  "<script>
          alert('Simpan Data Sukses!');
          document.location('index.php');
    </script>";
    } else {
      echo  "<script>
          alert('Simpan Data Gagal!');
          document.location('index.php');
    </script>";
    }
  }
}

// penghujian jika tombol edit/hapus di klik
if (isset($_GET['hal'])) {
  //pengujian jika edit data
  if ($_GET['hal'] == 'edit') {
    //tampil data yang akan di edit
    $tampil = mysqli_query($koneksi, "SELECT*FROM produk WHERE id_barang ='$_GET[id]'");
    $data = mysqli_fetch_array($tampil);
    if ($data) {
      //jika data ditemukan maka di tampung dalam variable
      $vnama = $data['nama_produk'];
      $vketerangan = $data['keterangan'];
      $vharga = $data['harga'];
      $vjumlah = $data['jumlah'];
    }
  }
  else if ($_GET['hal'] == 'hapus')
  {
    //persiapan hapus
    $hapus = mysqli_query($koneksi, "DELETE FROM produk WHERE id_barang ='$_GET[id]'");
    if ($hapus) 
    {
      echo  "<script>
          alert('hapus data selesai!');
          document.location('index.php');
    </script>";
    }
  }
}

?>

<DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD ARKADEMY</title>
    <!-- Css Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
  </head>

  <body>
    <div class="container">
      <h1>CRUD Arkademy</h1>
      <h2>Produk Barang</h2>

      <!-- awal card form -->
      <div class="card">
        <div class="card-header bg-primary">
          Form Produk
        </div>
        <div class="card-body">
          <form method="post" action="">
            <div class="form-group">
              <label>Nama Produk</label>
              <input type="text" name="tnama" value="<?= @$vnama ?>" class="form-control" placeholder="Masukan Nama Barang">
            </div>
            <div class="form-group">
              <label>Keterangan</label>
              <input type="text" name="tketerangan" value="<?= @$vketerangan ?>" class="form-control" placeholder="Masukan Keterangan Barang">
            </div>
            <div class="form-group">
              <label>Harga</label>
              <input type="number" name="tharga" value="<?= @$vharga ?>" class="form-control" placeholder="Masukan Harga Barang">
            </div>
            <div class="form-group">
              <label>Jumlah</label>
              <input type="number" name="tjumlah" value="<?= @$vjumlah ?>" class="form-control" placeholder="Masukan jumlah Barang">
            </div>
            <button type="submit" class="btn btn-primary" name="btambah">Tambah Barang</button>
            <button type="reset" class="btn btn-danger" name="treset">Kosongkan</button>
          </form>
        </div>
      </div>
      <!-- akhir card form -->


      <!-- awal card table -->
      <div class="card mt-3">
        <div class="card-header bg-success">
          Daftar Barang
        </div>
        <div class="card-body">
          <table class="table table-border table-striped">
            <tr>
              <th>No</th>
              <th>Nama Produk</th>
              <th>Keterangan</th>
              <th>Harga</th>
              <th>Jumlah</th>
              <th>Aksi</th>
            </tr>

            <?=
            $no = 1;
            $tampil = mysqli_query($koneksi, "SELECT*from produk order by id_barang desc");
            while ($data = mysqli_fetch_array($tampil)) :

            ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?= $data['nama_produk'] ?></td>
                <td><?= $data['keterangan'] ?></td>
                <td><?= $data['harga'] ?></td>
                <td><?= $data['jumlah'] ?></td>
                <td>
                  <a href="index.php?hal=edit&id=<?= $data['id_barang'] ?>">Edit</a>
                  <a href="index.php?hal=hapus&id=<?= $data['id_barang'] ?>" 
                  onclick="return confirm('apakah yakin akan dihapus?')">Hapus</a>
                </td>
              </tr>

            <?php endwhile; // penutup perulangan while 
            ?>
          </table>

        </div>
      </div>
      <!-- akhir card table-->
    </div>
    <!-- script bootstrap -->
    <script src="js/bootstrap.min.js"></script>
  </body>

  </html>