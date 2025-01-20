<?php
error_reporting(0);
session_start();
include "../assets/conn/config.php";
include "../assets/conn/cek.php";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>SISTEM PENDUKUNG KEPUTUSAN</title>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <link
      href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900"
      rel="stylesheet"
    />

    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="stylesheet" href="../assets/css-sir/css/style.css" />
    <style>
      .input{
        border : 1px solid black;
      }
      .hr{
        border : 1px solid black;
        height : 1px;
        background-color : black;
        margin-bottom: 1rem 0;
        background-image : linear-gradient(to right, #000, #000, 50%, transparent, 50%);
      }
      /* .bg{
        background : ;
      } */
    </style>
  </head>
  <body class="bg"> 
    <div class = 'container'>
        <center>
            <h3>
                <b>HASIL LAPORAN ANALISA METODE AHP</b>
            </h3>
            <hr class='hr'>
        </center>
    
    <br> <br>

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
     
    <script src="../assets/css-sir/js/jquery.min.js"></script>
    <script src="../assets/css-sir/js/popper.js"></script>
    <script src="../assets/css-sir/js/bootstrap.min.js"></script>
    <script src="../assets/css-sir/js/main.js"></script>

    <script>
        window.print(); 
    </script>

  </body>
</html>
