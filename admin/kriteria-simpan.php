<?php
include "../assets/conn/config.php";
if (isset($_GET['aksi'])) {
   if ($_GET['aksi']=='simpan') {
    $nama_kriteria = $_POST['nama_kriteria'];
    mysqli_query($conn,"INSERT INTO tbl_kriteria(nama_kriteria)VALUES('$nama_kriteria')");
    header("location: kriteria.php");
   }
} 

include"header.php";
?>

<h2 class="mb-4">KRITERIA / Tambah Data</h2>
<hr>
            <div class="shadow p-5">
                <form action="kriteria-simpan.php?aksi=simpan" method="post">
                    <div class="form-group">
                        <label for="">Nama Kriteria</label>
                        <input type="text" name="nama_kriteria" class="input form-control" require>
                    </div>
                    
                        <input type="submit" value="Simpan" class="btn btn-dark">
                        <a href="kriteria.php" class="btn btn-primary" style="background-color: #538392">Batal</a>
                    </form>
            </div>
        </div>
    </div>
</div>
