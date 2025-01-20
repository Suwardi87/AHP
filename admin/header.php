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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >

    <link rel="stylesheet" href="../assets/css-sir/css/style.css" />
    <style>
      .input{
        border : 1px solid black;
      }
      .sub{
        background color:#0056b3;
      }
    </style>
  </head>
  <body style="background-color: #80B9AD">
    <div class="wrapper d-flex align-items-stretch">
      <nav id="sidebar" class="active" style="background-color: #538392">
        <div class="custom-menu">
          <button type="button" id="sidebarCollapse" class="btn btn-primary" style="background-color: #538392">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Toggle Menu</span>
          </button>
        </div>
        <div class="p-4">
          <h1><a href="index.php" class="logo">SPK AHP</a></h1>
          <ul class="list-unstyled components mb-5">
            <li class="active">
              <a href="index.php"><span class=" mr-3"></span> Home</a>
            </li>
            <li>
              <a href="nilai.php"><span class=" mr-3"></span>Nilai AHP</a>
            </li>
            <li>
              <a href="alternatif.php"
                ><span class=" mr-3"></span>Alternatif</a
              >
            </li>
            <li>
              <a href="kriteria.php"
                ><span class=" mr-3"></span>Kriteria</a
              >
            </li>
            <li>
              <a href="analisa-kriteria.php"
                ><span class="mr-3"></span>Perbandingan Kriteria</a
              >
            </li>
            <li>
              <a href="analisa-alternatif.php"><span class="mr-3"></span>Perbandingan Alternatif</a>
            </li>
            <li>
              <a href="analisa-metode.php"
                ><span class="mr-3"></span>Analisa Metode</a
              >
            </li>
            <li>
              <a href="laporan.php" target="blank"
                ><span class=" mr-3"></span>Laporan</a
              >
            </li>
            <li>
              <a href="logout.php"
                ><span class="mr-3"></span>Logout</a
              >
            </li>
          </ul>

          <div class="footer">
            
          </div>
        </div>
      </nav>

      <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5 pt-5">
        <div class = 'container'>
        
     
    <script src="../assets/css-sir/js/jquery.min.js"></script>
    <script src="../assets/css-sir/js/popper.js"></script>
    <script src="../assets/css-sir/js/bootstrap.min.js"></script>
    <script src="../assets/css-sir/js/main.js"></script>
  </body>
</html>
