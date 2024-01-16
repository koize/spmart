<?php
if($_COOKIE['id'] != "1") {
    echo "You are not an admin.";
    exit();
}

$db = new PDO("mysql:host=localhost;dbname=seesad", "root", "");
$query = $db->query('CREATE DATABASE IF NOT EXISTS seesad');


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['uploadUserImg'])){
        uploadUserImg();
        exit();
    }else if(isset($_POST['uploadNewPromotion'])) {
        uploadNewPromotion();
        exit();
    }else if(isset($_POST['uploadNewProduct'])) {
        uploadNewProduct();
        exit();
    } else if(isset($_POST['uploadProductImage'])) {
        uploadProductImage();
        exit();
    }
    if($_POST['mode'] == "save_user_changes") {
        saveUserChanges();
    } else if($_POST['mode'] == "delete_user") {
        deleteUser();
    } else if($_POST['mode'] == "save_reward_changes") {
        saveRewardChanges();
    } else if($_POST['mode'] == "delete_reward") {
        deleteReward();
    }  else if($_POST['mode'] == "delete_feedback") {
        deleteFeedback();
    } else if($_POST['mode'] == "save_product_changes") {
        saveProductChanges();
    } else if($_POST['mode'] == "delete_product") {
        deleteProduct();
    } else if($_POST['mode'] == "save_shopping_changes") {
        saveShoppingChanges();
    } else if($_POST['mode'] == "delete_shopping") {
        deleteShopping();
    } else if($_POST['mode'] == "delete_promotion") {
        deletePromotion();
    } else if($_POST['mode'] == "save_promotion_changes") {
        savePromotionChanges();
    }
}

function uploadUserImg() {
    global $db;
    $target_dir = "user-profile-icon/";
    /*
    foreach($_POST as $key => $value) {
        echo $key . " " . $value . "<br>";
    }
    */
    $id = $_POST['id'];
    $target_file = $target_dir . basename($_FILES["user_img_path"]["name"]);
    if(move_uploaded_file($_FILES["user_img_path"]["tmp_name"], $target_file)) {
        $db->query('UPDATE users SET img_filepath = "' . $target_file . '" WHERE id = "' . $id . '"');
    }
    header("Location: dashboard.php");

}

function uploadNewPromotion() {
    global $db;
    $target_dir = "img/";
    $name = $_POST['promotion_name'];
    if($name == "") {
        echo "Promotion name cannot be empty!";
        exit();
    }
    $original_price = $_POST['promotion_original_price'];
    if($original_price == "") {
        echo "Original price cannot be empty!";
        exit();
    }
    $sale_price = $_POST['promotion_sale_price'];
    if($sale_price == "") {
        echo "Sale price cannot be empty!";
        exit();
    }
    $start_date = $_POST['promotion_start_date'];
    if($start_date == "") {
        echo "Start date cannot be empty!";
        exit();
    }
    $end_date = $_POST['promotion_end_date'];
    if($end_date == "") {
        echo "End date cannot be empty!";
        exit();
    }
    $details = $_POST['promotion_details'];
    $db->query('INSERT INTO promotions (name, original_price, sale_price, start_date, end_date, details) VALUES ("' . $name . '", "' . $original_price . '", "' . $sale_price . '", "' . $start_date . '", "' . $end_date . '", "' . $details . '")');
    $target_file = $target_dir . basename($_FILES["promotion_image"]["name"]);
    $id = $db->lastInsertId();
    if(!move_uploaded_file($_FILES["promotion_image"]["tmp_name"], $target_file)) {
        echo "error occured!";
        $db->query('UPDATE promotions SET img_filepath = "" WHERE id = "' . $id . '"');
    } else {
        $db->query('UPDATE promotions SET img_filepath = "' . $target_file . '" WHERE id = "' . $id . '"');
    }
    echo "Successfully added promotion!";
    sleep(2);
    header("Location: dashboard.php");
}

function uploadNewProduct() {
    global $db;
    $target_dir = "img/";
    $product_name = $_POST['product_name'];
    if($product_name == "") {
        echo "Product name cannot be empty!";
        exit();
    }
    $product_desc = $_POST['product_desc'];
    $product_price = $_POST['product_price'];
    if($product_price == "") {
        echo "Product price cannot be empty!";
        exit();
    }
    $product_category = $_POST['product_category'];
    if($product_category == "") {
        echo "Product category cannot be empty!";
        exit();
    }
    $db->query('INSERT INTO products (product_name, product_desc, product_price, products_category) VALUES ("' . $product_name . '", "' . $product_desc . '", ' . $product_price . ', "' . $product_category . '")');
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    $id = $db->lastInsertId();
    if(!move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
        echo "error occured!";
        $db->query('UPDATE products SET image_link = "" WHERE id = "' . $id . '"');
    } else {
        $db->query('UPDATE products SET image_link = "' . $target_file . '" WHERE id = "' . $id . '"');
    }
    echo "Successfully added product!";
    sleep(2);
    header("Location: dashboard.php");
}

function uploadProductImage() {
    global $db;
    $target_dir = "img/";
    $id = $_POST['id'];
    $target_file = $target_dir . basename($_FILES["product_image_link"]["name"]);
    if(!move_uploaded_file($_FILES["product_image_link"]["tmp_name"], $target_file)) {
        echo "error occured!";
    }
    $db->query('UPDATE products SET image_link = "' . $target_file . '" WHERE id = "' . $id . '"');
    echo "Successfully updated product image!";
    sleep(2);
    header("Location: dashboard.php");
}

