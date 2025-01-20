<?php
include "../assets/conn/config.php";
if (isset($_GET['aksi'])) {
   if ($_GET['aksi']=='simpan') {
    $nama_alternatif = $_POST['nama_alternatif'];
    mysqli_query($conn,"INSERT INTO tbl_alternatif(nama_alternatif)VALUES('$nama_alternatif')");
    header("location: alternatif.php");
   }
} 

include"header.php";
?>

<h2 class="mb-4">ALTERNATIF / Tambah Data</h2>
<hr>
            <div class="shadow p-5">
                <form action="alternatif-simpan.php?aksi=simpan" method="post">
                    <div class="form-group">
                        <label for="">Nama Alternatif</label>
                        <input type="text" name="nama_alternatif" class="input form-control" require>
                    </div>
                    
                        <input type="submit" value="Simpan" class="btn btn-dark">
                        <a href="alternatif.php" class="btn btn-primary" style="background-color: #538392">Batal</a>
                    </form>
            </div>
        </div>
    </div>
</div>
