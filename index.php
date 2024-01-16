<?php session_start();
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Clear Skin All Day Home</title>
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" /> <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
  <!-- MDB -->
  <link rel="stylesheet" href="css/mdb.min.css" />
  <!-- Custom styles -->
  <link rel="stylesheet" href="css/style.css" />
  <!-- Material Icons3 -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@40,400,0,0" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <!-- MDB -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.css" rel="stylesheet" />
  <script src="promotion.js"></script>
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
    <!-- Navbar -->
    <!-- carousel -->

    <?php

    // Connect to the MySQL database
    $db = new PDO('mysql:host=localhost;dbname=seesad', 'root', '');

    $query = $db->query('CREATE DATABASE IF NOT EXISTS seesad');
    $query = $db->query('CREATE TABLE IF NOT EXISTS promotions (
      id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      name TEXT NOT NULL,
      original_price INT,
      sale_price INT,
      start_date DATE,
      end_date DATE,
      details TEXT,
      img_filepath TEXT
    )');

    //sample carousel data
    $query = $db->query('INSERT IGNORE INTO promotions (id, name, original_price, sale_price, start_date, end_date, details, img_filepath) VALUES ("1", "Biore UV Aqua Rich Aqua Protect Mist SPF50 PA++++", "16", "16", "0000-00-00", "2023-10-10", "Biore\'s unique Aqua Protect Mist Technology", "img/carousel_pmnt1.jpg")');
    $query = $db->query('INSERT IGNORE INTO promotions (id, name, original_price, sale_price, start_date, end_date, details, img_filepath) VALUES ("2", "Biore UV Perfect Milk SPF50+ PA++++", "0", "12", "0000-00-00", "2023-10-10", "Lasting powdery smooth finish
    + Smooth Skin Feel", "img/carousel_pmnt2.jpg")');
    $query = $db->query('INSERT IGNORE INTO promotions (id, name, original_price, sale_price, start_date, end_date, details, img_filepath) VALUES ("3", "Biore UV Anti-Pollution Body Care Serum SPF 50+ PA+++ (Intensive Aura)", "16", "9", "0000-00-00", "2023-10-10", "Anti-pollution body lotion with high UV protection", "img/carousel_pmnt3.jpg")');


    //add admin acc


    // Fetch the promotions
    $query = $db->query('SELECT * FROM promotions');
    $promotions = $query->fetchAll();
    $active = true;
    // Generate the HTML code for the carousel

    echo '<!-- Carousel wrapper -->
  <div id="carouselBasicExample" class="carousel slide carousel-fade carousel-dark" data-mdb-ride="carousel">
  <!-- Indicators -->
  <div class="carousel-indicators">';
    foreach ($promotions as $index => $promotion) {
      echo '
    <button
      type="button"
      data-mdb-target="#carouselBasicExample"
      data-mdb-slide-to="' . ($index) . '"
      class="active"
      aria-current="true"
      aria-label="Slide ' . ($index + 1) . '"
    ></button> ';
    }
    echo '
  </div>
  
  <!-- Inner -->
  <div class="carousel-inner">';
    foreach ($promotions as $index => $promotion) {

      echo '  <!-- Single item -->
      <div class="carousel-item active">
        <img src="' . $promotion['img_filepath'] . '" class="d-block w-100" alt="' . $promotion['name'] . '"/>
        <div class="mask" style="background-color: rgba(0, 0, 0, 0.2);">
                          <div class="carousel-caption">
                              <div class="text-white text-center">
                               <div class="row">
                                <div class="col">
                                </div>
                                 <div class="col">
                                 <h1 class="mb-2">' . $promotion['name'] . '</h1>
                                 <h2 class="mb-2">Sale price: $' . $promotion['sale_price'] . '</h2>
                                 <p class="mb-2">Promotion ends on ' . $promotion['end_date'] . '</p>
                                 </div>
                                <div class="col">
                                </div>
                              </div>                            
                              </div>
                          </div>
                      </div>
  
      </div>';
    }

    ?>

    <!-- Inner -->

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide="next">
      <span class="carousel-control-next-icon"></span>
      <span class="visually-hidden">Next</span>
    </button>
    </div>

    <!-- Carousel wrapper -->


    <!--end carousel -->
  </header>
  <!--Main Navigation-->

  <!--Main layout-->
  <main class="mt-5">
    <div class="container">
      <!--Section: Content-->
      <section class="text-center">
      <h6 class="my-5 display-6 fw-bold ls-tight" style="color: #2980B9">
            Featured
            <span style="color: #6DD5FA">products</span>
          </h6>


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

        
          $sql = 'SELECT * FROM products LIMIT 3';
        
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
            echo ' </p>
                <div class="row mb-3">
                    <h5 class="card-text">$'.$row['product_price'].'</h5>
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
      <!-- Modal -->
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
            <a href="login.php" class="btn btn-primary">Sign in</a>
          </div>
        </div>
      </div>
    </div>




<!--
        <div class="row">
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card text-body mb-3" style="height:600px">
              <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                <img src="img/featured_pmnt1.jpg" class="card-img-top" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                </a>
              </div>
              <div class="card-body">
                <h5 class="card-title">Biore UV Aqua Rich Aqua Protect Mist SPF50 PA++++</h5>
                <p class="card-text">
                  Features Biore's unique Aqua Protect Mist Technology
                </p>
                <div class="row">
                  <div class="col">
                    <p class="card-text"><small class="text-muted">Price: $15.99</small></p>
                  </div>

                  <div class="col">
                    <a href="#!" class="btn btn-primary">Shop</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card text-body mb-3" style="height:600px">
              <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                <img src="img/featured_pmnt1.jpg" class="card-img-top" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                </a>
              </div>
              <div class="card-body">
                <h5 class="card-title">Biore UV Aqua Rich Aqua Protect Mist SPF50 PA++++</h5>
                <p class="card-text">
                  Features Biore's unique Aqua Protect Mist Technology
                </p>
                <div class="row">
                  <div class="col">
                    <p class="card-text"><small class="text-muted">Price: $15.99</small></p>
                  </div>

                  <div class="col">
                    <a href="#!" class="btn btn-primary">Shop</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card text-body mb-3" style="height:600px">
              <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">
                <img src="img/featured_pmnt1.jpg" class="card-img-top" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                </a>
              </div>
              <div class="card-body">
                <h5 class="card-title">Biore UV Aqua Rich Aqua Protect Mist SPF50 PA++++</h5>
                <p class="card-text">
                  Features Biore's unique Aqua Protect Mist Technology
                </p>
                <div class="row">
                  <div class="col">
                    <p class="card-text"><small class="text-muted">Price: $15.99</small></p>
                  </div>

                  <div class="col">
                    <a href="#!" class="btn btn-primary">Shop</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
      
        </div>-->
      </section>
      <!--Section: Content-->


      <hr class="my-5" />

      <!--Section: Content-->
      <section>
        <div class="row">
          <div class="col-md-6 gx-5 mb-4">
            <div class="bg-image hover-overlay ripple shadow-2-strong rounded-5" data-mdb-ripple-color="light">
              <img src="img/csad_logo_korean_big.png" class="img-fluid" />
              <a href="#!">
                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
              </a>
            </div>
          </div>

          <div class="col-md-6 gx-5 mb-4">
          <h6 class=" display-6 fw-bold ls-tight" style="color: #2980B9">
            About
            <span style="color: #6DD5FA">Us</span>
          </h6>            <p class="text-muted">
              Seesad is an online shop dedicated to providing high-quality, natural face wash products that are gentle on the skin. We believe that everyone deserves to have clear, healthy skin, and we are committed to providing our customers with the best possible products to help them achieve their skin care goals.
            </p>
            <p><strong>Why choose us?</strong></p>
            <p class="text-muted">
              We offer a variety of different face wash products to suit different skin types.

              In addition to our high-quality products, we also offer excellent customer service. We are always available to answer your questions and help you find the right product for your skin.

              We believe that Seesad is the best place to buy face wash online. We offer a wide variety of products, excellent customer service, and competitive prices.

              Thank you for choosing Seesad!
            </p>
            <p><strong>For more details, go to our <a href="about.php">About Us</a> page.</strong></p>
          </div>
        </div>
      </section>
      <!--Section: Content-->

      <hr class="my-5" />

      <!--Section: Content-->
      <section class="mb-5">
      <h6 class="my-5 display-6 fw-bold ls-tight text-center" style="color: #2980B9">
            An intro
            <span style="color: #6DD5FA">to our store</span>
          </h6>
        <div class="row d-flex justify-content-center">
          <div class="col-md-6">
            <div class="ratio ratio-16x9">
              <iframe src="https://www.youtube.com/embed/0VPDIfMmdW8" title="YouTube video" allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </section>
      <!--Section: Content-->


    </div>


    </div>
    </div>

  </main>
  <!--Main layout-->
  <div id="footer-home">

  </div>
  <script>
    $(function() {
      $("#footer-home").load("footer.php");
    });
  </script>

  <!-- MDB -->
  <script type="text/javascript" src="js/mdb.min.js"></script>
  <!-- Custom scripts -->
  <script type="text/javascript" src="js/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

</body>

</html>