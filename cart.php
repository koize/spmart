<!DOCTYPE html>
<html lang="en">

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
  <main class="mt-5">
    <div class="container">
      <section>
      <h6 class="mb-5 display-6 fw-bold ls-tight" style="color: #2980B9">
            Shopping
            <span style="color: #6DD5FA">Cart</span>
          </h6>         </section>
      <section>
        <div class="row">
          <div class="col-md-7 gx-5 mb-4">
            <div class="card">
              <?php
              $servername = "localhost";
              $username = "root";
              $password = "";
              $dbname = "csad_projek_test";
              $dbname = "seesad";


              $conn = new mysqli($servername, $username, $password, $dbname);
              $db = new PDO('mysql:host=localhost;dbname=seesad', 'root', '');
              $query = $db->query('CREATE DATABASE IF NOT EXISTS seesad');
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
              address TEXT)
              ');

              include 'checkout.php';

              if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
              }

              $checkIfEmpty = "SELECT CASE WHEN EXISTS(SELECT 1 FROM shopping_cart WHERE user_id =" . $_COOKIE['id'] .") THEN 0 ELSE 1 END AS IsEmpty";
              $getIfEmpty = mysqli_query($dbb, $checkIfEmpty);
              $cartempty = $getIfEmpty->fetch_array()['IsEmpty'];

              if ($cartempty == 1) {
                echo '<div class="card">';
                echo '<div class="row">';
                echo '<h4 style="text-align: center; padding: 25px 20px 20px 20px">Cart is empty</h4>';
                echo '</div>';
                echo '<p>';
                echo '<a href="products.php" style="margin: 0px 35% 10px 38%" class="btn btn-outline-info">Add products now!</a>';
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

                if ($result->num_rows > 0) {
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
          <div class="col-md-5 gx-5 mb-4">
            <div class="card" style="margin-bottom: 20px; font-weight: bold;">
              <!-- Card start -->
              <div class="row" style="margin: 20px 10px 0px 10px">
                <div class="col-md-6">
                  Sub Total:
                </div>
                <div class="col-md-6">
                  <?php

                  if (isset($_COOKIE['id'])) {
                    $query = $db->query('SELECT id, name, username, address FROM users WHERE id = "' . $_COOKIE['id'] . '"');
                    $result = $query->fetchAll();
                    foreach ($result as $index => $user) {
                      $user_id = $user['id'];
                    }
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
                  ?>
                </div>
              </div>
              <hr class="hr" style="margin: 10px 0px 0px 0px">

              <div class="row" style="margin: 20px 10px 0px 10px">
                <div class="col-md-6">
                  Voucher
                </div>

                <div class="col-md-6">
                  <form method='POST' action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
                    <input type="text" name="voucherET" />
                    <input type="submit" value="Add" class="btn">
                  </form>
                  <?php
                  $voucherMultiplier = 1;
                  $servername = "localhost";
                  $username = "root";
                  $password = "";
                  $dbname = "csad_projek_test";
                  $dbname = "seesad";

                  $conn = new mysqli($servername, $username, $password, $dbname);

                  if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                  }

                  $dbb = mysqli_connect('localhost', 'root', '', 'seesad');
                  if (!$dbb) {
                    die("Connection Failed: " . mysqli_connect_error());
                  }
                  $db = new PDO('mysql:host=localhost;dbname=seesad', 'root', '');


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

                  ?>
                </div>
              </div>
              <hr class="hr" style="margin: 10px 0px 0px 0px">

              <div class="row" style="margin: 20px 10px 0px 10px">
                <div class="col-md-6">
                  Delivery fee
                </div>
                <div class="col-md-6">
                  <span style="padding-left:100px">$5.00</span>
                </div>
              </div>
              <hr class="hr" style="margin: 10px 0px 0px 0px">

              <div class="row" style="margin: 20px 10px 0px 10px">
                <div class="col-md-6">
                  Service fee
                </div>
                <div class="col-md-6">
                  <span style="padding-left:100px">$3.69</span>
                </div>
              </div>
              <hr class="hr" style="margin: 10px 0px 0px 0px">

              <div class="card" style="margin:20px; background-color:lightgray">
                <div class="row" style="margin: 15px 15px 15px 15px">
                  <div class="col-md-6">
                    <b>Total</b>
                  </div>
                  <div class="col-md-6">
                    <?php
                    $TOTAL = ($subTotal + 5 + 3.69) * $voucherMultiplier;
                    $formatted_TOTAL = number_format((float)$TOTAL, 2, '.' . '');
                    echo '<span style="padding-left:100px; font-weight: bold">$' . $formatted_TOTAL . '</span>';
                    ?>
                  </div>
                </div>
              </div>
              <!-- Card end -->
            </div>
            <?php
            $checkIfEmpty = "SELECT CASE WHEN EXISTS(SELECT 1 FROM shopping_cart WHERE user_id =" . $_COOKIE['id'] .") THEN 0 ELSE 1 END AS IsEmpty";
            $getIfEmpty = mysqli_query($dbb, $checkIfEmpty);
            $cartempty = $getIfEmpty->fetch_array()['IsEmpty'];

            if ($cartempty == 1) {
              echo '<div class="card" style="width: 100%;">';
              echo '<a class="btn btn-secondary stretched-link" style="padding: 20px" data-mdb-toggle="modal" data-mdb-target="#noItems">';
              echo '<span style="font-weight: bold; margin:auto; font-size: 18px">No items in cart</span>';
              echo '</a>';
              echo '</div>';
            } else {
              echo '<div class="card" style="width: 100%;">';
              echo '<a href="cart.php?checkOut" class="btn btn-info stretched-link" style="padding: 20px" data-mdb-toggle="modal" data-mdb-target="#CheckoutSuccess>';
              echo '<span style="font-weight: bold; margin:auto; font-size: 18px" data-mdb-toggle="modal" data-mdb-target="#CheckoutSuccess">CHECKOUT $' . $formatted_TOTAL . '</span>';
              echo '</a>';
              echo '</div>';
            }
            ?>
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
          <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Ok</button>
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
          <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Ok</button>
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
  <script type="text/javascript" src="js/mdb.min.js"></script>
  <!-- Custom scripts -->
  <script type="text/javascript" src="js/script.js"></script>
</body>

</html>