function saveUserChanges() {
    global $db;
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    if($name == "") {
        echo "Name cannot be empty!";
        exit();
    }
    $user_name = $_POST['username'];
    if($user_name == "") {
        echo "Username cannot be empty!";
        exit();
    }
    $email = $_POST['email'];
    if($email == "") {
        echo "Email cannot be empty!";
        exit();
    }
    $password = $_POST['password'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $created_at = $_POST['created_at'];
    
    $db->query('UPDATE users SET name = "' . $name . '", username = "' . $user_name . '", email = "' . $email . '", password = "' . $password . '", address = "' . $address . '", phone = "' . $phone . '", created_at = "' . $created_at . '" WHERE id = "' . $user_id . '"');
    echo "Successfully updated user!";
}

function deleteUser() {
    global $db;
    $user_id = $_POST['user_id'];
    $db->query('DELETE FROM users WHERE id = "' . $user_id . '"');
    echo "Successfully deleted user!";
}

function saveRewardChanges() {
    global $db;
    $id = $_POST['id'];
    if($id == "") {
        echo "ID cannot be empty!";
        exit();
    }
    $user_id = $_POST['user_id'];
    if($user_id == "") {
        echo "User ID cannot be empty!";
        exit();
    }
    $discount = $_POST['discount'];
    if($discount == "") {
        echo "Discount cannot be empty!";
        exit();
    }
    $discount_code = $_POST['discount_code'];
    if($discount_code == "") {
        echo "Discount code cannot be empty!";
        exit();
    }
    $used_code = $_POST['used_code'];
    $db->query('UPDATE reward_codes SET user_id = "' . $user_id . '", discount = "' . $discount . '", discount_code = "' . $discount_code . '", used_code = "' . $used_code . '" WHERE id = "' . $id . '"');
    echo "Successfully updated reward!";
}

function deleteReward() {
    global $db;
    $id = $_POST['id'];
    $db->query('DELETE FROM reward_codes WHERE id = "' . $id . '"');
    echo "Successfully deleted reward!";
}

function deleteFeedback() {
    global $db;
    $id = $_POST['id'];
    $db->query('DELETE FROM feedback WHERE id = "' . $id . '"');
    echo "Successfully deleted feedback!";
}

function saveProductChanges() {
    global $db;
    $id = $_POST['id'];
    if($id == "") {
        echo "ID cannot be empty!";
        exit();
    }
    $product_name = $_POST['product_name'];
    if($product_name == "") {
        echo "Product name cannot be empty!";
        exit();
    }
    $product_desc = $_POST['product_desc'];
    $product_price = $_POST['product_price'];
    if($product_price == "") {
        echo "Product price cannot be empty!";
        exit();
    }
    $products_category = $_POST['products_category'];
    $db->query('UPDATE products SET product_name = "' . $product_name . '", product_desc = "' . $product_desc . '", product_price = "' . $product_price . '", products_category = "' . $products_category . '" WHERE id = "' . $id . '"');
    echo "Successfully updated product!";
}

function deleteProduct() {
    global $db;
    $id = $_POST['id'];
    $db->query('DELETE FROM products WHERE id = "' . $id . '"');
    echo "Successfully deleted product!";
}

function saveShoppingChanges() {
    global $db;
    $id = $_POST['id'];
    if($id == "") {
        echo "ID cannot be empty!";
        exit();
    }
    $product_name = $_POST['product_name'];
    if($product_name == "") {
        echo "Product name cannot be empty!";
        exit();
    }
    $product_id = $_POST['product_id'];
    if($product_id == "") {
        echo "Product ID cannot be empty!";
        exit();
    }
    $product_price = $_POST['product_price'];
    if($product_price == "") {
        echo "Product price cannot be empty!";
        exit();
    }
    $product_quantity = $_POST['product_quantity'];
    if($product_quantity == "") {
        echo "Product quantity cannot be empty!";
        exit();
    }
    $shopping_cart_id = $_POST['shopping_cart_id'];
    if($shopping_cart_id == "") {
        echo "Shopping cart ID cannot be empty!";
        exit();
    }
    $image_link = $_POST['image_link'];
    $db->query('UPDATE shopping_cart SET product_name = "' . $product_name . '", product_id = "' . $product_id . '", product_price = "' . $product_price . '", product_quantity = "' . $product_quantity . '", cart_id = "' . $shopping_cart_id . '", image_link = "' . $image_link . '" WHERE id = "' . $id . '"');
}
function deleteShopping() {
    global $db;
    $id = $_POST['id'];
    $db->query('DELETE FROM shopping_cart WHERE id = "' . $id . '"');
    echo "Successfully deleted product!";
}

function deletePromotion() {
    global $db;
    $id = $_POST['id'];
    $db->query('DELETE FROM promotions WHERE id = "' . $id . '"');
}

function savePromotionChanges() {
    global $db;
    $id = $_POST['id'];
    $name = $_POST['name'];
    $original_price = $_POST['original_price'];
    $sale_price = $_POST['sale_price'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $details = $_POST['details'];
    $db->query('UPDATE promotions SET name = "' . $name . '", original_price = ' . $original_price . ', sale_price = ' . $sale_price . ', start_date = "' . $start_date . '", end_date = "' . $end_date . '", details = "' . $details . '" WHERE id = "' . $id . '"');
    echo "Successfully updated promotion!";
}

?>
