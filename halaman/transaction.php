<!DOCTYPE html>
<html lang="en">

<?php include_once("../algoritma/Config.php") ?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tranaksi</title>
</head>

<body>
  <?php

  $products = "Tidak ada";

  if (isset($_POST['submit'])) {
    $statement = $db->prepare("SELECT `carts`.`product_id`, `carts`.`qty` * `products`.`price` AS `subtotal`, `carts`.`qty` FROM `products`
                          INNER JOIN `carts` ON `carts`.`product_id` = `products`.`id`
                          WHERE `user_id` = {$_SESSION['auth']}");
    $statement->execute();

    $carts = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($carts as $cart) {
      $order = $db->prepare("INSERT INTO orders(`total`, `product_id`, `user_id`, `qty`) 
                          VALUES (:total, :product_id, :user_id, :qty)");
      $order->bindParam(":total", $cart['subtotal']);
      $order->bindParam(":qty", $cart['qty']);
      $order->bindParam(":product_id", $cart['product_id']);
      $order->bindParam(":user_id", $_SESSION['auth']);
      $order->execute();

      $delete_carts = $db->prepare("DELETE FROM `carts` WHERE `user_id` = {$_SESSION['auth']}");
      $delete_carts->execute();
    }
  }
  ?>
</body>

<!-- <?php if ($cart->status == 'pending') : ?>
  <span class="text-red-600 bg-red-300 border-red-600 rounded-md">
    Pesanan akan datang ke tujuan
  </span>
<?php else : ?>
  <span class="text-green-600 bg-green-300 border-green-600 rounded-md">
    Pesanan Anda sudah sampai tujuan
  </span>
<?php endif ?> -->

</html>