<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Material Design for Bootstrap</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
    <!-- MDB -->
    <link rel="stylesheet" href="css/mdb.min.css" />
    <!-- Custom styles -->
    <link rel="stylesheet" href="css/style.css" />
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
      <nav class="navbar navbar-expand-lg navbar-dark d-none d-lg-block bg-dark" style="z-index: 2000;">
        <div class="container-fluid"> 
          <!-- Navbar brand -->
          <a class="navbar-brand nav-link" target="_blank" href="https://mdbootstrap.com/docs/standard/">
            <strong>MDB</strong> 
          </a>
          <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarExample01"
            aria-controls="navbarExample01" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
          </button>
          <div class="collapse navbar-collapse" id="navbarExample01">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item active">
                <a class="nav-link" href="index.php">Home</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" aria-current="page" rel="nofollow"
                  >Store</a> <!-- hyperlink to other pages -->
              </li>
              <li class="nav-item">
              <a class="nav-link" href="rewardsPage.php">Rewards</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="supportPage.php">Support</a>
              </li>
            </ul>

            <ul class="navbar-nav d-flex flex-row">
              <!-- Icons -->
              <li class="nav-item me-3 me-lg-0">
                <a class="nav-link" href="https://www.youtube.com/channel/UC5CF7mLQZhvx8O5GODZAhdA" rel="nofollow"
                  target="_blank">
                  <i class="fab fa-youtube"></i>
                </a>
              </li>
              <li class="nav-item me-3 me-lg-0">
                <a class="nav-link" href="https://www.facebook.com/mdbootstrap" rel="nofollow" target="_blank">
                  <i class="fab fa-facebook-f"></i>
                </a>
              </li>
              <li class="nav-item me-3 me-lg-0">
                <a class="nav-link" href="https://twitter.com/MDBootstrap" rel="nofollow" target="_blank">
                  <i class="fab fa-twitter"></i>
                </a>
              </li>
              <li class="nav-item me-3 me-lg-0">
                <a class="nav-link" href="https://github.com/mdbootstrap/mdb-ui-kit" rel="nofollow" target="_blank">
                  <i class="fab fa-github"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- Navbar -->

      <!-- Carousel wrapper -->
      <!-- Carousel wrapper -->
    </header>
    <!--Main Navigation-->

    <!--Main layout-->
    <main class="mt-5">
      <div class="container">
      <section class="text-center">
      <h3 class="mb-5"><strong>Our Products</strong></h3>
      </section>

      <section class="text-center">
      <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "csad_projek_test";


      $conn = new mysqli($servername,$username,$password,$dbname);

      if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
      }

      $sql = "SELECT image_link,product_name,product_desc,product_price FROM products";
      $result = $conn->query($sql);
      echo '<div class="row">';
      if($result->num_rows > 0){
        for($i = 0; $i < mysqli_num_rows($result); $i++){
          $row = mysqli_fetch_assoc($result);
          echo '<div class="col-lg-4 col-md-12 mb-4">';
          echo '<div class="card">';
          echo '<div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">';
          echo '<img src= "' . $row['image_link'] . '"class = "img-fluid"/>';
          echo '<a href="#!">';
          echo '<div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>';
          echo '</a>';
          echo '</div>';
          echo '<div class="card-body">';
          echo '<h5 class="card-title">' . $row['product_name']. '</h5>';
          echo '<p class="card-text">';
          echo $row['product_desc'];
          echo '</p>';
          echo '<p class="card-text">';
          echo $row['product_price'];
          echo '</p>';
          echo '<a href="#!" class="btn btn-primary">Button</a>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
      }else{
        echo "No results found";
      }
      echo '</div>';
      mysqli_close($conn);  

      ?>
      </section>
      </div>  
    </main>
    <!--Main layout-->

    <!--Footer-->
    <footer class="bg-light text-lg-start">
      <div class="py-4 text-center">
        <a
          role="button"
          class="btn btn-primary btn-lg m-2"
          href="https://www.youtube.com/channel/UC5CF7mLQZhvx8O5GODZAhdA"
          rel="nofollow"
          target="_blank"
        >
          Learn Bootstrap 5
        </a>
        <a
          role="button"
          class="btn btn-primary btn-lg m-2"
          href="https://mdbootstrap.com/docs/standard/"
          target="_blank"
        >
          Download MDB UI KIT
        </a>
      </div>

      <hr class="m-0" />

      <div class="text-center py-4 align-items-center">
        <p>Follow MDB on social media</p>
        <a
          href="https://www.youtube.com/channel/UC5CF7mLQZhvx8O5GODZAhdA"
          class="btn btn-primary m-1"
          role="button"
          rel="nofollow"
          target="_blank"
        >
          <i class="fab fa-youtube"></i>
        </a>
        <a
          href="https://www.facebook.com/mdbootstrap"
          class="btn btn-primary m-1"
          role="button"
          rel="nofollow"
          target="_blank"
        >
          <i class="fab fa-facebook-f"></i>
        </a>
        <a
          href="https://twitter.com/MDBootstrap"
          class="btn btn-primary m-1"
          role="button"
          rel="nofollow"
          target="_blank"
        >
          <i class="fab fa-twitter"></i>
        </a>
        <a
          href="https://github.com/mdbootstrap/mdb-ui-kit"
          class="btn btn-primary m-1"
          role="button"
          rel="nofollow"
          target="_blank"
        >
          <i class="fab fa-github"></i>
        </a>
      </div>

      <!-- Copyright -->
      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2020 Copyright:
        <a class="text-dark" href="https://mdbootstrap.com/">MDBootstrap.com</a>
      </div>
      <!-- Copyright -->
    </footer>
    <!--Footeeeeeer-->
    <!-- MDB -->
    <script type="text/javascript" src="js/mdb.min.js"></script>
    <!-- Custom scripts -->
    <script type="text/javascript" src="js/script.js"></script>
</body>
</html>

