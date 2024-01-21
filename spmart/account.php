<?php

session_start();

$db = new PDO('mysql:host=localhost;dbname=seesad', 'root', '');
$id = "";
$name = "";
$username = "";
$email = "";
$password = "";
$phone = "";
$address = "";
$img_filepath = "";
$created_at = "";


//get sign in or login info from POST and check if user exist and set cookie
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['password']) && !isset($_POST['image'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $query = $db->query('CREATE DATABASE IF NOT EXISTS seesad');
  $query = $db->query('CREATE TABLE IF NOT EXISTS users (
      id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      name TEXT NOT NULL,
      username TEXT,
      email TEXT UNIQUE NOT NULL,
      password TEXT,
      address TEXT,
      phone TEXT,
      img_filepath TEXT,
      created_at TEXT)
    ');

  //sample user data
  //$query = $db->query('INSERT IGNORE INTO users (id, name, username, email, password, address, phone, created_at) VALUES ("1","gyoza test 1","seesadtest1","sp_aviation@ichat.sp.edu.sg","1234", "535 Clementi Rd, Singapore 599489, #T18A307", "99999999", "' . date('Y-m-d') . '")');
  $query = $db->query('SELECT id, name, username, email FROM users WHERE email = "' . $_POST['email'] . '"');

  //check if user already exists
  if ($query->rowCount() == 0) {
    //add new user to database
    date_default_timezone_set('Asia/Kolkata');
    $date = date('d-m-y h:i:s');
    $query = $db->query('INSERT INTO users (name, username, email, password, address, phone, created_at, img_filepath) VALUES ("' . $_POST['name'] . '","' . $_POST['username'] . '","' . $email . '","' . $password . '","' . $_POST['address'] . '","' . $_POST['phone'] . '","' . $date . '","user-profile-icon/default.png")');
  }
  $cookie_name = "id";
  $query = $db->query('SELECT * FROM users WHERE email = "' . $_POST['email'] . '"');
  $result = $query->fetchAll();

  //set cookie session and local variables
  foreach ($result as $index => $user) {
    $_SESSION["userId"] = $user['id'];
    $_SESSION["userName"] = $user['name'];
    $_SESSION["userUserName"] = $user['username'];
    $_SESSION["userEmail"] = $user['email'];
    $id = $user['id'];
    $name = $user['name'];
    $username = $user['username'];
    $email = $user['email'];
    $phone = $user['phone'];
    $address = $user['address'];
    $img_filepath = $user['img_filepath'];
    $created_at = $user['created_at'];

    $cookie_value = $user['id'];
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day

  }
}



//get user details from cookie
if (isset($_COOKIE['id'])) {
  $query = $db->query('SELECT * FROM users WHERE id = "' . $_COOKIE['id'] . '"');
  $result = $query->fetchAll();
  foreach ($result as $index => $user) {
    $_SESSION["userId"] = $user['id'];
    $_SESSION["userName"] = $user['name'];
    $_SESSION["userUserName"] = $user['username'];
    $_SESSION["userEmail"] = $user['email'];
    $id = $user['id'];
    $name = $user['name'];
    $username = $user['username'];
    $email = $user['email'];
    $phone = $user['phone'];
    $address = $user['address'];
    $img_filepath = $user['img_filepath'];
    $created_at = $user['created_at'];
  }
}






?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
  <!-- MDB -->
  <link rel="stylesheet" href="css/mdb.min.css" />
  <!-- Custom styles -->
  <link rel="stylesheet" href="css/style.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="signout.js"></script>
  <title>Clear Skin All Day Account</title>
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
  <main>

    <section style="background-color: #eee;">
      <div class="container py-5">

        <h6 class="mb-3 display-6 fw-bold ls-tight text-center" style="color: #2980B9">
          My
          <span style="color: #6DD5FA">Account</span>
        </h6>

        <div class="row">
          <div class="col-lg-4">
            <div class="card mb-4 ">
              <div class="card-body text-center">
                <?php
                if ($img_filepath != "") {
                  echo '<img src="' . $img_filepath . '" alt="cookie" class="rounded-circle img-fluid" style="width: 94px; height: 94px">';
                } else {
                  echo '<img src="https://subwayisfresh.com.sg/wp-content/uploads/2022/02/Sides-Double-Chocolate-Cookie.jpg" alt="cookie" class="rounded-circle img-fluid" style="width: 94px; height: 94px"">';
                }

                ?>
                <h5 class="my-3"><?php echo $name ?></h5>
                <p class="text-muted mb-1"><?php echo $username . "#" . $id ?></p>
                <p class="text-muted mb-4"><?php echo $email ?></p>
                <div class="d-flex justify-content-center mb-2">
                  <button type="button" class="btn btn-danger ms-2" data-mdb-toggle="modal" data-mdb-target="#signOutModal">Sign out</button>
                  <button type="button" class="btn btn-outline-danger" data-mdb-toggle="modal" data-mdb-target="#deleteModal">Delete account</button>
                </div>
                <div class="d-flex justify-content-center mb-2">
                  <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#editModal">Edit profile</button>
                </div>
              </div>
            </div>
          </div>
          <!-- EditModal -->
          <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true" style="z-index: 10000000 !important;">
            <div class="modal-dialog mt-20">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit profile</h5>
                  <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form method="post" class="needs-validation" novalidate enctype="multipart/form-data">
                    <!-- Name input -->
                    <div class="form-outline mb-4">
                      <input type="file" name="image" placeholder="Profile Picture" id="image" class="form-control">
                    </div>
                    <!-- Name input -->
                    <div class="form-outline mb-4">
                      <input type="text" id="registerName" class="form-control" name="name" required value="<?php echo $name ?>" />
                      <label class="form-label" for="registerName">Name</label>
                      <div class="invalid-feedback">Please enter your name</div>
                    </div>

                    <!-- Username input -->
                    <div class="input-group form-outline mb-4">
                      <span class="input-group-text" id="inputGroupPrepend">@</span>
                      <input type="text" id="registerUsername" class="form-control" name="username" required value="<?php echo $username ?>" />
                      <label class="form-label" for="registerUsername">Username</label>
                      <div class="invalid-feedback">Please enter a username</div>
                    </div>

                    <!-- Email input -->
                    <div class="form-outline mb-4">
                      <input type="email" id="registerEmail" class="form-control" name="email" required value="<?php echo $email ?>" />
                      <label class="form-label" for="registerEmail">Email</label>
                      <div class="invalid-feedback">Please enter a valid email</div>
                    </div>

                    <!-- Address input -->
                    <div class="form-outline mb-4">
                      <input type="text" id="registerEmail" class="form-control" name="address" value="<?php echo $address ?>" />
                      <label class="form-label" for="registerEmail">Address (for shipping)</label>
                      <div class="invalid-feedback">Please enter a valid address</div>
                    </div>

                    <!-- Phone input -->
                    <div class="form-outline mb-4">
                      <input type="number" id="registerEmail" class="form-control" name="phone" value="<?php echo $phone ?>" />
                      <label class="form-label" for="registerEmail">Mobile no.</label>
                      <div class="invalid-feedback">Please enter a valid phone number</div>
                    </div>



                    <!-- Submit button -->
                    <button type="submit" name="editAcc" class="btn btn-primary btn-block mb-3">Save details</button>

                  </form>
                  <script src="validateEdit.js"></script>


                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cancel</button>
                </div>
              </div>
            </div>
          </div>
          <!-- SignOutModal -->
          <div class="modal fade" id="signOutModal" tabindex="-1" aria-labelledby="signOutModal" aria-hidden="true" style="z-index: 10000000 !important;">
            <div class="modal-dialog mt-20">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">You are about to sign out</h5>
                  <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Are your sure you want to sign out?</div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-primary" onclick="accountSignOut()">Sign out</button>
                </div>
              </div>
            </div>
          </div>
          <?php
          if (array_key_exists('deleteAcc', $_GET)) {
            $db = new PDO('mysql:host=localhost;dbname=seesad', 'root', '');
            $query = $db->query('DELETE FROM orders_list WHERE user_id = "' . $_COOKIE['id'] . '"');
            $query = $db->query('DELETE FROM shopping_cart WHERE user_id = "' . $_COOKIE['id'] . '"');
            $query = $db->query('DELETE FROM reward_codes WHERE user_id = "' . $_COOKIE['id'] . '"');
            $query = $db->query('DELETE FROM users WHERE id = "' . $_COOKIE['id'] . '"');
            
            echo "<script>accountSignOut();</script>";
          }
          if (array_key_exists('editAcc', $_POST)) {
            $db = new PDO('mysql:host=localhost;dbname=seesad', 'root', '');

            if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
              $filename = $_FILES["image"]["name"];
              $tempname = $_FILES["image"]["tmp_name"];
              $img_filepath = "user-profile-icon/" . $filename;
              move_uploaded_file($tempname, $img_filepath);
              $query = $db->query('UPDATE users SET img_filepath = "' . $img_filepath . '" WHERE id = "' . $_COOKIE['id'] . '"');
            }

            $query = $db->query('UPDATE users SET name = "' . $_POST['name'] . '", username = "' . $_POST['username'] . '", email = "' . $_POST['email'] . '", address = "' . $_POST['address'] . '", phone = "' . $_POST['phone'] . '" WHERE id = "' . $_COOKIE['id'] . '"');
            echo "<script>$(document).ready(function(){
              $('#editConfirmModal').modal('show');
              });</script>";
          }

          ?>
          <!-- EditConfirmModal -->
          <div class="modal fade" id="editConfirmModal" tabindex="-1" aria-labelledby="signOutModal" aria-hidden="true" style="z-index: 10000000 !important;">
            <div class="modal-dialog mt-20">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Profile edited succesfully</h5>
                  <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                  <form>
                    <button type="submit" class="btn btn-primary" onclick="editAccDone()">Ok</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- DeleteModal -->
          <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true" style="z-index: 10000000 !important;">
            <div class="modal-dialog mt-20">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">YOU ARE DELETING YOUR ACCOUNT</h5>
                  <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">ARE YOU SURE YOU WANT TO CONTINUE? THERE IS NO RECOVERY OF YOUR DATA (OR YOUR IMAGINARY PURCHASES!!!!)</div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">sry press wrong</button>
                  <form method="get">
                    <button type="submit" name="deleteAcc" class="btn btn-primary">DELETE ACCOUNT (NO REFUNDS)</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-8">
            <div class="card mb-4">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0">Full Name</p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0"><?php echo $name ?></p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0">Username</p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0"><?php echo $username ?></p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0">Email</p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0"><?php echo $email ?></p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0">Mobile</p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0"><?php echo $phone ?></p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0">Address</p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0"><?php echo $address ?></p>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0">Account creation date</p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0"><?php echo $created_at ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <h6 class="mt-2 mb-4 display-6 fw-bold ls-tight text-center" style="color: #2980B9">
              My
              <span style="color: #6DD5FA">Orders</span>
            </h6>
            <div class="card mb-4">
              <div class="card-body">
                <table class="table table-striped">
                  <tr>
                    <th>id</th>
                    <th>order id</th>
                    <th>product name</th>
                    <th>total price</th>
                    <th>quantitiy</th>
                    <th>shipping address</th>
                    <th>view order</th>
                  </tr>
                  <?php
                  if (!isset($_COOKIE['id'])) {
                    echo "<script>editAccDone();</script>";

                  }
                  $sql = "SELECT * FROM orders_list  WHERE user_id = '" . $_COOKIE['id'] . "'";
                  $result = $db->query($sql);
                  foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['order_id'] . "</td>";
                    echo "<td>" . $row['product_name'] . "</td>";
                    echo "<td>" . $row['product_price'] . "</td>";
                    echo "<td>" . $row['product_quantity'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td><button type='button' class='btn btn-primary' data-mdb-toggle='modal' data-mdb-target='#" . "order_" . $row['order_id'] . "'>View</button></td>";
                    echo "</tr>";
                  }
                  echo "</table>";

                  ?>
                  <?php
                  $sql = "SELECT * FROM orders_list  WHERE user_id = '" . $_COOKIE['id'] . "'";
                  $result = $db->query($sql);
                  foreach ($result as $row) {
                    echo "<div class='modal fade' id='order_" . $row['order_id'] . "' tabindex='-1' role='dialog' aria-labelledby='"
                      . "order" . $row['order_id'] . "' aria-hidden='true'>";
                    echo "<div class='modal-dialog modal-dialog-centered' role='document'>";
                    echo "<div class='modal-content'>";
                    echo "<div class='modal-header'>";
                    echo "<h5 class='modal-title' id='order_" . $row['order_id'] . "Title'>Order info #" . $row['order_id'] . "</h5>";
                    echo "<button type='button' class='btn-close' data-mdb-dismiss='modal' aria-label='Close'>";
                    echo "</button>";
                    echo "</div>";
                    echo "<div class='modal-body'>";

                    echo "<table class='table table-striped'>
                      <tr>
                      <th>id</th>
                      <th>product name</th>
                      <th>image</th>
                      <th>product desc</th>
                      <th>product price</th>
                      </tr>";

                    $sql1 = "SELECT * FROM products WHERE id = '" . $row['product_id'] . "'";
                    $result1 = $db->query($sql1);

                    foreach ($result1 as $row1) {
                      echo "<tr>";
                      echo "<td>" . $row1['id'] . "</td>";
                      echo "<td>" . $row1['product_name'] . "</td>";
                      echo "<td><img style='width:60px;height:60px' src='img/" . $row1['image_link'] . "'>" . "</td>";
                      echo "<td>" . $row1['product_desc'] . "</td>";
                      echo "<td>$" . $row1['product_price'] . "</td>";
                      echo "</tr>";
                    }
                    echo "</table>";

                    echo "</div>";
                    //content here
                    echo "<div class='modal-footer'>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                  }
                  ?>
              
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>
  <!--Main layout-->

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