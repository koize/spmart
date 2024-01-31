<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>SPmart My Orders</title>
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
  <main class="mt-5 mb-5">

    <div class="container px-1 py-2 px-md-5 text-center text-lg-start my-2">
      <div class="row gx-lg-5 align-items-center mb-5">


   
            <h6 class="mt-2 mb-4 display-6 fw-bold ls-tight text-center" style="color: #2980B9">
              My
              <span style="color: #6DD5FA">Orders</span>
            </h6>
            <div class="card mb-4">
              <div class="card-body">
                <table class="table table-striped">
                  <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Order Total</th>
                    <th>Total Quantity</th>
                    <th>Delivery Method</th>
                    <th>Shipping Address</th>
                    <th>View Order</th>
                  </tr>
                  <?php
                  $db = new PDO('mysql:host=mysql;dbname=spmart', 'root', '');
                  if (!isset($_COOKIE['id'])) {
                    echo "<script>editAccDone();</script>";
                  }
                  $sql = "SELECT * FROM orders_list  WHERE user_id = '" . $_COOKIE['id'] . "'";
                  $result = $db->query($sql);
                  foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['order_id'] . "</td>";
                    echo "<td>" . $row['order_date'] . "</td>";
                    echo "<td>" . $row['product_price'] . "</td>";
                    echo "<td>" . $row['product_quantity'] . "</td>";
                    echo "<td>" . $row['order_type'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td><button type='button' class='btn btn-secondary' data-mdb-toggle='modal' data-mdb-target='#" . "order_" . $row['order_id'] . "'>View</button></td>";
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
                      <th>Order Date</th>
                      <th>Order Total</th>
                      <th>Total Quantity</th>
                      <th>Products Ordered</th>
                      </tr>";

                    $sql1 = "SELECT * FROM orders_list WHERE order_id = '" . $row['order_id'] . "'";
                    $result1 = $db->query($sql1);

                    foreach ($result1 as $row1) {
                      echo "<tr>";
                      echo "<td>" . $row1['order_date'] . "</td>";
                      echo "<td>" . $row1['product_price'] . "</td>";
                      echo "<td>" . $row1['product_quantity'] . "</td>";
                      echo "<td>$" . $row1['product_name'] . "</td>";
                      echo "</tr>";

                    }
                    echo "</table>";
                    echo "<center><img class='mx-n5 mt-n3 mb-n5' src='".$row['qr_code']."'></center>"; 
                    $text = "Order#" . $row1['order_id'] ."/User#". $row1['user_id'] ."/OrderTotal:$" . $row1['product_price'] ."/OrderQuantity:" . $row1['product_quantity'] ."/OrderDate:" . $row1['order_date'] ."";
                    echo "$text"; 
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


  </main>

  <!--Main layout-->
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new PDO('mysql:host=mysql;dbname=spmart', 'root', '');
    $query = $db->query('CREATE TABLE IF NOT EXISTS feedback (
      id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      name TEXT NOT NULL,
      email TEXT NOT NULL,
      message TEXT NOT NULL,
      created_at TEXT)
    ');

    date_default_timezone_set('Asia/Kolkata');
    $date = date('d-m-y h:i:s');
    $query = $db->query('INSERT INTO feedback (name, email, message, created_at) VALUES ("' . $_POST['name'] . '","' . $_POST['email'] . '","' . $_POST['message'] . '","' . $date . '")');
    echo "<script type='text/javascript'>
    $(document).ready(function(){
    $('#feedbackModal').modal('show');
    });
    </script>";
  }


  ?>

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