<!DOCTYPE html>
<html lang="en">
<?php session_start(); ?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Clear Skin All Day Rewards</title>
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
        <!-- Navbar -->
    </header>
    <!--Main Navigation-->

    <!--Main layout-->
    <main class="mt-5">
            <!--Section: Content-->
            <section class="text-center">
            <h6 class="my-5 display-6 fw-bold ls-tight text-center" style="color: #2980B9">
            CSAD
            <span style="color: #6DD5FA">Rewards</span>
          </h6>
            <p>Get discounts while playing!</p>
                <table class="table table-striped">
                    <tr>
                        <th>Score</th>
                        <th>Discount</th>
                    </tr>
                    <tr>
                        <td>100+</td>
                        <td>10% off</td>
                    </tr>
                    <tr>
                        <td>50</td>
                        <td> 5% off</td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td> 2% off</td>
                    </tr>
                </table>
                <!-- iframe that capures keyboard inputs when clicked on -->
                <figure>
                    <?php
                    if(!isset($_COOKIE['id'])) {
                        echo '<iframe id="game_iframe" width="1000" height="780" src="./rewards/game.php"></iframe>';
                    } else {
                        echo '<iframe id="game_iframe" width="1000" height="730" src="./rewards/game.php"></iframe>';
                    }
                    ?>
                </figure>
                <div>
                    <button id="claim_reward" class="btn btn-primary" onclick="getRewardCode()">claim rewards!</button>
                </div>
                <span id="reward_code"></span>
            </section>
            <script>
                function getRewardCode() {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("reward_code").innerHTML = this.responseText;
                        }
                    };
                    const value = `; ${document.cookie}`;
                    //get cookie of name "hscore"
                    const parts = value.split(`; hscore=`);
                    xmlhttp.open("GET", "./rewards/getRewardCode.php?s=" + parts.toString(), true);
                    xmlhttp.send();
                }
            </script>
            <br/>
            <!--Section: Content-->
        </div>
    </main>
    <!--Main layout-->
    <div id="footer-about">

    </div>
    <script>
      $(function() {
        $("#footer-about").load("footer.php");
      });   
    </script>
    <!-- MDB -->
    <script type="text/javascript" src="js/mdb.min.js"></script>
    <!-- Custom scripts -->
    <script type="text/javascript" src="js/script.js"></script>
</body>

</html>