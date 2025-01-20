<?php
include "../assets/conn/config.php";
if (isset($_GET['aksi'])) {
   if ($_GET['aksi']=='ubah') {
    $id_kriteria = $_POST['id_kriteria'];
    $nama_kriteria = $_POST['nama_kriteria'];
    mysqli_query($conn,"UPDATE tbl_kriteria SET nama_kriteria='$nama_kriteria' WHERE id_kriteria='$id_kriteria'");
    header("location: kriteria.php");
   }
} 

include"header.php";
?>

<h2 class="mb-4">KRITERIA / Ubah Data</h2>
<hr> 
            <div class="shadow p-5">
                <?php
                $data = mysqli_query ($conn,"SELECT * FROM tbl_kriteria WHERE id_kriteria='$_GET[id_kriteria]'");
                while ($a = mysqli_fetch_array($data)) { ?>
                    
              
                <form action="kriteria-ubah.php?aksi=ubah" method="post">
                    <input name="id_kriteria" type="hidden" value="<?= $a['id_kriteria'] ?>">
                    <div class="form-group">
                        <label for="">Nama Kriteria</label>
                        <input type="text" name="nama_kriteria" class="input form-control" require value="<?= $a['nama_kriteria'] ?>">
                    </div>

                    
                        <input type="submit" value="Ubah" class="btn btn-dark">
                        <a href="kriteria.php" class="btn btn-primary" style="background-color: #538392">Batal</a>
                    </form>
                    <?php } ?>
            </div>
        </div>
    </div>

</div>
