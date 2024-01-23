<?php
session_start();
$servername = "mysql";
$username = "root";
$password = "";
$dbname = "csad_projek_test";
$dbname = "spmart";

$checkOutSuccessful = false;

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$dbb = mysqli_connect('mysql', 'root', '', 'spmart');
if (!$dbb) {
  die("Connection Failed: " . mysqli_connect_error());
}
$db = new PDO('mysql:host=mysql;dbname=spmart', 'root', '');

$getOrderID = mysqli_query($dbb, "SELECT MAX(order_id) AS order_id_max FROM orders_list");
$order_id_max = $getOrderID->fetch_array()['order_id_max'];
$order_id = $order_id_max + 1;

if (isset($_GET['checkOutPickup'])) {
  if (isset($_COOKIE['id'])) {
    $query = $db->query('SELECT id, name, username, address FROM users WHERE id = "' . $_COOKIE['id'] . '"');
    $result = $query->fetchAll();
    foreach ($result as $index => $user) {
      $user_id = $user['id'];
      $address = $user['address'];
    }
    $sql = "SELECT * FROM shopping_cart WHERE user_id =" . $_COOKIE['id'] . "";
    $result = $conn->query($sql);
    $orderTotal = 0;
    $orderQty = 0;
    $date = date('d-m-y h:i:s');
    include 'phpqrcode/qrlib.php'; 
    $text = "Order# $order_id / User# $user_id / Order Total: $orderTotal / Order Quantity: $orderQty / Order Date: $date";
    $path = 'pickupQR/'; 
    $file = $path.$order_id.".png"; 
    $ecc = 'L'; 
    $pixel_Size = 8; 
    $frame_Size = 8;
    QRcode::png($text, $file, $ecc, $pixel_Size, $frame_Size); 


    if ($result->num_rows > 0) {
      for ($i = 0; $i < mysqli_num_rows($result); $i++) {
        $row = mysqli_fetch_assoc($result);
        $product_id = $row['product_id'];
        $product_name = $row['product_name'];
        $product_price = $row['product_price'];
        $orderTotal += $product_price;
        $product_quantity = $row['product_quantity'];
        $orderQty += $product_quantity;
       
      }
      $addToList = "INSERT INTO orders_list(product_price,product_quantity,order_id,user_id,address,order_date,order_type,qr_code) 
      VALUES ('$orderTotal','$orderQty','$order_id','$user_id','N/A','$date','Self-Pickup','$file')";
      $conn->query($addToList);
      $checkOutSuccessful = true;
      if ($checkOutSuccessful == true) {
        $deleteCart = "DELETE FROM shopping_cart WHERE user_id =" . $_COOKIE['id'] . "";
        $conn->query($deleteCart);
        echo "<script type='text/javascript'>
        $(document).ready(function(){
        $('#CheckoutSuccess').modal('show');
        });
        </script>";
      }
    }
  } else {
  }
}
if (isset($_GET['checkOutDelivery'])) {
  if (isset($_COOKIE['id'])) {
    $query = $db->query('SELECT id, name, username, address FROM users WHERE id = "' . $_COOKIE['id'] . '"');
    $result = $query->fetchAll();
    foreach ($result as $index => $user) {
      $user_id = $user['id'];
      $address = $user['address'];
    }
    $sql = "SELECT * FROM shopping_cart WHERE user_id =" . $_COOKIE['id'] . "";
    $result = $conn->query($sql);
    $orderTotal = 0;
    $orderQty = 0;

    if ($result->num_rows > 0) {
      for ($i = 0; $i < mysqli_num_rows($result); $i++) {
        $row = mysqli_fetch_assoc($result);
        $product_id = $row['product_id'];
        $product_name = $row['product_name'];
        $product_price = $row['product_price'];
        $orderTotal += $product_price;
        $product_quantity = $row['product_quantity'];
        $orderQty += $product_quantity;
       
      }
      $date = date('d-m-y h:i:s');
      $orderTotal += 4;
      $addToList = "INSERT INTO orders_list(product_price,product_quantity,order_id,user_id,address,order_date,order_type) 
      VALUES ('$orderTotal','$orderQty','$order_id','$user_id','$address','$date','Delivery')";
      $conn->query($addToList);
      $checkOutSuccessful = true;
      if ($checkOutSuccessful == true) {
        $deleteCart = "DELETE FROM shopping_cart WHERE user_id =" . $_COOKIE['id'] . "";
        $conn->query($deleteCart);
        echo "<script type='text/javascript'>
        $(document).ready(function(){
        $('#CheckoutSuccess').modal('show');
        });
        </script>";
      }
    }
  } else {
  }
}

