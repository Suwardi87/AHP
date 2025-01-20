<?php
include "../assets/conn/config.php";
if (isset($_GET['aksi'])) {
   if ($_GET['aksi']=='ubah') {
    $id_alternatif = $_POST['id_alternatif'];
    $nama_alternatif = $_POST['nama_alternatif'];
    mysqli_query($conn,"UPDATE tbl_alternatif SET nama_alternatif='$nama_alternatif' WHERE id_alternatif='$id_alternatif'");
    header("location: alternatif.php");
   }
} 

include"header.php";
?>

<h2 class="mb-4">ALTERNATIF / Ubah Data</h2>
<hr>
            <div class="shadow p-5">
                <?php
                $data = mysqli_query ($conn,"SELECT * FROM tbl_alternatif WHERE id_alternatif='$_GET[id_alternatif]'");
                while ($a = mysqli_fetch_array($data)) { ?>
                    
              
                <form action="alternatif-ubah.php?aksi=ubah" method="post">
                    <input name="id_alternatif" type="hidden" value="<?= $a['id_alternatif'] ?>">
                    <div class="form-group">
                        <label for="">Nama Alternatif</label>
                        <input type="text" name="nama_alternatif" class="input form-control" require value="<?= $a['nama_alternatif'] ?>">
                    </div>

                    
                        <input type="submit" value="Ubah" class="btn btn-dark">
                        <a href="alternatif.php" class="btn btn-primary" style="background-color: #538392">Batal</a>
                    </form>
                    <?php } ?>
            </div>
        </div>
    </div>
</div>
