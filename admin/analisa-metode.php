<?php
include"header.php";
?>

<h2 class="mb-4">ANALISA METODE</h2>
<hr>
      <h4>Matriks Alternatif</h4>
      <table class="table table-bordered">
        <tr>
            <th class="text-center">Alternatif/Kriteria</th>
            <?php 
            $data = mysqli_query($conn,"SELECT * FROM tbl_kriteria ORDER BY id_kriteria");
            while ($a=mysqli_fetch_array($data)) {
                echo"<th class='text-center'>$a[nama_kriteria]</th>";
            }?>
        </tr>

        <?php
        $query = mysqli_query($conn,"SELECT * FROM tbl_alternatif ORDER BY id_alternatif");
        while ($b=mysqli_fetch_array($query)) { 
            
            $kode = $b['id_alternatif'];
            $nama = $b['nama_alternatif'];
            ?>
           
        <tr>
            <td><?php echo $nama ?></td>
            <?php 
            //untuk menampilkan nilai rata-rata alternatif berdasarkan kriterianya
            $query1 = mysqli_query($conn,"SELECT bobot_alternatif as sub FROM tbl_analisa_alternatif_act 
            WHERE id_alternatif = '$kode' GROUP BY id_kriteria");
            while ($b1=mysqli_fetch_array($query1)) {
                $nilai_sub = number_format($b1['sub'],3);
                echo "<td class='text-center'>$nilai_sub</td>";
            }
            ?>
        </tr>
        <?php } ?>

        <tr>
            <td colspan="1"><b>Bobot Kriteria</b></td>
            <?php 
            $data = mysqli_query($conn,"SELECT * FROM tbl_kriteria ORDER BY id_kriteria");
            while ($a=mysqli_fetch_array($data)) {
                $bobot_k = number_format($a['bobot_kriteria'],3);
                echo"<td class='text-center'><b>$bobot_k</b></td>";
            }?>
        </tr>
      </table>
      <br><br>

      <h4>Hasil Perkalian Matriks</h4>
      <table class="table table-bordered">
        <tr>
            <th class="text-center">Alternatif/Kriteria</th>
            <?php 
            $data = mysqli_query($conn,"SELECT * FROM tbl_kriteria ORDER BY id_kriteria");
            while ($a=mysqli_fetch_array($data)) {
                echo"<th class='text-center'>$a[nama_kriteria]</th>";
            }?>
            <th class="text-center">Total</th>
        </tr>

        <?php
        $query = mysqli_query($conn,"SELECT * FROM tbl_alternatif ORDER BY id_alternatif");
        while ($b=mysqli_fetch_array($query)) { 
            $total = 0.0;
            $kode = $b['id_alternatif'];
            $nama = $b['nama_alternatif'];
            ?>
           
        <tr>
            <td><?php echo $nama ?></td>
            <?php 
            //untuk menampilkan nilai rata-rata alternatif berdasarkan kriterianya
            $query1 = mysqli_query($conn,"SELECT bobot_alternatif as sub, id_kriteria as id_kriteria
             FROM tbl_analisa_alternatif_act WHERE id_alternatif = '$kode' GROUP BY id_kriteria");
            while ($b1=mysqli_fetch_array($query1)) {
                $nilai_sub =$b1['sub'];

                //panggil nilai bobot kriteria
                $data = mysqli_query($conn,"SELECT bobot_kriteria FROM tbl_kriteria WHERE id_kriteria='$b1[id_kriteria]'");
                $a=mysqli_fetch_array($data);
                $bobot_k = $a['bobot_kriteria'];

                //lakukan perkalian matriks
                $perkalian_bobot = $nilai_sub * $bobot_k;
                $total += $perkalian_bobot;
                echo "<td class='text-center'>".number_format($perkalian_bobot,3)."</td>";
            }
            echo "<td class='text-center'>".number_format($total,3)."</td>";
            //ambil nilai akhir ahp
            mysqli_query($conn,"UPDATE tbl_alternatif SET nilai_ahp='$total' WHERE id_alternatif='$kode'");
            ?>
        </tr>
        <?php } 
        //hitung jumlah row dikrateria
        $data = mysqli_query($conn,"SELECT * FROM tbl_kriteria");
        $jml_row = mysqli_num_rows($data)+1;

        ?>

        <tr>
            <td colspan="<?php echo $jml_row ?>"><b>Total</b></td>
            <?php 
            $data = mysqli_query($conn,"SELECT SUM(nilai_ahp) as sum_nilai FROM tbl_alternatif");
            while ($a=mysqli_fetch_array($data)) {
                echo"<td class='text-center'><b>".number_format($a['sum_nilai'],3)."</b></td>";
            }?>
        </tr>
      </table>
      <br>

      <?php 
      //set rangking
      $data = mysqli_query($conn,"SELECT * FROM tbl_alternatif ORDER BY nilai_ahp DESC");
      $rank = 1; 
            while ($a=mysqli_fetch_array($data)) {
                mysqli_query($conn,"UPDATE tbl_alternatif SET rangking='$rank' WHERE id_alternatif='$a[id_alternatif]'");
                $rank++;
            }
      ?>
                <h4>Perangkingan</h4>
                <table class="table table-bordered">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nama Alternatif</th>
                        <th class="text-center">Nilai AHP</th>
                        <th class="text-center">Rangking</th>
                    </tr>
                    <?php
                    $data = mysqli_query($conn, "SELECT * FROM tbl_alternatif ORDER BY id_alternatif");
                    $no=1;
                    while ($a=mysqli_fetch_array($data)) {?>
                    
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center"><?= $a['nama_alternatif']?></td>
                        <td class="text-center"><?= number_format($a['nilai_ahp'],3)?></td>
                        <td class="text-center"><?= $a['rangking']?></td>
                    </tr>
                    <?php } ?>
                </table>

        </div>
    </div>
</div>