if (isset($_GET['deleteItem'])) {
  if (isset($_COOKIE['id'])) {
    $query = $db->query('SELECT id, name, username, address FROM users WHERE id = "' . $_COOKIE['id'] . '"');
    $result = $query->fetchAll();
    foreach ($result as $index => $user) {
      $user_id = $user['id'];
      $address = $user['address'];
    }
    $itemToDelete = $_GET['deleteItem'];
    $deleteItem = "DELETE FROM shopping_cart WHERE user_id=" . $_COOKIE['id'] . " AND id = $itemToDelete";
    $conn->query($deleteItem);
  }
}

if (isset($_GET['minusQuantity'])) {
  if (isset($_COOKIE['id'])) {
    $query = $db->query('SELECT id, name, username, address FROM users WHERE id = "' . $_COOKIE['id'] . '"');
    $result = $query->fetchAll();
    foreach ($result as $index => $user) {
      $user_id = $user['id'];
      $address = $user['address'];
    }
    $minusItem = $_GET['minusQuantity'];

    $getProductQuantity = mysqli_query($dbb, "SELECT product_quantity FROM shopping_cart WHERE id=$minusItem");
    $product_quantity = $getProductQuantity->fetch_array()['product_quantity'];

    if ($product_quantity == 1) {
      $deleteItem2 = "DELETE FROM shopping_cart WHERE user_id=" . $_COOKIE['id'] . " AND id = $minusItem";
      $conn->query($deleteItem2);
    } else {
      $getProductId = mysqli_query($dbb, "SELECT product_id FROM shopping_cart WHERE id=$minusItem");
      $product_id = $getProductId->fetch_array()['product_id'];

      $getProductPrice = mysqli_query($dbb, "SELECT product_price FROM products WHERE id=$product_id");
      $product_price = $getProductPrice->fetch_array()['product_price'];

      $deleteItem = "UPDATE shopping_cart SET product_quantity =  product_quantity - 1,product_price = $product_price*product_quantity WHERE user_id=" . $_COOKIE['id'] . " AND id = $minusItem";
      $conn->query($deleteItem);
    }
  }
}

if (isset($_GET['addQuantity'])) {
  if (isset($_COOKIE['id'])) {
    $query = $db->query('SELECT id, name, username, address FROM users WHERE id = "' . $_COOKIE['id'] . '"');
    $result = $query->fetchAll();
    foreach ($result as $index => $user) {
      $user_id = $user['id'];
      $address = $user['address'];
    }
    $minusItem = $_GET['addQuantity'];


    $getProductId = mysqli_query($dbb, "SELECT product_id FROM shopping_cart WHERE id=$minusItem");
    $product_id = $getProductId->fetch_array()['product_id'];

    $getProductPrice = mysqli_query($dbb, "SELECT product_price FROM products WHERE id=$product_id");
    $product_price = $getProductPrice->fetch_array()['product_price'];

    $deleteItem = "UPDATE shopping_cart SET product_quantity =  product_quantity + 1,product_price = $product_price*product_quantity WHERE user_id=" . $_COOKIE['id'] . " AND id = $minusItem";
    $conn->query($deleteItem);
  }
}
