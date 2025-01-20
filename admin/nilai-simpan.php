<?php
include "../assets/conn/config.php";
if (isset($_GET['aksi'])) {
   if ($_GET['aksi']=='simpan') {
    $nilai = $_POST['nilai'];
    $ket = $_POST['ket'];
    mysqli_query($conn,"INSERT INTO tbl_nilai(nilai,ket)VALUES('$nilai','$ket')");
    header("location: nilai.php");
   }
} 

include"header.php";
?>

<h2 class="mb-4">NILAI / Tambah Data</h2>
<hr>
            <div class="shadow p-5">
                <form action="nilai-simpan.php?aksi=simpan" method="post">
                    <div class="form-group">
                        <label for="">Nilai</label>
                        <input type="number" name="nilai" class="input form-control" require>
                    </div>

                    <div class="form-group">
                        <label for="">Keterangan</label>
                        <input type="text" name="ket" class="input form-control" require>
                    </div>
                    
                        <input type="submit" value="Simpan" class="btn btn-dark" >
                        <a href="nilai.php" class="btn btn-primary" style="background-color: #538392">Batal</a>
                    </form>
            </div>
        </div>
    </div>
</div>
