<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Clear Skin All Day Products</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
  <!-- MDB -->
  <link rel="stylesheet" href="css/mdb.min.css" />
  <!-- Custom styles -->
  <link rel="stylesheet" href="css/style.css" />
  <!-- Material Icons3 -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@40,400,0,0" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script src="promotion.js"></script>
  <link rel="icon" href="img/csad_icon.png" type="image/x-icon"/>



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




      /* Height for devices larger than 576px */
      @media (min-width: 992px) {
        #introCarousel {
          margin-top: -58.59px;
        }

        #introCarousel,
        .carousel-inner,
        .carousel-item,
        .carousel-item.active {
          height: 47vh;
        }
      }

      .navbar .nav-link {
        color: #fff !important;
      }
    </style>

    <!-- Navbar -->
    <div id="nav-products">

    </div>
    <script>
      $(function() {
        $("#nav-products").load("navbar.php");
      });
    </script>

  </header>
  <!--Main Navigation-->

  <!--Main layout-->
  <main class="mt-5">
    <div class="container">
      <section class="text-center">
        <?php 
          if (isset($_GET['search_products'])) {
            echo '<h6 class="my-5 display-6 fw-bold ls-tight" style="color: #2980B9">
            Products matching
            <span style="color: #6DD5FA"> ' . $_GET['search_products'] . '</span>
          </h6>';
          } else {
            echo '<h6 class="my-5 display-6 fw-bold ls-tight" style="color: #2980B9">
            Our
            <span style="color: #6DD5FA">products</span>
          </h6>';
          }

         ?>
      </section>

      <section class="text-center">
        <?php
        include 'addtocart.php';
        $db = new PDO('mysql:host=localhost;dbname=seesad', 'root', '');

        $query = $db->query('CREATE DATABASE IF NOT EXISTS seesad');
        $query = $db->query('CREATE TABLE IF NOT EXISTS products (
      id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      image_link TEXT,
      product_name TEXT,
      product_desc TEXT,
      product_price DATE,
      products_category TEXT
    )');

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "csad_projek_test";
        $dbname = "seesad";


        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_GET['search_products'])) {
          $sql = "SELECT id,image_link,product_name,product_desc,product_price FROM products WHERE product_name LIKE '%" . $_GET['search_products'] . "%'";
        } else {
          $sql = "SELECT id,image_link,product_name,product_desc,product_price FROM products";
        }
        $result = $conn->query($sql);
        echo '<div class="row">';
        if ($result->num_rows > 0) {
          for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $row = mysqli_fetch_assoc($result);
            /*echo '<div class="col-lg-4 col-md-12 mb-4">';
            echo '<div class="card">';
            echo '<div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">';
            echo '<img src= "img/' . $row['image_link'] . '"class = "img-fluid"/>';
            echo '<a href="#!">';
            echo '<div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>';
            echo '</a>';  
            echo '</div>';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $row['product_name'] . '</h5>';
            echo '<p class="card-text">';
            echo $row['product_desc'];
            echo '</p>';
            echo '<p class="card-text">';
            echo $row['product_price'];
            echo '</p>';
            if (isset($_COOKIE['id'])) {
              echo '<a href="products.php?addToCart=' . $row['id'] . '" class="btn btn-primary">Add to Cart</a>';
            } else {
              echo '<button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#PleaseLogin">Add to cart</button>
              ';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';*/
            //
            echo '<div class="col-lg-4 col-md-6 mb-4">';
            echo '<div class="card text-body mb-3" style="height:600px">';
            echo '<div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">';
            echo '<img src="' . $row['image_link'] . '" class="card-img-top" />';
            echo '<div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>';
            echo '</div>';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $row['product_name'] . '</h5>';
            echo '<p class="card-text">';
            echo $row['product_desc'];
            $formatted_price = number_format((float)$row['product_price'], 2, '.' . '');
            echo ' </p>
                <div class="row mb-3">
                    <h5 class="card-text">$'.$formatted_price.'</h5>
                </div>
                  <div class="row">';
                  if (isset($_COOKIE['id'])) {
                    echo '<a href="products.php?addToCart=' . $row['id'] . '" class="btn btn-primary btn-rounded ">Add to Cart</a>';
                  } else {
                    echo '<button type="button" class="btn btn-primary btn-rounded" data-mdb-toggle="modal" data-mdb-target="#PleaseLogin">Add to cart</button>
                    ';
                  } echo ' 
                </div>
              </div>
            </div>
          </div>';

          }
        } else {
          echo "No results found";
        }
        echo '</div>';
        mysqli_close($conn);

        ?>
      </section>
    </div>

    <!-- Modal  Login pls-->
    <div class="modal fade" id="PleaseLogin" tabindex="-1" aria-labelledby="feedback" aria-hidden="true" style="z-index: 10000000 !important;">
      <div class="modal-dialog mt-20">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Not Signed in!</h5>
            <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">Please sign in to add this item to cart</div>
          <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cancel</button>
            <a href="login.php" class="btn btn-primary">Sign in</a>          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Modal added to cart-->
  <div class="modal fade" id="addedToCart" tabindex="-1" aria-labelledby="feedback" aria-hidden="true" style="z-index: 10000000 !important;">
      <div class="modal-dialog mt-20">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Item Added</h5>
            <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">Item has been successfully added to cart</div>
          <div class="modal-footer">
            <a href="cart.php" class="btn btn-secondary">Go to Cart</a>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Modal add fail-->
  <div class="modal fade" id="addFail" tabindex="-1" aria-labelledby="feedback" aria-hidden="true" style="z-index: 10000000 !important;">
      <div class="modal-dialog mt-20">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Unsuccessful</h5>
            <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">Failed to add item to cart</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Ok</button>
          </div>
        </div>
      </div>
    </div>
  </main>
  <!--Main layout-->
  <div id="footer-products">

  </div>

  <script>
    $(function() {
      $("#footer-products").load("footer.php");
    });
  </script>

  <!-- MDB -->
  <script type="text/javascript" src="js/mdb.min.js"></script>
  <!-- Custom scripts -->
  <script type="text/javascript" src="js/script.js"></script>
</body>

</html>