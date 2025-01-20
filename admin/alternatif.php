<?php
include "../assets/conn/config.php";
if (isset($_GET['aksi'])) {
   if ($_GET['aksi']=='hapus') {
        $id_alternatif = $_GET['id_alternatif'];
        mysqli_query($conn, "DELETE FROM tbl_alternatif WHERE id_alternatif='$id_alternatif'");
        header("location:alternatif.php");
    }
   }

include"header.php";
?>

<h2 class="mb-4">ALTERNATIF</h2>
<hr>
            <div class="shadow p-5">
                <a href="alternatif-simpan.php" class="btn btn-primary" style="background-color: #538392"><span class="fa fa-plus"> Tambah Data</span></a>
                <hr>

                <table class="table table-bordered">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Alternatif</th>
                        <th class="text-center">Opsi</th>
                    </tr>
                    <?php
                    $data = mysqli_query($conn, "SELECT * FROM tbl_alternatif ORDER BY id_alternatif");
                    $no=1;
                    while ($a=mysqli_fetch_array($data)) {?>
                    
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center"><?= $a['nama_alternatif']?></td>
                        <td class="text-center">
                            <a href="alternatif-ubah.php?id_alternatif=<?= $a['id_alternatif'] ?>" class="btn btn-dark"><span class="fa fa-pencil"></span></a>
                            <a href="alternatif.php?id_alternatif=<?= $a['id_alternatif'] ?>&aksi=hapus" class="btn btn-danger"><span class="fa fa-trash"></span></a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</div>
