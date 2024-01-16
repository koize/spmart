<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Clear Skin All Day Support</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
  <!-- MDB -->
  <link rel="stylesheet" href="css/mdb.min.css" />
  <!-- Custom styles -->
  <link rel="stylesheet" href="css/style.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
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
  <main class="mt-5 mb-5">

    <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
      <div class="row gx-lg-5 align-items-center mb-5">
        <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
          <h1 class="my-5 display-5 fw-bold ls-tight" style="color: #6DD5FA">
            Frequently<br>
            <span style="color: #2980B9">Answered Questions</span>
          </h1>

        </div>

        <div class="col-lg-6 mb-5 mb-lg-0 position-relative">

          <!--Accordion-->
          <div class="accordion" id="accordionExample">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  What are the shipping options for facial products?
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-mdb-parent="#accordionExample">
                <div class="accordion-body">
                  We offer a variety of shipping options for facial products, including standard
                  shipping, expedited shipping, and overnight shipping. Standard shipping is free
                  for orders over $50. Expedited shipping is available for an additional fee.
                  Overnight shipping is available for the most urgent orders.
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  What is your return policy for facial products?
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-mdb-parent="#accordionExample">
                <div class="accordion-body">
                  We offer a 30-day return policy for facial products. If you are not
                  satisfied with your purchase, you can return it for a full refund.
                  You must return the product in its original packaging and in resalable condition.
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  How do I contact customer support?
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-mdb-parent="#accordionExample">
                <div class="accordion-body">
                  You can contact customer support by email, phone,
                  or live chat. Our customer support team is available
                  24/7 to answer your questions and help you with your order.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card py-1 px-5">
        <h6 class="my-5 display-6 fw-bold ls-tight" style="color: #6DD5FA">
          Contact
          <span style="color: #2980B9">Us</span>
        </h6>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <!-- Name input -->
          <div class="form-outline mb-4">
            <input type="text" id="form4Example1" class="form-control" name="name" />
            <label class="form-label" for="form4Example1">Name</label>
          </div>

          <!-- Email input -->
          <div class="form-outline mb-4">
            <input type="email" id="form4Example2" class="form-control" name="email"/>
            <label class="form-label" for="form4Example2">Email address</label>
          </div>

          <!-- Message input -->
          <div class="form-outline mb-4">
            <textarea class="form-control" id="form4Example3" rows="4" name="message"></textarea>
            <label class="form-label" for="form4Example3">Message</label>
          </div>


          <!-- Submit button -->
          <button type="submit" name="sendFeedback" class="btn btn-primary btn-block mb-4" >Send</button>
        </form>

      </div>
    </div>


  </main>

  <!--Main layout-->
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new PDO('mysql:host=localhost;dbname=seesad', 'root', '');
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
  <!-- feedbackModal -->
  <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModal" aria-hidden="true" style="z-index: 10000000 !important;">
            <div class="modal-dialog mt-20">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Feedback submission</h5>
                  <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">Thank you for your feedback! We will be in touch with you shortly</div>
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