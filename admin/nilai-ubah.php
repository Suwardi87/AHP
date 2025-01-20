<?php
include "../assets/conn/config.php";
if (isset($_GET['aksi'])) {
   if ($_GET['aksi']=='ubah') {
    $id_nilai = $_POST['id_nilai'];
    $nilai = $_POST['nilai'];
    $ket = $_POST['ket'];
    mysqli_query($conn,"UPDATE tbl_nilai SET nilai='$nilai',ket='$ket' WHERE id_nilai='$id_nilai'");
    header("location: nilai.php");
   }
} 

include"header.php";
?>

<h2 class="mb-4">NILAI / Ubah Data</h2>
<hr>
            <div class="shadow p-5">
                <?php
                $data = mysqli_query ($conn,"SELECT * FROM tbl_nilai WHERE id_nilai='$_GET[id_nilai]'");
                while ($a = mysqli_fetch_array($data)) { ?>
                    
              
                <form action="nilai-ubah.php?aksi=ubah" method="post">
                    <input name="id_nilai" type="hidden" value="<?= $a['id_nilai'] ?>">
                    <div class="form-group">
                        <label for="">Nilai</label>
                        <input type="number" name="nilai" class="input form-control" require value="<?= $a['nilai'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <input type="text" name="ket" class="input form-control" require value="<?= $a['ket'] ?>">
                    </div>
                    
                        <input type="submit" value="Ubah" class="btn btn-dark">
                        <a href="nilai.php" class="btn btn-primary" style="background-color: #538392">Batal</a>
                    </form>
                    <?php } ?>
            </div>
        </div>
    </div>
</div>
