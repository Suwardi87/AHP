<?php
include "../assets/conn/config.php";
if (isset($_GET['aksi'])) {
    if ($_GET['aksi']=='simpan') {
        $id_kriteria_pertama = $_POST['id_kriteria_pertama'];
        $nilai = $_POST['nilai'];
        $id_kriteria_kedua = $_POST['id_kriteria_kedua'];

        //cek nilai
        $data = mysqli_query($conn,"SELECT * FROM tbl_analisa_kriteria WHERE id_kriteria_pertama='$id_kriteria_kedua'
        AND id_kriteria_kedua='$id_kriteria_pertama'");
        $a = mysqli_fetch_array($data);
        $nilai_pembagian = $a['nilai'];

        if (empty($nilai_pembagian)) {
            
            if ($id_kriteria_pertama==$id_kriteria_kedua) {
                $nilai_baru = 1;
            } else {
                $nilai_baru = $nilai;
            } 
        } else {
            $nilai_baru = 1/$nilai_pembagian;
        }

        //cek data
        $da = mysqli_query($conn,"SELECT * FROM tbl_analisa_kriteria WHERE id_kriteria_pertama='$id_kriteria_pertama'
        AND id_kriteria_kedua='$id_kriteria_kedua'");
        $aa = mysqli_num_rows($da);
        if ($aa>0) {
            header("location:analisa-kriteria.php?pesan=gagal");
        } else{
            mysqli_query($conn,"INSERT INTO tbl_analisa_kriteria(id_kriteria_pertama,nilai,id_kriteria_kedua)VALUES('$id_kriteria_pertama',
            '$nilai_baru','$id_kriteria_kedua')");
            header("location:analisa-kriteria.php?");
        }
    } elseif ($_GET['aksi']=='resetdata') {
        mysqli_query($conn,"TRUNCATE TABLE tbl_analisa_kriteria");
        header("location:analisa-kriteria.php?");
    }
}
include"header.php";
?>

<h2 class="mb-4">PERBANDINGAN KRITERIA</h2>
<hr>
        <div class="shadow p-5">
            <a onclick="if(confirm('Data akan terhapus secara menyeluruh !!!')){ location.href='analisa-kriteria.php?aksi=resetdata'}" 
            class="btn btn-danger text-light">Reset Data Kriteria</a>
            <hr>

            <?php
            if (isset($_GET['pesan'])) {
              if ($_GET['pesan']=='gagal') {
                echo "<div class='alert alert-danger' role='alert'><span class='fa fa-times'></span> Data Gagal Disimpan </div>";
              }
            }
            ?>

            <h4>Perbandingan Antara Kriteria</h4>
            <i style="color:red;">*catatan : untuk melakukan perbandingan silahkan lakukan dari kiri ke kanan secara berurutan untuk
            mendapatkan hasil yang maksimal</i>
            <table class="table table-bordered">
                <tr>
                    <th class="text-center">Kriteria</th>
                    <?php
                    $data = mysqli_query($conn,"SELECT * FROM tbl_kriteria ORDER BY id_kriteria");
                    while ($a=mysqli_fetch_array($data)) {
                        echo "<th class='text-center'>$a[nama_kriteria]</th>";
                    } 
                    ?>
                </tr>

                <?php
                $query = mysqli_query($conn,"SELECT * FROM tbl_kriteria ORDER BY id_kriteria");
                while ($a=mysqli_fetch_array($query)) {
                    $kode = $a['id_kriteria'];
                    $nama = $a['nama_kriteria'];
                    echo "
                        <tr>
                        <td>$nama</td>
                    ";

                 $data = mysqli_query($conn,"SELECT * FROM tbl_kriteria ORDER BY id_kriteria");
                 while ($b=mysqli_fetch_array($data)) {
                    $id_kriteria=$b['id_kriteria']; ?>

                    <td class="text-center">
                        <form action="analisa-kriteria.php?aksi=simpan" method="post">
                            <input type="hidden" name="id_kriteria_kedua" value="<?php echo $id_kriteria ?>">
                            <input type="hidden" name="id_kriteria_pertama" value="<?php echo $kode ?>">

                            <select name="nilai" class="form-control" type="submit" onchange="this.form.submit()">
                                <option>pilih nilai</option>
                                <?php
                                $nilai = mysqli_query($conn, "SELECT * FROM tbl_nilai ORDER BY id_nilai");
                                while ($n=mysqli_fetch_array($nilai)) {
                                    echo "<option value='$n[nilai]'>$n[nilai]</option>"; 
                                }
                                ?>    
                            </select>
                        </form>
                    </td>
                 
                <?php } echo "</tr>"; }  ?>

            </table>
            <br>

            <h4>Hasil Perbandingan Kriteria</h4>  
            <table class="table table-bordered">
                 <tr>
                    <th class="text-center">Kriteria</th>
                    <?php
                    $data = mysqli_query($conn,"SELECT * FROM tbl_kriteria ORDER BY id_kriteria");
                    while ($a=mysqli_fetch_array($data)) {
                        echo "<th class='text-center'>$a[nama_kriteria]</th>";
                    } 
                    ?>
                </tr>

                    <?php
                    $data = mysqli_query($conn,"SELECT * FROM tbl_kriteria ORDER BY id_kriteria");
                    while ($a=mysqli_fetch_array($data)) {
                        $kode = $a['id_kriteria'];
                        $nama = $a['nama_kriteria'];
                        echo "
                            <tr>
                            <td>$nama</td>
                        ";

                        //untuk menampilkan nilai yang telah dipilih
                        $query = mysqli_query($conn,"SELECT nilai as sub FROM tbl_analisa_kriteria WHERE id_kriteria_pertama='$kode' ORDER BY id_analisa");
                        while ($q=mysqli_fetch_array($query)) {
                            echo "<td class='text-center'>".round($q['sub'],2)."</td>";
                        }
                        ?>
                </tr>
                <?php } ?>

                <tr>
                    <td colspan="1"><b>Jumlah</b></td>
                    <?php
                    $data = mysqli_query($conn,"SELECT * FROM tbl_kriteria ORDER BY id_kriteria");
                    while ($a=mysqli_fetch_array($data)) {
                     
                        $query = mysqli_query($conn,"SELECT sum(nilai) as sum_nilai FROM tbl_analisa_kriteria WHERE id_kriteria_kedua='$a[id_kriteria]'");
                        while ($q=mysqli_fetch_array($query)) {
                            $sum_nilai = $q['sum_nilai'];

                            echo "<td class='text-center'><b>".round($sum_nilai,2)."</b></td>";
                            //ambil nilai total kriteria/jumlah
                            mysqli_query($conn,"UPDATE tbl_kriteria set total_kriteria='$sum_nilai' WHERE id_kriteria='$a[id_kriteria]'");
                        }
                        ?>
                 
                <?php } ?>


                </tr>        

            </table>
            <br>
            
            <h4>Normalisasi Perbandingan Kriteria</h4>  
            <table class="table table-bordered">
                 <tr>
                    <th class="text-center">Kriteria</th>
                    <?php
                    $data = mysqli_query($conn,"SELECT * FROM tbl_kriteria ORDER BY id_kriteria");
                    while ($a=mysqli_fetch_array($data)) {
                        echo "<th class='text-center'>$a[nama_kriteria]</th>";
                    } 
                    ?>
                    <th class="text-center">Rata-Rata</th>
                </tr>

                    <?php
                    $data = mysqli_query($conn,"SELECT * FROM tbl_kriteria ORDER BY id_kriteria");
                    while ($a=mysqli_fetch_array($data)) {
                        $n = mysqli_num_rows($data); 
                        $sum_nm=0.0;
                        $kode = $a['id_kriteria'];
                        $nama = $a['nama_kriteria'];
                        echo "
                            <tr>
                            <td>$nama</td>
                        ";

                        //untuk menampilkan nilai 
                        $query = mysqli_query($conn,"SELECT nilai as sub, id_kriteria_kedua as id_kriteria FROM tbl_analisa_kriteria WHERE id_kriteria_pertama='$kode' ORDER BY id_analisa");
                        while ($q=mysqli_fetch_array($query)) {  
                            $nilai_sub = $q['sub'];

                            //panggil nilai total kriteria
                            $dat = mysqli_query($conn,"SELECT total_kriteria FROM tbl_kriteria WHERE id_kriteria='$q[id_kriteria]'");
                            $b=mysqli_fetch_array($dat);
                            $bobot_t = $b['total_kriteria'];
                            $normalisasi = $nilai_sub / $bobot_t;
                            echo "<td class='text-center'>".round($normalisasi,2)."</td>";

                            $sum_nm += $normalisasi;
                            $avg_sum = $sum_nm/$n;
                        }
                        echo "<td class='text-center'>".round($avg_sum,2)."</td>";
                         //ambil nilai rata-rata (nilai rata2 dijadikan untuk nilai bobot)
                         mysqli_query($conn,"UPDATE tbl_kriteria set bobot_kriteria='$avg_sum' WHERE id_kriteria='$a[id_kriteria]'");
                        ?>
                </tr>
                <?php } ?>

                <tr>
                    <td colspan="1"><b>Jumlah</b></td>
                    <?php
                    $data = mysqli_query($conn,"SELECT * FROM tbl_kriteria ORDER BY id_kriteria");
                    $count = mysqli_num_rows($data) + 1;
                    
                     
                        $query = mysqli_query($conn,"SELECT sum(bobot_kriteria) as sum_bobot FROM tbl_kriteria");
                        $q=mysqli_fetch_array($query);
                            $sum_bobot = $q['sum_bobot'];
                            
                            for ($i = 0; $i < $count; $i++) { 
                                echo "<td class='text-center'><b>".round($sum_bobot,2)."</b></td>"; 
                            }
                 
                 ?>
                </tr>        
            </table>
            <br>
            
            <?php
            //untuk menghitung nilai matriks
            $data = mysqli_query($conn,"SELECT * FROM tbl_kriteria ORDER BY id_kriteria");
            while ($a=mysqli_fetch_array($data)) {
               
                $sum_matriks=0.0;
                $kode = $a['id_kriteria'];
                
                $query = mysqli_query($conn,"SELECT nilai as sub, id_kriteria_kedua as id_kriteria FROM tbl_analisa_kriteria WHERE
                id_kriteria_pertama='$kode' ORDER BY id_analisa");
                while ($b=mysqli_fetch_array($query)) {
                    $nilai_sub = $b['sub'];
                    $query1 = mysqli_query($conn,"SELECT bobot_kriteria FROM tbl_kriteria WHERE id_kriteria='$b[id_kriteria]'");
                    $c=mysqli_fetch_array ($query1);
                    $bobot_k = $c['bobot_kriteria'];
                    $matriks = $nilai_sub * $bobot_k;
                    $sum_matriks += $matriks;
                }

                 //ambil nilai matriks
                 mysqli_query($conn,"UPDATE tbl_kriteria set matriks_kriteria='$sum_matriks' WHERE id_kriteria='$a[id_kriteria]'");

            }?>

            <h4>Cek Konsistensi Kriteria</h4>
            <div style="border: 1px solid black; padding: 10px">
                <h4>
                    Nilai Eigen Maksimum <br>
                    <?php
                    $data = mysqli_query($conn,"SELECT * FROM tbl_kriteria ORDER BY id_kriteria");
                    $eigen_max = 0;
                    while ($a=mysqli_fetch_array($data)) {
                    $n = mysqli_num_rows($data);
                    $bobot_kriteria = $a['bobot_kriteria'];
                    $matriks_kriteria = $a['matriks_kriteria'];
                    $eigen = $matriks_kriteria / $bobot_kriteria;
                    $eigen_max += $eigen;
                    $avg_eigen_max = $eigen_max/$n;

                    echo"(".round($matriks_kriteria,3)." / ".round($bobot_kriteria,3).")";
                    }

                    $n_ci= ($avg_eigen_max-$n) / ($n-1);
                    //cek nilai ri
                    if ($n==2) {
                        $ri=0;
                    } elseif ($n==3) {
                        $ri=0.58;
                    } elseif ($n==4) {
                        $ri=0.9 ;
                    } elseif ($n==5) {
                        $ri=1.12;
                    }

                    $n_ri = $n_ci / $ri;

                    if ($n_ri <= 0.1) {
                        $konsistensi = "konsisten";
                    } else{
                        $konsistensi = "tidak konsisten";
                    }
                    ?>

                    = <?= round($avg_eigen_max,3) ?> <br><br>
                    Nilai Consistensi Index (CI): <br>
                    (<?= round($avg_eigen_max,3) ?> - <?= $n ?>) / (<?= $n ?> - 1) = <?= round($n_ci,3) ?> <br><br>
                    Consistensi Rasio (CR): <br>
                    <?= round($n_ci,3) ?> / <?= round($ri,3) ?> = <?= round($n_ri,3) ?> = <b><= 0.1 (<?= $konsistensi ?>)</b>

                </h4>
            </div>


            </div>
        </div>
    </div>
</div>
