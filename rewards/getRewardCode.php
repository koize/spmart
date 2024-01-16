<?php
session_start();
if (!isset($_COOKIE['id'])) {
    echo 'You are not logged in! Log in to get rewards while playing!';
    exit();
}

$userID = $_COOKIE['id'];
function generateRewardCodes() { //taking in stuff(probs ID/score?)
    $rewardCode = "";
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for ($i = 0; $i < 20; $i++) {
        $rewardCode .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $rewardCode;
}

$rewardCode = generateRewardCodes();
function getRewardLevel() {
    $rewardLevel = -1;
    if(!isset($_COOKIE['hscore'])) {
        return -1;
    }
    if ($_COOKIE['hscore'] >= 100) {
        $rewardLevel = 10;
    } else if ($_COOKIE['hscore'] >= 50) {
        $rewardLevel = 5;
    } else if ($_COOKIE['hscore'] >= 10) {
        $rewardLevel = 2;
    }
    return $rewardLevel;
}
if(getRewardLevel() == -1) {
    echo "Play the game to get rewards!";
    exit();
}
//echo "<code>" . generateRewardCodes() . "</code>";
//create connection to SQL database using PDO
$db = new PDO("mysql:host=localhost;dbname=seesad", "root", "");
$query = $db->query('CREATE DATABASE IF NOT EXISTS seesad');
//this thing doesn't work yet, I'll have to mess around with the DB first... 
$query = $db->query('CREATE TABLE IF NOT EXISTS reward_codes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    discount INT NOT NULL,
    discount_code VARCHAR(20) NOT NULL,
    used_code BIT,
    user_id INT UNSIGNED,
    FOREIGN KEY (user_id) REFERENCES users(id)
    )');
$query = $db->query('INSERT IGNORE INTO reward_codes (id, discount, discount_code, used_code, user_id) VALUES ("1","5", "AAAAAAAAAAAAAAAAAAAA", 0,"1")');

$query = $db->query('SELECT * FROM reward_codes WHERE user_id = "' . $userID . '"');
if($query->rowCount() == 3) {
    echo "You have already generated 3 codes! Use them to get discounts!";
    exit();
} else {
    foreach($query as $row) {
        if($row['discount'] == getRewardLevel()) {
            echo "You have already generated a code with this discount!";
            exit();
        }
    }
    $query = $db->query('INSERT INTO reward_codes (discount, discount_code, used_code, user_id) 
    VALUES ("' . getRewardLevel() . '", "' . $rewardCode . '", 0, "' . $userID .'")');
}
echo "<br/><h5>Your unique code is: <code>" . $rewardCode . "</code>" . "<br/>You'll only see this code once." .
    "</h5><br>Copy this code and use it when purchasing to receive your <code>" . getRewardLevel() . "</code>% discount!";

?>