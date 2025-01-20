<?php
session_start();
include "assets/conn/config.php";
if (isset($_GET['aksi'])) {
  if ($_GET['aksi']=='masuk') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $data = mysqli_query($conn,"SELECT * FROM tbl_akun WHERE username = '$username' AND password = '$password'");
    $row =  mysqli_num_rows($data);

    if ($row > 0) {
      $a = mysqli_fetch_array($data);
      if ($a['level']=='Admin') {
        $_SESSION['username'] = $username;
        header("location:admin/index.php");
      }
    } else {
      header("location:index.php?login=gagal ");
    }
  }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css-login/fonts/icomoon/style.css">

    <link rel="stylesheet" href="assets/css-login/css/owl.carousel.min.css">
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css-login/css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="assets/css-login/css/style.css">

    <title>SISTEM PENDUKUNG KEPUTUSAN</title>
  </head>
  <body ">
  

  
  <div class="content" style="background-color: #6295A2";>
    <div class="container">
      <div class="row">
        <div class="col-md-6 order-md-2">
          <!-- <img src="assets/im/Domino's Pizza.jpeg" alt="Image" class="img-fluid"> -->
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
              <h3><strong>Sign In </strong></h3>
              <p class="mb-4" style="color: black">Sistem Pendukung Keputusan dengan menerapkan metode AHP</p>
            </div>

            <?php
            if (isset($_GET['login'])) {
              if ($_GET['login']=='gagal') {
                echo "<div class='alert alert-danger' role='alert'><span class='fa fa-times'></span> Username / Password Salah </div>";
              }
            }
            ?>

            <form action="index.php?aksi=masuk" method="post">
              <div class="form-group first">
                <label for="username" >Username</label>
                <input type="text" class="form-control" id="username" name="username" required>

              </div>
              <div class="form-group last mb-4">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                
              </div>
              
              <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0" ><span class="caption">Remember me</span>
                  <input type="checkbox" checked="checked"/>
                  <div class="control__indicator" style="background-color: #80B9AD"></div>
                </label>
              </div>

              <input type="submit" value="Log In" class="btn text-white btn-block btn-primary" style="background-color: #80B9AD">

            </form>
            </div>
          </div>
          
        </div>
        
      </div>
    </div>
  </div>

  
    <script src="assets/css-login/js/jquery-3.3.1.min.js"></script>
    <script src="assets/css-login/js/popper.min.js"></script>
    <script src="assets/css-login/js/bootstrap.min.js"></script>
    <script src="assets/css-login/js/main.js"></script>
  </body>
</html>