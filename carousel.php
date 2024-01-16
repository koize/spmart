<?php

// Connect to the MySQL database
$db = new PDO('mysql:host=localhost;dbname=seesad', 'root', '');

// Fetch the promotions
$query = $db->query('SELECT * FROM promotions');
$promotions = $query->fetchAll();

// Generate the HTML code for the carousel
echo '<div class="carousel slide" id="promotions">';
echo '<ol class="carousel-indicators">';
foreach ($promotions as $index => $promotion) {
  echo '<li data-target="#promotions" data-slide-to="' . $index . '" class="active"></li>';
}
echo '</ol>';
echo '<div class="carousel-inner">';
foreach ($promotions as $index => $promotion) {
  echo '<div class="item active">';
    echo '<img src="' . $promotion['image'] . '" alt="' . $promotion['name'] . '">';
  echo '<div class="carousel-caption">';
  echo '<h3>' . $promotion['title'] . '</h3>';
  echo '<p>' . $promotion['start_date'] . ' - ' . $promotion['end_date'] . '</p>';
  echo '</div>';
  echo '</div>';
}
echo '</div>';
echo '<a class="left carousel-control" href="#promotions" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>';
echo '<a class="right carousel-control" href="#promotions" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>';
echo '</div>';

?>