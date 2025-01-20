<?php
include "../assets/conn/config.php";
if (isset($_GET['aksi'])) {
    if ($_GET['aksi']=='simpan') {
        $id_kriteria = $_POST['id_kriteria'];
        $id_alternatif_pertama = $_POST['id_alternatif_pertama'];
        $nilai = $_POST['nilai'];
        $id_alternatif_kedua = $_POST['id_alternatif_kedua'];

         //tambah data id_kriteria
        //cek nilai
        $data = mysqli_query($conn,"SELECT * FROM tbl_analisa_alternatif WHERE id_alternatif_pertama='$id_alternatif_kedua'
        AND id_alternatif_kedua='$id_alternatif_pertama' AND id_kriteria='$id_kriteria'"); 
        $a = mysqli_fetch_array($data);
        $nilai_pembagian = $a['nilai'];
  
        if (empty($nilai_pembagian)) {
            if ($id_alternatif_pertama==$id_alternatif_kedua) {
                $nilai_baru = 1;
            } else {
                $nilai_baru = $nilai;
            } 
        } else {
            $nilai_baru = 1/$nilai_pembagian;
        }

        //tambah data id_kriteria
        //cek data
        $da = mysqli_query($conn,"SELECT * FROM tbl_analisa_alternatif WHERE id_alternatif_pertama='$id_alternatif_pertama'
        AND id_alternatif_kedua='$id_alternatif_kedua' AND id_kriteria='$id_kriteria'");
        $aa = mysqli_num_rows($da);
        if ($aa>0) {
            header("location:analisa-alternatif.php?id_kriteria=$_POST[id_kriteria]&pesan=gagal");
        } else{
            mysqli_query($conn,"INSERT INTO tbl_analisa_alternatif(id_kriteria,id_alternatif_pertama,nilai,id_alternatif_kedua)VALUES('$id_kriteria','$id_alternatif_pertama',
            '$nilai_baru','$id_alternatif_kedua')");
            header("location:analisa-alternatif.php?id_kriteria=$_POST[id_kriteria]");
        }
    } elseif ($_GET['aksi']=='resetdata') {
        $id_kriteria = $_GET['id_kriteria'];
        mysqli_query($conn,"TRUNCATE TABLE tbl_analisa_alternatif");
        mysqli_query($conn,"TRUNCATE TABLE tbl_analisa_alternatif_act");
        header("location:analisa-alternatif.php");
    }
}
include"header.php";
?>

<h2 class="mb-4">PERBANDINGAN ALTERNATIF</h2>
<hr>
        <div class="shadow p-5">
            <a onclick="if(confirm('Data akan terhapus secara menyeluruh !!!')){ location.href='analisa-alternatif.php?aksi=resetdata'}" 
            class="btn btn-danger text-light">Reset Data Alternatif</a>
            <hr>

            <?php
            if (isset($_GET['pesan'])) {
              if ($_GET['pesan']=='gagal') {
                echo "<div class='alert alert-danger' role='alert'><span class='fa fa-times'></span> Data Gagal Disimpan </div>";
              }
            }
            ?>

            <form action="" method="get">
                <div class="row">
                    <div class="col-xs-12 col-md-3">
                        <div class="form-group">
                            <p style="padding:10px 0;"><label>Pilih Kriteria</label></p>
                        </div>
                    </div>
                </div>

               
                    <div class="form-group">
                        <select class="input form-control" name="id_kriteria" type="submit" onchange="this.form.submit()">
                            <?php
                            $a = mysqli_query($conn,"SELECT * FROM tbl_kriteria WHERE id_kriteria='$_GET[id_kriteria]'"); 
                            $aa = mysqli_fetch_array($a);?>
                            <option selected disabled><?php echo $aa['nama_kriteria'] ?></option>
                            <?php
                            $b = mysqli_query($conn,"SELECT * FROM tbl_kriteria ORDER BY id_kriteria"); 
                            while ($bb = mysqli_fetch_array($b)) {?>
                                    <option value="<?php echo $bb['id_kriteria'] ?>"><?php echo $bb['nama_kriteria'] ?></option>

                                <?php } ?>
                        </select>
                    </div>
               
            </form>
            <br>

            <h4>Perbandingan Antara Alternatif</h4>
            <i style="color:red;">*catatan : untuk melakukan perbandingan silahkan lakukan dari kiri ke kanan secara berurutan untuk
            mendapatkan hasil yang maksimal</i>
            <table class="table table-bordered">
                <tr>
                    <th class="text-center">Alternatif</th>
                    <?php
                    $data = mysqli_query($conn,"SELECT * FROM tbl_alternatif ORDER BY id_alternatif");
                    while ($a=mysqli_fetch_array($data)) {
                        echo "<th class='text-center'>$a[nama_alternatif]</th>";
                    } 
                    ?>
                </tr>

                <?php
                $query = mysqli_query($conn,"SELECT * FROM tbl_alternatif ORDER BY id_alternatif");
                while ($a=mysqli_fetch_array($query)) {
                    $kode = $a['id_alternatif'];
                    $nama = $a['nama_alternatif'];
                    echo "
                        <tr>
                        <td>$nama</td>
                    ";

                 $data = mysqli_query($conn,"SELECT * FROM tbl_alternatif ORDER BY id_alternatif");
                 while ($b=mysqli_fetch_array($data)) {
                    $id_alternatif=$b['id_alternatif']; ?>

                    <td class="text-center">
                        <form action="analisa-alternatif.php?aksi=simpan" method="post">
                        <input type="hidden" name="id_kriteria" value="<?php echo $_GET['id_kriteria'] ?>">
                            <input type="hidden" name="id_alternatif_kedua" value="<?php echo $id_alternatif ?>">
                            <input type="hidden" name="id_alternatif_pertama" value="<?php echo $kode ?>">

                            <select name="nilai" class="form-control" type="submit" onchange="this.form.submit()">
                                <option>pilih nilai</option>
                                <?php
                                $nilai = mysqli_query($conn, "SELECT * FROM tbl_nilai ORDER BY id_nilai");
                                while ($n=mysqli_fetch_array($nilai)) {
                                    echo "<option value='$n[nilai]'>$n[nilai] - ($n[ket])</option>"; 
                                }
                                ?>    
                            </select>
                        </form>
                    </td>
                 
                <?php } echo "</tr>"; }  ?>

            </table>
            <br>

            <h4>Hasil Perbandingan Alternatif</h4>  
            <table class="table table-bordered">
                 <tr>
                    <th class="text-center">Alternatif</th>
                    <?php
                    $data = mysqli_query($conn,"SELECT * FROM tbl_alternatif ORDER BY id_alternatif");
                    while ($a=mysqli_fetch_array($data)) {
                        echo "<th class='text-center'>$a[nama_alternatif]</th>";
                    } 
                    ?>
                </tr>

                    <?php
                    $data = mysqli_query($conn,"SELECT * FROM tbl_alternatif ORDER BY id_alternatif");
                    while ($a=mysqli_fetch_array($data)) {
                        $kode = $a['id_alternatif'];
                        $nama = $a['nama_alternatif'];
                        echo "
                            <tr>
                            <td>$nama</td>
                        ";

                        //untuk menampilkan nilai yang telah dipilih
                        $query = mysqli_query($conn,"SELECT nilai as sub FROM tbl_analisa_alternatif WHERE id_alternatif_pertama='$kode' and id_kriteria='$_GET[id_kriteria]' ORDER BY id_analisa");
                        while ($q=mysqli_fetch_array($query)) {
                            echo "<td class='text-center'>".round($q['sub'],2)."</td>";
                        }
                        ?>
                </tr>
                <?php } ?>

                <tr>
                    <td colspan="1"><b>Jumlah</b></td>
                    <?php
                    $data = mysqli_query($conn,"SELECT * FROM tbl_alternatif ORDER BY id_alternatif");
                    while ($a=mysqli_fetch_array($data)) {
                     
                        $query = mysqli_query($conn,"SELECT sum(nilai) as sum_nilai FROM tbl_analisa_alternatif WHERE id_alternatif_kedua='$a[id_alternatif]' 
                        and id_kriteria='$_GET[id_kriteria]'");
                        while ($q=mysqli_fetch_array($query)) {
                            $sum_nilai = $q['sum_nilai'];

                           //cek data alternatif
                            $dt = mysqli_query($conn,"SELECT * FROM tbl_analisa_alternatif_act WHERE id_alternatif='$a[id_alternatif]' AND id_kriteria='$_GET[id_kriteria]'");
                            $row = mysqli_num_rows($dt);

                            if (empty($_GET['id_kriteria'])) {
                                
                            }else{
                                if ($row>0) {
                                    mysqli_query($conn,"UPDATE tbl_analisa_alternatif_act set total_alternatif='$sum_nilai' WHERE id_alternatif='$a[id_alternatif]' AND id_kriteria='$_GET[id_kriteria]'");
                                } else{
                                mysqli_query($conn,"INSERT INTO  tbl_analisa_alternatif_act(id_kriteria,id_alternatif,total_alternatif)VALUES('$_GET[id_kriteria]','$a[id_alternatif]','$sum_nilai')");
                                }
                            }

                            echo "
                                <td class='text-center'><b>".round($sum_nilai,2)."</b></td>
                            ";

                        }
                        ?>
                <?php } ?>

                </tr>        

            </table>
            <br>
            
            <h4>Normalisasi Perbandingan Alternatif</h4>  
            <table class="table table-bordered">
                 <tr>
                    <th class="text-center">Alternatif</th>
                    <?php
                    $data = mysqli_query($conn,"SELECT * FROM tbl_alternatif ORDER BY id_alternatif");
                    while ($a=mysqli_fetch_array($data)) {
                        echo "<th class='text-center'>$a[nama_alternatif]</th>";
                    } 
                    ?>
                    <th class="text-center">Rata-Rata</th>
                </tr>

                    <?php
                    $data = mysqli_query($conn,"SELECT * FROM tbl_alternatif ORDER BY id_alternatif");
                    while ($a=mysqli_fetch_array($data)) {
                        $n = mysqli_num_rows($data); 
                        $sum_nm=0.0;
                        $kode = $a['id_alternatif'];
                        $nama = $a['nama_alternatif'];
                        echo "
                            <tr>
                            <td>$nama</td>
                        ";

                        //untuk menampilkan nilai 
                        $query = mysqli_query($conn,"SELECT nilai as sub, id_alternatif_kedua as id_alternatif FROM tbl_analisa_alternatif WHERE id_alternatif_pertama='$kode' AND id_kriteria='$_GET[id_kriteria]' ORDER BY id_analisa");
                        while ($q=mysqli_fetch_array($query)) {  
                            $nilai_sub = $q['sub'];

                            //panggil nilai total alternatif
                            $dat = mysqli_query($conn,"SELECT total_alternatif FROM tbl_analisa_alternatif_act WHERE id_alternatif='$q[id_alternatif]' AND id_kriteria='$_GET[id_kriteria]'");
                            $b=mysqli_fetch_array($dat);
                            $bobot_t = $b['total_alternatif'];
                            $normalisasi = $nilai_sub / $bobot_t;
                            echo "<td class='text-center'>".round($normalisasi,2)."</td>";

                            $sum_nm += $normalisasi;
                            $avg_sum = $sum_nm/$n;
                        }
                        echo "<td class='text-center'>".round($avg_sum,2)."</td>";
                         //ambil nilai rata-rata (nilai rata2 dijadikan untuk nilai bobot)
                         mysqli_query($conn,"UPDATE tbl_analisa_alternatif_act set bobot_alternatif='$avg_sum' 
                         WHERE id_alternatif='$a[id_alternatif]'and id_kriteria='$_GET[id_kriteria]'");
                        ?>
                </tr>
                <?php } ?>

                <tr>
                    <td colspan="1"><b>Jumlah</b></td>
                    <?php
                    $data = mysqli_query($conn,"SELECT * FROM tbl_alternatif ORDER BY id_alternatif");
                    $count = mysqli_num_rows($data) + 1;
                    
                     
                        $query = mysqli_query($conn,"SELECT sum(bobot_alternatif) as sum_bobot FROM tbl_analisa_alternatif_act WHERE id_kriteria='$_GET[id_kriteria]'");
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
            $data = mysqli_query($conn,"SELECT * FROM tbl_alternatif ORDER BY id_alternatif");
            while ($a=mysqli_fetch_array($data)) {
               
                $sum_matriks=0.0;
                $kode = $a['id_alternatif'];
                
                $query = mysqli_query($conn,"SELECT nilai as sub, id_alternatif_kedua as id_alternatif FROM tbl_analisa_alternatif WHERE
                id_alternatif_pertama='$kode' AND id_kriteria='$_GET[id_kriteria]' ORDER BY id_analisa");
                while ($b=mysqli_fetch_array($query)) {
                    $nilai_sub = $b['sub'];
                    $query1 = mysqli_query($conn,"SELECT bobot_alternatif FROM tbl_analisa_alternatif_act WHERE id_alternatif='$b[id_alternatif]' AND id_kriteria='$_GET[id_kriteria]'");
                    $c=mysqli_fetch_array ($query1);
                    $bobot_k = $c['bobot_alternatif'];
                    $matriks = $nilai_sub * $bobot_k;
                    $sum_matriks += $matriks;
                }

                 //ambil nilai matriks
                 mysqli_query($conn,"UPDATE tbl_analisa_alternatif_act set matriks_alternatif='$sum_matriks' 
                 WHERE id_alternatif='$a[id_alternatif]'AND id_kriteria='$_GET[id_kriteria]'");

            }?>

            <h4>Cek Konsistensi Alternatif</h4>
            <div style="border: 1px solid black; padding: 10px">
                <h4>
                    Nilai Eigen Maksimum <br>
                    <?php
                    $data = mysqli_query($conn,"SELECT * FROM tbl_analisa_alternatif_act WHERE id_kriteria='$_GET[id_kriteria]'");
                    $eigen_max = 0;
                    while ($a=mysqli_fetch_array($data)) {
                    $n = mysqli_num_rows($data);
                    $bobot_alternatif = $a['bobot_alternatif'];
                    $matriks_alternatif = $a['matriks_alternatif'];
                    $eigen = $matriks_alternatif / $bobot_alternatif;
                    $eigen_max += $eigen;
                    $avg_eigen_max = $eigen_max/$n;

                    echo"(".round($matriks_alternatif,3)." / ".round($bobot_alternatif,3).")";
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
                    }elseif ($n == 6) {
                        $ri = 1.24;
                    } elseif ($n == 7) {
                        $ri = 1.32;
                    } elseif ($n == 8) {
                        $ri = 1.41;
                    } elseif ($n == 9) {
                        $ri = 1.45;
                    } elseif ($n == 10) {
                        $ri = 1.49;
                    }

                    //cek konsisten
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
