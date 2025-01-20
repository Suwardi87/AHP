<?php
include "../assets/conn/config.php";
if (isset($_GET['aksi'])) {
   if ($_GET['aksi']=='hapus') {
        $id_kriteria = $_GET['id_kriteria'];
        mysqli_query($conn, "DELETE FROM tbl_kriteria WHERE id_kriteria='$id_kriteria'");
        header("location:kriteria.php");
    }
   }

include"header.php";
?>

<h2 class="mb-4">KRITERIA</h2>
<hr>
            <div class="shadow p-5">
                <a href="kriteria-simpan.php" class="btn btn-primary" style="background-color: #538392"><span class="fa fa-plus"> Tambah Data</span></a>
                <hr>

                <table class="table table-bordered">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Kriteria</th>
                        <th class="text-center">Opsi</th>
                    </tr>
                    <?php
                    $data = mysqli_query($conn, "SELECT * FROM tbl_kriteria ORDER BY id_kriteria");
                    $no=1;
                    while ($a=mysqli_fetch_array($data)) {?>
                    
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center"><?= $a['nama_kriteria']?></td>
                        <td class="text-center">
                            <a href="kriteria-ubah.php?id_kriteria=<?= $a['id_kriteria'] ?>" class="btn btn-dark"><span class="fa fa-pencil"></span></a>
                            <a href="kriteria.php?id_kriteria=<?= $a['id_kriteria'] ?>&aksi=hapus" class="btn btn-danger"><span class="fa fa-trash"></span></a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
    
