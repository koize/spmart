<!DOCTYPE html>
<html lang="en">
<?php
session_start();
// Check if the user is logged in
if (!isset($_COOKIE['id'])) {
    header("Location: login.php");
    exit();
}

// Check if the user is an admin
if ($_COOKIE['id'] != "1") {
    echo "You are not an admin.";
    exit();
}

?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>CSAD Admin dashboard</title>
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
    <link rel="icon" href="img/csad_icon.png" type="image/x-icon" />

</head>

<body>
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
        <style>
            * {
                text-align: center;
            }
        </style>
    </header>
    <div>
        <?php
        $db = new PDO('mysql:host=localhost;dbname=seesad', 'root', '');
        ?>
    </div>
    <!-- Navbar -->
    <div id="nav-products">
    </div>
    <style>
        .user_input {
            padding-top: 4px;
            padding-bottom: 4px;
            padding-left: 7px;
            padding-right: 7px;
            background-color: #e0e0e0;
            border-radius: 5px;
        }
    </style>
    <a class="user_input" href="#Users">Users</a>
    <a class="user_input" href="#reward-codes">Reward Codes</a>
    <a class="user_input" href="#feedback">Feedback</a>
    <a class="user_input" href="#promotions">Promotions</a>
    <a class="user_input" href="#products">Products</a>
    <a class="user_input" href="#shopping-cart">Shopping Cart</a>
    <!--
    <div id="resultModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="resultModal" aria-hidden="true">
        <div class="modal-dialog mt-20" role="document">
            <div class="modal-content" id="resultModalContent">
                <div class="modal-header">
                    <h5 class="modal-title" id="resultModalTitle">Result</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="resultModalBody"></p>
                </div>

            </div>
        </div>
    </div>
    -->
    <h3 id="Users">Users</h3>
    <table class="table table-striped">
        <tr>
            <th>id</th>
            <th>name</th>
            <th>username</th>
            <th>email</th>
            <th>password</th>
            <th>address</th>
            <th>phone</th>
            <th>image path</th>
            <th>created at</th>
            <th>action</th>
        </tr>
        <?php
        $sql = "SELECT * FROM users";
        $result = $db->query($sql);
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['password'] . "</td>";
            echo "<td>" . $row['address'] . "</td>";
            echo "<td>" . $row['phone'] . "</td>";
            if ($row['img_filepath'] == "") {
                echo "<td><img style='width:65px' class='rounded-circle img-fluid' src='https://subwayisfresh.com.sg/wp-content/uploads/2022/02/Sides-Double-Chocolate-Cookie.jpg'><br>" . $row['img_filepath'] . "</td>";
            } else {
                echo "<td><img style='width:65px' class='rounded-circle img-fluid' src='" . $row['img_filepath'] . "'><br>" . $row['img_filepath'] . "</td>";
            }
            echo "<td>" . $row['created_at'] . "</td>";
            echo "<td><button type='button' class='btn btn-outline-info' data-mdb-toggle='modal' data-mdb-target='#" . "edit_user_" . $row['id'] . "'>Edit</button></td>";
            echo "</tr>";
        }
        ?>
    </table>
    <?php
    $sql = "SELECT * FROM users";
    $result = $db->query($sql);
    foreach ($result as $row) {
        echo "<div class='modal fade' id='edit_user_" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='"
            . "edit_user_" . $row['id'] . "' aria-hidden='true'>";
        echo "<div class='modal-dialog modal-dialog-centered' role='document'>";
        echo "<div class='modal-content'>";
        echo "<div class='modal-header'>";
        echo "<h5 class='modal-title' id='" . "edit" . $row['id'] . "Title" . "'>Edit User ID: " . $row['id'] . "</h5>";
        echo "<button type='button' class='btn-close' data-mdb-dismiss='modal' aria-label='Close'>";
        echo "</button>";
        echo "</div>";
        echo "<div class='modal-body'>";
        echo "User ID: <div id='user_user_id" . $row['id'] . "' class='user_input' contenteditable='true'>" . $row['id'] . "</div>";
        echo "Name: <div id='user_name" . $row['id'] . "' class='user_input' contenteditable='true'>" . $row['name'] . "</div>";
        echo "Username: <div id='user_username" . $row['id'] . "' class='user_input' contenteditable='true'>" . $row['username'] . "</div>";
        echo "Email: <div id='user_email" . $row['id'] . "' class='user_input' contenteditable='true'>" . $row['email'] . "</div>";
        echo "Password: <div id='user_password" . $row['id'] . "' class='user_input' contenteditable='true'>" . $row['password'] . "</div>";
        echo "Address: <div id='user_address" . $row['id'] . "' class='user_input' contenteditable='true'>" . $row['address'] . "</div>";
        echo "Phone: <div id='user_phone" . $row['id'] . "' class='user_input' contenteditable='true'>" . $row['phone'] . "</div><br>";
        echo "<form method='post' action='admin.php' enctype='multipart/form-data'>";
        echo "Profile Picture Path: <input type='file' name='user_img_path' id='user_img_path' class='user_input'/>"; //I'm questioning myself
        echo "<input type='hidden' name='id' id='id' value='" . $row['id'] . "'/>";
        echo "<button class='btn btn-primary' type='submit' name='uploadUserImg'>Upload</button>";
        echo "</form>";
        echo "Time Created: <div id='user_created_at" . $row['id'] . "' class='user_input' contenteditable='true'>" . $row['created_at'] . "</div>";

        //content here
        echo "</div>";
        echo "<div class='modal-footer'>";
        echo "<button type='button' class='btn btn-primary' onclick='saveUserChanges(" . $row['id'] . ");'>Save changes</button>";
        echo "<button type='button' class='btn btn-danger' onclick='deleteUser(" . $row['id'] . ");'>Delete Account</button>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        //echo "<script>$(document).ready(function() { $('#edit" . $row['id'] . "').modal('show');});</script>";
    }
    ?>
    <h3 id="reward-codes">Reward Codes</h3>
    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Discount</th>
            <th>Discount_Code</th>
            <th>Used_Code</th>
            <th>Action</th>
        </tr>
        <?php
        $sql = "SELECT * FROM reward_codes";
        $result = $db->query($sql);
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>" . $row['discount'] . "%</td>";
            echo "<td><code>" . $row['discount_code'] . "</code></td>";
            echo "<td>" . $row['used_code'] . "</td>";
            echo "<td><button type='button' class='btn btn-outline-info' data-mdb-toggle='modal' data-mdb-target='#" . "edit_code_" . $row['id'] . "'>Edit</button></td>";
            echo "</tr>";
        }
        ?>
    </table>
    <?php
    $sql = "SELECT * FROM reward_codes";
    $result = $db->query($sql);
    foreach ($result as $row) {
        echo "<div class='modal fade' id='edit_code_" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='"
            . "edit_code_" . $row['id'] . "' aria-hidden='true'>";
        echo "<div class='modal-dialog modal-dialog-centered' role='document'>";
        echo "<div class='modal-content'>";
        echo "<div class='modal-header'>";
        echo "<h5 class='modal-title' id='" . "edit_code_" . $row['id'] . "Title" . "'>Reward code: " . $row['id'] . "</h5>";
        echo "<button type='button' class='btn-close' data-mdb-dismiss='modal' aria-label='Close'>";
        echo "</button>";
        echo "</div>";
        echo "<div class='modal-body'>";
        //content here
        echo "User ID: <div id='reward_user_id" . $row['id'] . "' class='user_input' contenteditable='true'>" . $row['user_id'] . "</div>";
        echo "Code ID: <div id='reward_id" . $row['id'] . "' class='user_input'>" . $row['id'] . "</div>";
        echo "Discount %: <div id='reward_discount" . $row['id'] . "' class='user_input' contenteditable='true'>" . $row['discount'] . "</div>";
        echo "Discount Code: <div id='reward_code" . $row['id'] . "' class='user_input' contenteditable='true'>" . $row['discount_code'] . "</div>";
        echo "Used: <div id='reward_used_code" . $row['id'] . "' class='user_input' contenteditable='true'>" . $row['used_code'] . "</div>";
        echo "</div>";
        echo "<div class='modal-footer'>";
        echo "<button type='button' class='btn btn-primary' onclick='saveRewardChanges(" . $row['id'] . ");'>Save changes</button>";
        echo "<button type='button' class='btn btn-danger' onclick='deleteReward(" . $row['id'] . ");'>Delete Reward Code</button>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        //echo "<script>$(document).ready(function() { $('#edit" . $row['id'] . "').modal('show');});</script>";
    }
    ?>
    <script>
        function saveUserChanges(x) {
            var xmlhttp = new XMLHttpRequest();
            var str = "mode=save_user_changes";
            let user_id = "&user_id=" + document.getElementById("user_user_id" + x).innerText;
            let verif = document.getElementById("user_user_id" + x).innerText;
            if (isNaN(verif) || isNaN(parseFloat(verif))) {
                alert("User ID must be a number!");
                return;
            }
            let name = "&name=" + document.getElementById("user_name" + x).innerText;
            let username = "&username=" + document.getElementById("user_username" + x).innerText;
            let email = "&email=" + document.getElementById("user_email" + x).innerText;
            verif = document.getElementById("user_email" + x).innerText;
            if (!verif.includes("@")) {
                alert("Email must be valid!");
                return;
            }
            let password = "&password=" + document.getElementById("user_password" + x).innerText;
            let address = "&address=" + document.getElementById("user_address" + x).innerText;
            verif = document.getElementById("user_phone" + x).innerText;
            let phone = "&phone=" + document.getElementById("user_phone" + x).innerText;
            if (isNaN(verif) || isNaN(parseFloat(verif)) || (verif.length < 8 && verif.length)) {
                if (verif.length != 0) {
                    alert("Phone number must be a number!");
                    return;
                }
            }
            let img = document.getElementById("user_img_path" + x);
            //let img_path = "&img_path=" + document.getElementById("user_img_path" + x).innerText;
            let created_at = "&created_at=" + document.getElementById("user_created_at" + x).innerText;
            str = str + user_id + name + username + email + password + address + phone + created_at;
            xmlhttp.open('POST', "admin.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert(this.responseText);
                }
            };
            xmlhttp.send(str);
        }

        function deleteUser(x) {
            var xmlhttp = new XMLHttpRequest();
            var str = "mode=delete_user";
            var user_id = "&user_id=" + document.getElementById("user_user_id" + x).innerText;
            str = str + user_id;
            xmlhttp.open('POST', "admin.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert(this.responseText);
                }
            };
            xmlhttp.send(str);
        }

        function saveRewardChanges(x) {
            var xmlhttp = new XMLHttpRequest();
            var str = "mode=save_reward_changes";
            let id = "&id=" + document.getElementById("reward_id" + x).innerText;
            let user_id = "&user_id=" + document.getElementById("reward_user_id" + x).innerText;
            let discount = "&discount=" + document.getElementById("reward_discount" + x).innerText;
            let discount_code = "&discount_code=" + document.getElementById("reward_code" + x).innerText;
            let used_code = "&used_code=" + document.getElementById("reward_used_code" + x).innerText;
            str = str + id + user_id + discount + discount_code + used_code;
            xmlhttp.open('POST', "admin.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert(this.responseText);
                }
            };
            xmlhttp.send(str);
        }

        function deleteReward(x) {
            var xmlhttp = new XMLHttpRequest();
            var str = "mode=delete_reward";
            var id = "&id=" + document.getElementById("reward_id" + x).innerText;
            str = str + id;
            xmlhttp.open('POST', "admin.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert(this.responseText);
                }
            };
            xmlhttp.send(str);
        }
    </script>

    <h3 id="feedback">Feedback</h3>
    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Created At</th>
            <th>Read</th>
        </tr>
        <?php
        $sql = "SELECT * FROM feedback";
        $result = $db->query($sql);
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['message'] . "</td>";
            echo "<td>" . $row['created_at'] . "</td>";
            echo "<td><button type='button' class='btn btn-outline-info' data-mdb-toggle='modal' data-mdb-target='#" . "feedback_" . $row['id'] . "'>Read</button></td>";
            echo "</tr>";
        }
        ?>
    </table>
    <?php
    $sql = "SELECT * FROM feedback";
    $result = $db->query($sql);
    foreach ($result as $row) {
        echo "<div class='modal fade' id='feedback_" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='"
            . "feedback_" . $row['id'] . "' aria-hidden='true'>";
        echo "<div class='modal-dialog modal-dialog-centered' role='document'>";
        echo "<div class='modal-content'>";
        echo "<div class='modal-header'>";
        echo "<h5 class='modal-title' id='" . "feedback_" . $row['id'] . "Title" . "'>Read Feedback info: " . $row['id'] . "</h5>";
        echo "<button type='button' class='btn-close' data-mdb-dismiss='modal' aria-label='Close'>";
        echo "</button>";
        echo "</div>";
        echo "<div class='modal-body'>";
        echo "Feedback ID: <div id='feedback_user_id" . $row['id'] . "' class='user_input'>" . $row['id'] . "</div>";
        echo "Name: <div id='feedback_user_name" . $row['id'] . "' class='user_input'>" . $row['name'] . "</div>";
        echo "Email: <div id='feedback_user_email" . $row['id'] . "' class='user_input'>" . $row['email'] . "</div>";
        echo "Message: <div id='feedback_message" . $row['id'] . "' class='user_input'>" . $row['message'] . "</div>"; //I'm questioning myself
        echo "Time Created: <div id='feedback_created_at" . $row['id'] . "' class='user_input'>" . $row['created_at'] . "</div>";

        //content here
        echo "</div>";
        echo "<div class='modal-footer'>";
        echo "<a class='btn btn-primary' href='mailto:" . $row['email'] . "'>Reply</a>";
        echo "<button type='button' class='btn btn-danger' onclick='deleteFeedback(" . $row['id'] . ");'>Delete Feedback</button>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
    ?>
    <script>
        function deleteFeedback(x) {
            var xmlhttp = new XMLHttpRequest();
            var str = "mode=delete_feedback";
            var id = "&id=" + document.getElementById("feedback_user_id" + x).innerText;
            str = str + id;
            xmlhttp.open('POST', "admin.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert(this.responseText);
                }
            };
            xmlhttp.send(str);
        }
    </script>
    <h3 id="promotions">Promotions</h3>
    <button type="button" class="btn btn-outline-info" data-mdb-toggle="modal" data-mdb-target="#add_promotion" style="margin-bottom: 10px">Add Promotion</button>
    <div class="modal fade" id="add_promotion" tabindex="-1" role="dialog" aria-labelledby="add_product" aria-hidden="true">
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class="modal-title" id="add_promotionTitle">Add Promotion</h5>
                    <button type='button' class='btn-close' data-mdb-dismiss='modal' aria-label='Close'></button>
                </div>
                </button>
                <div class="modal-body">
                    <form method='post' action='admin.php' enctype='multipart/form-data'>
                        <table style=" text-align: left">
                            <tr>
                                <td>Name:</td>
                                <td><input type='text' name='promotion_name' id='promotion_name' class='user_input' /></td>
                            </tr>
                            <tr>
                                <td>Original Price:</td>
                                <td><input type='text' name='promotion_original_price' id='promotion_original_price' class='user_input' /></td>
                            </tr>
                            <tr>
                                <td>Discounted Price:</td>
                                <td><input type='text' name='promotion_sale_price' id='promotion_sale_price' class='user_input' /></td>
                            </tr>
                            <tr>
                                <td>Details</td>
                                <td><textarea name='promotion_details' id='promotion_details' cols='30' rows='10'></textarea></td>
                            </tr>
                            <tr>
                                <td>Start Date:</td>
                                <td><input type='date' name='promotion_start_date' id='promotion_start_date' class='user_input' /></td>
                            </tr>
                            <tr>
                                <td>End Date:</td>
                                <td><input type='date' name='promotion_end_date' id='promotion_end_date' class='user_input' /></td>
                            </tr>
                            <tr>
                                <td>Image</td>
                                <td><input type='file' name='promotion_image' id='promotion_image' class='user_input' /></td>
                            </tr>
                        </table>
                        <button type='submit' class='btn btn-primary' name='uploadNewPromotion' data-mdb-dismiss='modal'>Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Original_Price</th>
            <th>Sale_Price</th>
            <th>Start_Date</th>
            <th>End_Date</th>
            <th>Img_path</th>
            <th>Edit</th>
        </tr>
        <?php
        $sql = "SELECT * FROM promotions";
        $result = $db->query($sql);
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['details'] . "</td>";
            echo "<td>$" . $row['original_price'] . "</td>";
            echo "<td>$" . $row['sale_price'] . "</td>";
            echo "<td>" . $row['start_date'] . "</td>";
            echo "<td>" . $row['end_date'] . "</td>";
            echo "<td><img style='width:60px;height:60px' src='" . $row['img_filepath'] . "'><br>" . $row['img_filepath'] . "</td>";
            echo "<td><button type='button' class='btn btn-outline-info' data-mdb-toggle='modal' data-mdb-target='#" . "promotions_" . $row['id'] . "'>Edit</button></td>";
            echo "</tr>";
        }
        ?>
        <?php
        $sql = "SELECT * FROM promotions";
        $result = $db->query($sql);
        foreach ($result as $row) {
            echo "<div class='modal fade' id='promotions_" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='"
                . "promotions_" . $row['id'] . "' aria-hidden='true'>";
            echo "<div class='modal-dialog modal-dialog-centered' role='document'>";
            echo "<div class='modal-content'>";
            echo "<div class='modal-header'>";
            echo "<h5 class='modal-title' id='promotions_" . $row['id'] . "Title'>Promotion info " . $row['id'] . "</h5>";
            echo "<button type='button' class='btn-close' data-mdb-dismiss='modal' aria-label='Close'>";
            echo "</button>";
            echo "</div>";
            echo "<div class='modal-body'>";
            echo "Product ID: <div id='promotions_id" . $row['id'] . "' class='user_input'>" . $row['id'] . "</div>";
            echo "Product Name: <div id='promotions_name" . $row['id'] . "' class='user_input' contenteditable='true'>" . $row['name'] . "</div>";
            echo "Product Desc: <div id='promotions_details" . $row['id'] . "' class='user_input' contenteditable='true'>" . $row['details'] . "</div>";
            echo "Product Original Price: <div id='product_original_price" . $row['id'] . "' class='user_input' contenteditable='true'>" . $row['original_price'] . "</div>";
            echo "Product Sale Price: <div id='product_sale_price" . $row['id'] . "' class='user_input' contenteditable='true'>" . $row['sale_price'] . "</div>";
            echo "Start Date: <input type='date' id='product_start_date" . $row['id'] . "' class='user_input' value='" . $row['start_date'] . "'><br>";
            echo "End Date: <input type='date' id='product_end_date" . $row['id'] . "' class='user_input' value='" . $row['end_date'] . "'><br>";
            //content here
            echo "</div>";
            echo "<div class='modal-footer'>";
            echo "<button type='button' class='btn btn-primary' onclick='savePromotionChanges(" . $row['id'] . ");'>Save</button>";
            echo "<button type='button' class='btn btn-danger' onclick='deletePromotion(" . $row['id'] . ");'>Delete Product</button>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
        ?>
    </table>
    <script>
        function deletePromotion(x) {
            var xmlhttp = new XMLHttpRequest();
            var str = "mode=delete_promotion&id=" + x;
            xmlhttp.open('POST', "admin.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert(this.responseText);
                    location.reload();
                }
            };
            xmlhttp.send(str);
        }

        function savePromotionChanges(x) {
            var xmlhttp = new XMLHttpRequest();
            var str = "mode=save_promotion_changes&id=" + x;
            var name = "&name=" + document.getElementById("promotions_name" + x).innerHTML;
            var original_price = "&original_price=" + document.getElementById("product_original_price" + x).innerHTML;
            var sale_price = "&sale_price=" + document.getElementById("product_sale_price" + x).innerHTML;
            var start_date = "&start_date=" + document.getElementById("product_start_date" + x).value;
            var end_date = "&end_date=" + document.getElementById("product_end_date" + x).value;
            var details = "&details=" + document.getElementById("promotions_details" + x).innerHTML;
            str = str + name + original_price + sale_price + start_date + end_date + details;
            xmlhttp.open('POST', "admin.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert(this.responseText);
                    location.reload();
                }
            };
            xmlhttp.send(str);
        }
    </script>

    <h3 id="products">Products</h3>
    <button type="button" class="btn btn-outline-info" data-mdb-toggle="modal" data-mdb-target="#add_product" style="margin-bottom: 10px;">Add Product</button>
    <div class="modal fade" id="add_product" tabindex="-1" role="dialog" aria-labelledby="add_product" aria-hidden="true">
        <div class='modal-dialog modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='add_productTitle'>Add Product</h5>
                    <button type='button' class='btn-close' data-mdb-dismiss='modal' aria-label='Close'>
                    </button>
                </div>
                <div class="modal-body">
                    <form method='post' action='admin.php' enctype='multipart/form-data'>
                        <table style=" text-align: left">
                            <tr>
                                <td>Name:</td>
                                <td><input type='text' name='product_name' id='product_name' class='user_input' /></td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td><textarea name='product_desc' id='product_desc' cols='30' rows='10'></textarea></td>
                            </tr>
                            <tr>
                                <td>Price:</td>
                                <td><input type='text' name='product_price' id='product_price' class='user_input' /></td>
                            </tr>
                            <tr>
                                <td>Category</td>
                                <td><input type='text' name='product_category' id='product_category' class='user_input' /></td>
                            </tr>
                            <tr>
                                <td>Product Image</td>
                                <td><input type='file' name='product_image' id='product_image' class='user_input' /></td>
                            </tr>
                        </table>
                        <button type='submit' class='btn btn-primary' name='uploadNewProduct' data-mdb-dismiss='modal'>Add Product</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
    </div>
    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Product_Name</th>
            <th>Product_Desc</th>
            <th>Product_Price</th>
            <th>Product_Category</th>
            <th>Image_Link</th>
            <th>Edit</th>
        </tr>
        <?php
        $sql = "SELECT * FROM products";
        $result = $db->query($sql);
        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['product_name'] . "</td>";
            echo "<td>" . $row['product_desc'] . "</td>";
            echo "<td>$" . $row['product_price'] . "</td>";
            echo "<td>" . $row['products_category'] . "</td>";
            echo "<td><img style='width:65px' src='" . $row['image_link'] . "'><br>" . $row['image_link'] . "</td>";
            echo "<td><button type='button' class='btn btn-outline-info' data-mdb-toggle='modal' data-mdb-target='#" . "products_" . $row['id'] . "'>Edit</button></td>";
            echo "</tr>";
        }
        ?>
        <table>
            <?php
            $sql = "SELECT * FROM products";
            $result = $db->query($sql);
            foreach ($result as $row) {
                echo "<div class='modal fade' id='products_" . $row['id'] . "' tabindex='-1' role='dialog' aria-labelledby='"
                    . "products_" . $row['id'] . "' aria-hidden='true'>";
                echo "<div class='modal-dialog modal-dialog-centered' role='document'>";
                echo "<div class='modal-content'>";
                echo "<div class='modal-header'>";
                echo "<h5 class='modal-title' id='" . "products_" . $row['id'] . "Title" . "'>Product info: " . $row['id'] . "</h5>";
                echo "<button type='button' class='btn-close' data-mdb-dismiss='modal' aria-label='Close'>";
                echo "</button>";
                echo "</div>";
                echo "<div class='modal-body'>";
                echo "Product ID: <div id='products_id" . $row['id'] . "' class='user_input'>" . $row['id'] . "</div>";
                echo "Product Name: <div id='product_name" . $row['id'] . "' class='user_input' contenteditable='true'>" . $row['product_name'] . "</div>";
                echo "Product Desc: <div id='product_desc" . $row['id'] . "' class='user_input' contenteditable='true'>" . $row['product_desc'] . "</div>";
                echo "Product Price: <div id='product_price" . $row['id'] . "' class='user_input' contenteditable='true'>" . $row['product_price'] . "</div>";
                echo "Product Category: <div id='product_category" . $row['id'] . "' class='user_input' contenteditable='true'>" . $row['products_category'] . "</div>";
                echo "<form method='post' action='admin.php' enctype='multipart/form-data'>";
                echo "<br>Image File: <input type='file' name='product_image_link' id='product_image_link' class='user_input'/>";
                echo "<input type='hidden' name='id' id='id' value='" . $row['id'] . "'/>";
                echo "<button class='btn btn-primary' type='submit' name='uploadProductImage'>Upload</button>";
                echo "</form>";
                echo "</div>";
                echo "<div class='modal-footer'>";
                echo "<button type='button' class='btn btn-primary' onclick='saveProductChanges(" . $row['id'] . ");'>Save</button>";
                echo "<button type='button' class='btn btn-danger' onclick='deleteProduct(" . $row['id'] . ");'>Delete Product</button>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            ?>
            <script>
                function saveProductChanges(x) {
                    var xmlhttp = new XMLHttpRequest();
                    var str = "mode=save_product_changes";
                    var id = "&id=" + document.getElementById("products_id" + x).innerText;
                    var product_name = "&product_name=" + document.getElementById("product_name" + x).innerText;
                    var product_desc = "&product_desc=" + document.getElementById("product_desc" + x).innerText;
                    var product_price = "&product_price=" + document.getElementById("product_price" + x).innerText;
                    var products_category = "&products_category=" + document.getElementById("product_category" + x).innerText;
                    str += id + product_name + product_desc + product_price + products_category;
                    xmlhttp.open("POST", "admin.php", true);
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            alert(this.responseText);
                        }
                    };
                    xmlhttp.send(str);
                }

                function deleteProduct(x) {
                    var xmlhttp = new XMLHttpRequest();
                    var str = "mode=delete_product";
                    var id = "&id=" + document.getElementById("products_id" + x).innerText;
                    str += id;
                    xmlhttp.open("POST", "admin.php", true);
                    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            alert(this.responseText);
                        }
                    };
                    xmlhttp.send(str);
                }
            </script>
            <h3 id="shopping-cart">Orders List</h3>
            <table class="table table-striped">
                <tr>
                    <th>ID</th>
                    <th>Product_ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Product_Quantity</th>
                    <th>Order ID</th>
                    <th>User_ID</th>
                </tr>
                <?php
                
                $sql = "SELECT * FROM orders_list";
                $result = $db->query($sql);
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['product_id'] . "</td>";
                    echo "<td>" . $row['product_name'] . "</td>";
                    echo "<td>" . $row['product_price'] . "</td>";
                    echo "<td>" . $row['product_quantity'] . "</td>";
                    echo "<td>" . $row['order_id'] . "</td>";
                    echo "<td>" . $row['user_id'] . "</td>";
                    //echo '<td><a href="dashboard.php?deleteOrder='.$row['order_id'].'"class="btn btn-danger">Delete Entire Order</a></td>';
                    echo "</tr>";
                }

                ?>
            </table>


            <script>
                $(function() {
                    $("#nav-products").load("navbar.php");
                });
            </script>
            <!-- Navbar -->
            <div id="footer-about">
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