<?php
$db = mysqli_connect('localhost', 'root', '', 'seesad');
if (!$db) {
    die("Connection Failed: " . mysqli_connect_error());
}
$dbb = new PDO('mysql:host=localhost;dbname=seesad', 'root', '');


$id = 0;
$product_name = "";
$product_price = 0;
if (isset($_GET['addToCart'])) {
    $id = $_GET['addToCart'];

    $getProductName = mysqli_query($db, "SELECT product_name FROM products WHERE id=$id");
    $product_name = $getProductName->fetch_array()['product_name'];

    $getProductPrice = mysqli_query($db, "SELECT product_price FROM products WHERE id=$id");
    $product_price = $getProductPrice->fetch_array()['product_price'];

    $getImageLink = mysqli_query($db, "SELECT image_link FROM products WHERE id=$id");
    $image_link = $getImageLink->fetch_array()['image_link'];

    if (isset($_COOKIE['id'])) {
        $query = $dbb->query('SELECT id, name, username, email,address FROM users WHERE id = "' . $_COOKIE['id'] . '"');
        $result = $query->fetchAll();
        foreach ($result as $index => $user) {
            $user_id = $user['id'];
            $address = $user['address'];
        }
    }


    $productCheck = "SELECT * FROM shopping_cart WHERE product_id=$id AND user_id=$user_id";
    $resultCheck = mysqli_query($db, $productCheck);

    
    if (mysqli_num_rows($resultCheck) == 0) {
        $sql = "INSERT INTO shopping_cart(product_id,image_link,product_name,product_price,product_quantity,user_address,user_id) 
    VALUES ('$id','$image_link','$product_name','$product_price','1','$address','$user_id')";
    } else {
        $sql = "UPDATE shopping_cart SET product_quantity = product_quantity + 1,product_price = $product_price * product_quantity WHERE product_id = $id";
    }

    if (mysqli_query($db, $sql)) {
        echo "<script type='text/javascript'>
        $(document).ready(function(){
        $('#addedToCart').modal('show');
        });
        </script>";
    } else {
        echo "<script type='text/javascript'>
        $(document).ready(function(){
        $('#addFail').modal('show');
        });
        </script>";
    }
}
