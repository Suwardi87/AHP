<?php
include "../assets/conn/config.php";
if (isset($_GET['aksi'])) {
   if ($_GET['aksi']=='hapus') {
        $id_nilai = $_GET['id_nilai'];
        mysqli_query($conn, "DELETE FROM tbl_nilai WHERE id_nilai='$id_nilai'");
        header("location:nilai.php");
    }
   }

include"header.php";
?>

<h2 class="mb-4">NILAI</h2>
<hr>
            <div class="shadow p-5">
                <a href="nilai-simpan.php" class="btn btn-primary" style="background-color: #538392"><span class="fa fa-plus" > Tambah Data</span></a>
                <hr>

                <table class="table table-bordered">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nilai AHP</th>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Opsi</th>
                    </tr>
                    <?php
                    $data = mysqli_query($conn, "SELECT * FROM tbl_nilai ORDER BY id_nilai");
                    $no=1;
                    while ($a=mysqli_fetch_array($data)) {?>
                    
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center"><?= $a['nilai']?></td>
                        <td class="text-center"><?= $a['ket']?></td>
                        <td class="text-center">
                            <a href="nilai-ubah.php?id_nilai=<?= $a['id_nilai'] ?>" class="btn btn-dark"><span class="fa fa-pencil"></span></a>
                            <a href="nilai.php?id_nilai=<?= $a['id_nilai'] ?>&aksi=hapus" class="btn btn-danger"><span class="fa fa-trash"></span></a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>

</div>
