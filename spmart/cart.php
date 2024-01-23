<!DOCTYPE html>
<html lang="en">
  <?php
  session_start();
  ?>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Clear Skin All Day Home</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
  <!-- MDB -->
  <link rel="stylesheet" href="css/mdb.min.css" />
  <!-- Custom styles -->
  <link rel="stylesheet" href="css/style.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <link rel="icon" href="img/csad_icon.png" type="image/x-icon" />
  <!-- MDB -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css" rel="stylesheet" />


</head>

<body>
  <!--Main Navigation-->
  <header>
    <style>
      /* Carousel styling */
      #introCarousel,
      .carousel-inner,
      .carousel-item,
      .carousel-item.active {
        height: 100vh;
      }

      .carousel-item:nth-child(1) {
        background-image: url('https://mdbootstrap.com/img/Photos/Others/images/76.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
      }

      .carousel-item:nth-child(2) {
        background-image: url('https://mdbootstrap.com/img/Photos/Others/images/77.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
      }

      .carousel-item:nth-child(3) {
        background-image: url('https://mdbootstrap.com/img/Photos/Others/images/78.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
      }

      /* Height for devices larger than 576px */
      @media (min-width: 992px) {
        #introCarousel {
          margin-top: -58.59px;
        }

        #introCarousel,
        .carousel-inner,
        .carousel-item,
        .carousel-item.active {
          height: 50vh;
        }
      }

      .navbar .nav-link {
        color: #fff !important;
      }
    </style>

    <!-- Navbar -->
    <div id="navbar-support">

    </div>

    <script>
      $(function() {
        $("#navbar-support").load("navbar.php");
      });
    </script>
    <!-- Navbar -->

    <!-- Carousel wrapper -->

    <!-- Carousel wrapper -->
  </header>
  <!--Main Navigation-->

  <!--Main layout-->
  <main class="mt-5 mx-5 px-5">
    <div class="container-fluid">
      <section>
        <h6 class="mb-5 display-6 fw-bold ls-tight" style="color: #2980B9">
          Shopping
          <span style="color: #6DD5FA">Cart</span>
        </h6>
      </section>
      <section>
        <div class="row">
          <div class="col-md-7 mb-5 gx-5 ">
            <div class="card">
              <?php
              $servername = "mysql";
              $username = "root";
              $password = "";
              $dbname = "csad_projek_test";
              $dbname = "spmart";


              $conn = new mysqli($servername, $username, $password, $dbname);
              $db = new PDO('mysql:host=mysql;dbname=spmart', 'root', '');
              $query = $db->query('CREATE DATABASE IF NOT EXISTS spmart');
              $query = $db->query('CREATE TABLE IF NOT EXISTS shopping_cart (
              id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              product_id INT,
              image_link TEXT,
              product_name TEXT ,
              product_price INT,
              product_quantity INT,
              user_address TEXT,
              user_id INT)
              ');
              $query = $db->query('CREATE TABLE IF NOT EXISTS orders_list (
              id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              product_id INT,
              product_name TEXT,
              product_price INT,
              product_quantity INT,
              order_id int,
              user_id int,
              address TEXT,
              order_date TEXT,
              order_type TEXT,
              qr_code TEXT)
              ');

              include 'checkout.php';

              if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
              }

              if (!isset($_COOKIE['id'])) {
                echo '<div class="card">';
                echo '<div class="row">';
                echo '<h3 style="text-align: center; padding: 20px 20px 20px 0px">Please login to view cart!</h3>';
                echo '</div>';
                echo '<p>';
                echo '<a href="login.php" style="margin: 20px 40% 20px 40%" class="btn btn-outline-info">Login now!</a>';
                echo '</p>';
                echo '</div>';
              } else {
                $checkIfEmpty = "SELECT CASE WHEN EXISTS(SELECT 1 FROM shopping_cart WHERE user_id =" . $_COOKIE['id'] . ") THEN 0 ELSE 1 END AS IsEmpty";
                $getIfEmpty = mysqli_query($dbb, $checkIfEmpty);
                $cartempty = $getIfEmpty->fetch_array()['IsEmpty'];
                if ($cartempty == 1) {
                  echo '<div class="card">';
                  echo '<div class="row">';
                  echo '<h3 style="text-align: center; padding: 20px 20px 20px 0px">Cart is empty!</h3>';
                  echo '</div>';
                  echo '<p>';
                  echo '<a href="products.php" style="margin: 20px 40% 20px 40%" class="btn btn-outline-info">Add products now!</a>';
                  echo '</p>';
                  echo '</div>';
                } else {
                  if (isset($_COOKIE['id'])) {
                    $query = $db->query('SELECT id, name, username, address FROM users WHERE id = "' . $_COOKIE['id'] . '"');
                    $result = $query->fetchAll();
                    foreach ($result as $index => $user) {
                      $user_id = $user['id'];
                    }
                  }
                  $sqlViewCart = "SELECT id,image_link,product_name,product_price,product_quantity FROM shopping_cart WHERE user_id = $user_id";
                  $result = $conn->query($sqlViewCart);
                }




                if (!empty($result)  && $cartempty == 0) {
                  for ($i = 0; $i < mysqli_num_rows($result); $i++) {
                    $row = mysqli_fetch_assoc($result);
                    $formatted_price = number_format((float)$row['product_price'], 2, '.' . '');
                    echo '<div class="row" style = "margin: 20px 10px 0px 10px; position:relative">';
                    echo '<div class="col-md-12 col-lg-3">';
                    echo '<img src="' . $row['image_link'] . '" class="img-fluid"/>';
                    echo '</div>';
                    echo '<div class="col-md-12 col-lg-7">';
                    echo '<div class=row>';
                    echo '<h5 style="margin: 10px 0px 0px -10px; font-weight: normal">' . $row['product_name'] . '<h5>';
                    echo '<div class=row style="margin-top: 60px; width:40%">';

                    echo '<div class="col-md-4" style="margin:auto">';
                    echo '<a href="cart.php?minusQuantity=' . $row['id'] . '" style="">';
                    echo '<img src="img/minusicon.png" alt="a"  height="30px">';
                    echo '</a>';
                    echo '</div>';

                    echo '<div class="col-md-4" style="margin: 0px 10px 0px 0px; padding:10px 0px 0px 10px ">';
                    echo '<h5 style="font-weight: normal;">' . $row['product_quantity'] . '<h5>';
                    echo '</div>';

                    echo '<div class="col-md-4" style="margin:7px 0px 0px -30px">';
                    echo '<a href="cart.php?addQuantity=' . $row['id'] . '" style="">';
                    echo '<img src="img/addicon.png" alt="a"  height="30px">';
                    echo '</a>';
                    echo '</div>';


                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="col-md-12 col-lg-2">';
                    echo '<div class=row>';
                    echo '<a href="cart.php?deleteItem=' . $row['id'] . '" style="margin-left:50px; margin-top:10px;">';
                    echo '<img src="img/delete_red.png" alt="a"  height="30px">';
                    //https://www.flaticon.com/free-icons/delete
                    echo '</a>';
                    echo '</div>';
                    echo '<div class=row style="postion:relative">';
                    echo '<span style="text-align: right; padding: 70px 20px 0px 0px; font-weight: bold";>$' . $formatted_price . '</span>';
                    echo '</div>';
                    echo '</div>';
                    echo '<hr class="hr hr-blurry" style="margin: 10px 0px 0px 0px">';
                    echo '</div>';
                  }
                }
              }

              ?>
              <!-- Each item -->

            </div>
          </div>

          <div class="col-md-5 gx-3 mb-4">
            <div class="card mx-auto my-0" style="margin-top: 20px; margin-bottom: 20px; font-weight: bold;">
              <div class="card-body">
                <h5 class="card-title">Select delivery method</h5>
                <!-- Pills navs -->
                <ul class="nav nav-pills nav-justified mb-3" id="ex2" role="tablist">
                  <li class="nav-item" role="presentation">
                    <a data-mdb-pill-init class="nav-link active" id="tab-pickup" data-mdb-toggle="pill" href="#pills-pickup" role="tab" aria-controls="pills-login" aria-selected="true">Self-Pickup</a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a data-mdb-pill-init class="nav-link" id="tab-delivery" data-mdb-toggle="pill" href="#pills-delivery" role="tab" aria-controls="pills-register" aria-selected="false">Home Delivery</a>
                  </li>
                </ul>
                <!-- Pills navs -->
                <div class="tab-content">
                  <div class="tab-pane fade" id="pills-delivery" role="tabpanel" aria-labelledby="tab-login">
                    <!-- Card start -->
                    <div class="row" style="margin: 20px 20px 0px 10px">
                      <div class="col-md-6">
                        Subtotal
                      </div>
                      <div class="col-md-6">
                        <?php

                        if (isset($_COOKIE['id'])) {
                          $query = $db->query('SELECT id, name, username, address FROM users WHERE id = "' . $_COOKIE['id'] . '"');
                          $result = $query->fetchAll();
                          foreach ($result as $index => $user) {
                            $user_id = $user['id'];
                          }
                          $sqlViewCart = "SELECT id,image_link,product_name,product_price,product_quantity FROM shopping_cart WHERE user_id = $user_id";
                          $result = $conn->query($sqlViewCart);
                          $subTotal = 0;

                          if ($result->num_rows > 0) {
                            for ($i = 0; $i < mysqli_num_rows($result); $i++) {
                              $row = mysqli_fetch_assoc($result);
                              $subTotal = $subTotal + $row['product_price'];
                            }
                          }
                          $formatted_subTotal = number_format((float)$subTotal, 2, '.' . '');

                          echo '<span style="padding-left:100px">$' . $formatted_subTotal . '</span>';
                        } else {
                        }


                        ?>
                      </div>
                    </div>
                    <hr class="hr" style="margin: 10px 0px 0px 0px">

                    <!--
                    <div class="row" style="margin: 20px 20px 0px 10px;">
                      <form method='POST' action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                        <div class="col-xs-2">
                          Promotion Code
                        </div>
                        <div class="col-xs-10 ">
                          <div class="row">
                            <div class="col-lg-10">
                              <input type="text" name="voucherET"  size="55"/>
                            </div>
                            <div class="col-lg-2">
                              <input type="submit" value="Add" class="btn btn-secondary" />
                            </div>
                          </div>
                        </div>
                      </form>


                      <?php
                      /*
                      $voucherMultiplier = 1;
                      $servername = "mysql";
                      $username = "root";
                      $password = "";
                      $dbname = "csad_projek_test";
                      $dbname = "spmart";

                      $conn = new mysqli($servername, $username, $password, $dbname);

                      if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                      }

                      $dbb = mysqli_connect('mysql', 'root', '', 'spmart');
                      if (!$dbb) {
                        die("Connection Failed: " . mysqli_connect_error());
                      }
                      $db = new PDO('mysql:host=mysql;dbname=spmart', 'root', '');


                      if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $voucher_code = $_POST['voucherET'];
                        $checkVoucher = "SELECT * FROM reward_codes WHERE discount_code = '$voucher_code'";
                        $voucherResult = $conn->query($checkVoucher);
                        if ($voucherResult !== false && $voucherResult->num_rows > 0) {
                          $voucherRow = mysqli_fetch_assoc($voucherResult);
                          $discount = $voucherRow['discount'];
                          if ($discount == 5) {
                            $voucherMultiplier = 0.95;
                          } else if ($discount == 10) {
                            $voucherMultiplier = 0.9;
                          } else if ($discount == 2) {
                            $voucherMultiplier = 0.98;
                          }
                        } else {
                          $voucherWrongWarning = true;
                        }
                      }
                      */
                      ?>
                    </div>
                    <hr class="hr" style="margin: 10px 0px 0px 0px">
                    -->
                    <div class="row" style="margin: 20px 20px 0px 10px">
                      <div class="col-md-6">
                        Delivery fee
                      </div>
                      <div class="col-md-6">
                        <span style="padding-left:100px">$4.00</span>
                      </div>
                    </div>
                    <hr class="hr" style="margin: 10px 0px 0px 0px">



                    <div class="card" style="margin-top:20px; margin-bottom:20px; background-color:lightblue">
                      <div class="row" style="margin: 15px 15px 15px 15px">
                        <div class="col-md-6">
                          <b>Total</b>
                        </div>
                        <div class="col-md-6">
                          <?php
                          if (isset($_COOKIE['id'])) {
                            $TOTAL = ($subTotal + 4);
                            $formatted_TOTAL = number_format((float)$TOTAL, 2, '.' . '');
                            $orderType = 'Delivery';
                            echo '<span style="padding-left:100px; font-weight: bold">$' . $formatted_TOTAL . '</span>';

                          }
                          ?>
                        </div>
                      </div>
                    </div>
                    <hr class="hr" style="margin: 10px 0px 0px 0px">
                    <?php
                    if (!isset($_COOKIE['id'])) {
                      echo '<div class="card my-4" style="width: 100%;">';
                      echo '<a class="btn btn-secondary stretched-link" style="padding: 20px"  disabled data-mdb-target="#noItems">';
                      echo '<span style="font-weight: bold; margin:auto; font-size: 20px">Please login to checkout</span>';
                      echo '</a>';
                      echo '</div>';
                    } else {
                      $checkIfEmpty = "SELECT CASE WHEN EXISTS(SELECT 1 FROM shopping_cart WHERE user_id =" . $_COOKIE['id'] . ") THEN 0 ELSE 1 END AS IsEmpty";
                      $getIfEmpty = mysqli_query($dbb, $checkIfEmpty);
                      $cartempty = $getIfEmpty->fetch_array()['IsEmpty'];

                      if ($cartempty == 1) {
                        echo '<div class="card my-4" style="width: 100%;">';
                        echo '<a class="btn btn-secondary stretched-link" style="padding: 20px" data-mdb-ripple-init data-mdb-modal-init disabled data-mdb-target="#noItems">';
                        echo '<span style="font-weight: bold; margin:auto; font-size: 20px">No items in cart</span>';
                        echo '</a>';
                        echo '</div>';
                      } else if ($orderType == 'Self-Pickup') {

                        echo '<div class="card my-4" style="width: 100%;">';
                        echo '<a href="cart.php?checkOutPickup" class="btn btn-secondary stretched-link" style="padding: 20px" data-mdb-toggle="modal" data-mdb-target="#CheckoutSuccess>';
                        echo '<span style="font-weight: bold; margin:auto; font-size: 20px" data-mdb-toggle="modal" data-mdb-target="#CheckoutSuccess">CHECKOUT</span>';
                        echo '</a>';
                        echo '</div>';
                      } else if ($orderType == 'Delivery') {

                        echo '<div class="card my-4" style="width: 100%;">';
                        echo '<a href="cart.php?checkOutDelivery" class="btn btn-secondary stretched-link" style="padding: 20px" data-mdb-toggle="modal" data-mdb-target="#CheckoutSuccess>';
                        echo '<span style="font-weight: bold; margin:auto; font-size: 20px" data-mdb-toggle="modal" data-mdb-target="#CheckoutSuccess">CHECKOUT</span>';
                        echo '</a>';
                        echo '</div>';
                      }
                    }

                    ?>
                  </div>
                  <div class="tab-pane fade show active" id="pills-pickup" role="tabpanel" aria-labelledby="tab-login">
                    <!-- Card start -->
                    <div class="row" style="margin: 20px 20px 0px 10px">
                      <div class="col-md-6">
                        Subtotal
                      </div>
                      <div class="col-md-6">
                        <?php

                        if (isset($_COOKIE['id'])) {
                          $query = $db->query('SELECT id, name, username, address FROM users WHERE id = "' . $_COOKIE['id'] . '"');
                          $result = $query->fetchAll();
                          foreach ($result as $index => $user) {
                            $user_id = $user['id'];
                          }
                          $sqlViewCart = "SELECT id,image_link,product_name,product_price,product_quantity FROM shopping_cart WHERE user_id = $user_id";
                          $result = $conn->query($sqlViewCart);
                          $subTotal = 0;

                          if ($result->num_rows > 0) {
                            for ($i = 0; $i < mysqli_num_rows($result); $i++) {
                              $row = mysqli_fetch_assoc($result);
                              $subTotal = $subTotal + $row['product_price'];
                            }
                          }
                          $formatted_subTotal = number_format((float)$subTotal, 2, '.' . '');

                          echo '<span style="padding-left:100px">$' . $formatted_subTotal . '</span>';
                        }

                        ?>
                      </div>
                    </div>
                    <hr class="hr" style="margin: 10px 0px 0px 0px">

                    <!--
                    <div class="row" style="margin: 20px 20px 0px 10px;">
                      <form method='POST' action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                        <div class="col-xs-2">
                          Promotion Code
                        </div>
                        <div class="col-xs-10 ">
                          <div class="row">
                            <div class="col-lg-10">
                              <input type="text" name="voucherET"  size="55"/>
                            </div>
                            <div class="col-lg-2">
                              <input type="submit" value="Add" class="btn btn-secondary" />
                            </div>
                          </div>
                        </div>
                      </form>


                      <?php
                      /*
                      $voucherMultiplier = 1;
                      $servername = "mysql";
                      $username = "root";
                      $password = "";
                      $dbname = "csad_projek_test";
                      $dbname = "spmart";

                      $conn = new mysqli($servername, $username, $password, $dbname);

                      if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                      }

                      $dbb = mysqli_connect('mysql', 'root', '', 'spmart');
                      if (!$dbb) {
                        die("Connection Failed: " . mysqli_connect_error());
                      }
                      $db = new PDO('mysql:host=mysql;dbname=spmart', 'root', '');


                      if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $voucher_code = $_POST['voucherET'];
                        $checkVoucher = "SELECT * FROM reward_codes WHERE discount_code = '$voucher_code'";
                        $voucherResult = $conn->query($checkVoucher);
                        if ($voucherResult !== false && $voucherResult->num_rows > 0) {
                          $voucherRow = mysqli_fetch_assoc($voucherResult);
                          $discount = $voucherRow['discount'];
                          if ($discount == 5) {
                            $voucherMultiplier = 0.95;
                          } else if ($discount == 10) {
                            $voucherMultiplier = 0.9;
                          } else if ($discount == 2) {
                            $voucherMultiplier = 0.98;
                          }
                        } else {
                          $voucherWrongWarning = true;
                        }
                      }
                      */
                      ?>
                    </div>
                    <hr class="hr" style="margin: 10px 0px 0px 0px">
                    -->



                    <div class="card" style="margin-top:20px; margin-bottom:20px; background-color:lightblue">
                      <div class="row" style="margin: 15px 15px 15px 15px">
                        <div class="col-md-6">
                          <b>Total</b>
                        </div>
                        <div class="col-md-6">
                          <?php
                          if (isset($_COOKIE['id'])) {
                            $TOTAL = ($subTotal);
                            $formatted_TOTAL = number_format((float)$TOTAL, 2, '.' . '');
                            echo '<span style="padding-left:100px; font-weight: bold">$' . $formatted_TOTAL . '</span>';
                            $orderType = 'Self-Pickup';
                          }

                          ?>
                        </div>
                      </div>
                    </div>
                    <hr class="hr" style="margin: 10px 0px 0px 0px">
                    <?php
                    if (!isset($_COOKIE['id'])) {
                      echo '<div class="card my-4" style="width: 100%;">';
                      echo '<a class="btn btn-secondary stretched-link" style="padding: 20px"  disabled data-mdb-target="#noItems">';
                      echo '<span style="font-weight: bold; margin:auto; font-size: 20px">Please login to checkout</span>';
                      echo '</a>';
                      echo '</div>';
                    } else {
                      $checkIfEmpty = "SELECT CASE WHEN EXISTS(SELECT 1 FROM shopping_cart WHERE user_id =" . $_COOKIE['id'] . ") THEN 0 ELSE 1 END AS IsEmpty";
                      $getIfEmpty = mysqli_query($dbb, $checkIfEmpty);
                      $cartempty = $getIfEmpty->fetch_array()['IsEmpty'];

                      if ($cartempty == 1) {
                        echo '<div class="card my-4" style="width: 100%;">';
                        echo '<a class="btn btn-secondary stretched-link" style="padding: 20px" data-mdb-ripple-init data-mdb-modal-init disabled data-mdb-target="#noItems">';
                        echo '<span style="font-weight: bold; margin:auto; font-size: 20px">No items in cart</span>';
                        echo '</a>';
                        echo '</div>';
                      } else if ($orderType == 'Self-Pickup') {

                        echo '<div class="card my-4" style="width: 100%;">';
                        echo '<a href="cart.php?checkOutPickup" class="btn btn-secondary stretched-link" style="padding: 20px" data-mdb-toggle="modal" data-mdb-target="#CheckoutSuccess>';
                        echo '<span style="font-weight: bold; margin:auto; font-size: 20px" data-mdb-toggle="modal" data-mdb-target="#CheckoutSuccess">CHECKOUT</span>';
                        echo '</a>';
                        echo '</div>';
                      } else if ($orderType == 'Delivery') {

                        echo '<div class="card my-4" style="width: 100%;">';
                        echo '<a href="cart.php?checkOutDelivery" class="btn btn-secondary stretched-link" style="padding: 20px" data-mdb-toggle="modal" data-mdb-target="#CheckoutSuccess>';
                        echo '<span style="font-weight: bold; margin:auto; font-size: 20px" data-mdb-toggle="modal" data-mdb-target="#CheckoutSuccess">CHECKOUT</span>';
                        echo '</a>';
                        echo '</div>';
                      }
                    }

                    ?>
                  </div>
                </div>
              </div>
              <!-- Card end -->
            </div>

          </div>
      </section>
    </div>
  </main>
  <!--Main layout-->
  <!-- Modal chekout -->
  <div class="modal fade" id="CheckoutSuccess" tabindex="-1" aria-labelledby="feedback" aria-hidden="true" style="z-index: 10000000 !important;">
    <div class="modal-dialog mt-20">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Payment Successful</h5>
          <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">We have received your payment and your order will be prepared shortly</div>
        <div class="modal-footer">
          <a href="myorders.php" class="btn btn-secondary" >Ok</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal noitem -->
  <div class="modal fade" id="noItems" tabindex="-1" aria-labelledby="feedback" aria-hidden="true" style="z-index: 10000000 !important;">
    <div class="modal-dialog mt-20">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Cart Empty</h5>
          <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">Your cart is empty! Add items before checking out</div>
        <div class="modal-footer">
          <a href="products.php"  class="btn btn-secondary" >Ok</a>
        </div>
      </div>
    </div>
  </div>
  <!--Footer-->
  <div id="footer-support">

  </div>

  <script>
    $(function() {
      $("#footer-support").load("footer.php");
    });
  </script>
  <!--Footeeeeeer-->
  <!-- MDB -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"></script>
  <!-- Custom scripts -->
  <script type="text/javascript" src="js/script.js"></script>

  <!-- MDB -->

</body>

</html>