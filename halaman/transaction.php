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
  if (isset($_POST['submit'])) {
    $subtotal_query = "`products`.`price` * `qty`";
    $statement = $db->prepare("SELECT `carts`.`product_id`, `carts`.`qty`,
                              CASE 
                                  WHEN `carts`.`product_id` = `products`.`id` THEN 
                                      (`products`.`price` * `carts`.`qty`) * `discounts`.`discount`
                                  ELSE `products`.`price` * `carts`.`qty`
                              END AS `subtotal` FROM `carts`
                              JOIN `products` ON `carts`.`product_id` = `products`.`id` 
                              JOIN `discounts` ON `discounts`.`product_id` = `products`.`id`
                              WHERE (`orders`.`user_id` = {$_SESSION['auth']})");
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

</html>