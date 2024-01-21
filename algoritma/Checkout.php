<?php

require_once('./Config.php');

$auth = $_SESSION['auth'];

if (isset($_POST['submit'])) {
  $statement = $db->prepare("INSERT INTO orders(`product_id`, `user_id`, `qty`, `total`) 
                              VALUES (`:product_id`, `:user_id`, `:qty`, `:total`)");
  $statement->bindParam(":product_id", $_POST['product_id']);
  $statement->bindParam(":user_id", $auth);
  $statement->bindParam(":qty", $_POST['qty']);
  $statement->bindParam(":qty", $_POST['qty']);
}

// if(isset($_SESSION['cart'])) {
//   foreach ($_SESSION['cart'] as $cart) {
//     $orders = $db->prepare("INSERT INTO orders(`product_id`, `user_id`, `qty`, `total`) VALUES (`:product_id`, `:user_id`, `:qty`, `:total`)");
//     $orders->bindParam(":product_id", $cart['id']);
//     $orders->bindParam(":user_id", $auth);
//     $orders->bindParam(":qty", $cart['qty']);
//     $orders->bindParam(":total", $cart['total']);
//   }

//   unset($_SESSION['cart']);

//   $orders->execute();
// }

// header("Location: ./Cart.php");