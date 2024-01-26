<?php

require_once('./Config.php');

$auth = $_SESSION['auth'];

if (isset($_POST['submit'])) {
  $statement = $db->prepare("SELECT `carts`.`product_id`, `carts`.`qty`,
                              CASE 
                                  WHEN `discounts`.`product_id` = `products`.`id` THEN 
                                      (`products`.`price` * `discounts`.`discount`) * `carts`.`qty`
                                  ELSE `products`.`price` * `carts`.`qty`
                              END AS `subtotal` FROM `carts`
                              LEFT JOIN `products` ON `carts`.`product_id` = `products`.`id` 
                              LEFT JOIN `discounts` ON `discounts`.`product_id` = `products`.`id`
                              WHERE `carts`.`user_id` = $auth");
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

  echo "
    <script>
      window.location.href = '../halaman/profile.php';
      alert('Pesanan Anda sukses!');
    </script>
  ";
}
