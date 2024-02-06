<?php

require_once('./Config.php');

$auth = $_SESSION['auth'];

if (isset($_POST['submit'])) {
  $code = $_POST['code'];
  $payment_type = $_POST['payment_type'];

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

  $statement_two = $db->prepare("SELECT `id`, `balance` 
                                FROM `master_cards` 
                                WHERE `number_serial` = :code");
  $statement_two->bindParam(":code", $code);
  $statement_two->execute();

  $payment_id = $statement_two->fetch(PDO::FETCH_ASSOC);

  foreach ($carts as $cart) {
    $order = $db->prepare("INSERT INTO orders(`total`, `product_id`, `user_id`, `qty`, `address`, `payment_type`, `master_card_id`) 
                          VALUES (:total, :product_id, :user_id, :qty, :address, :payment_type, :master_card_id)");
    $order->bindParam(":total", $cart['subtotal']);
    $order->bindParam(":qty", $cart['qty']);
    $order->bindParam(":product_id", $cart['product_id']);
    $order->bindParam(":user_id", $_SESSION['auth']);
    $order->bindParam(":address", $_POST['address']);
    $order->bindParam(":payment_type", $payment_type);
    if (!empty($payment_id)) {
      if ($payment_id['balance'] > $subtotal) {
        $order->bindParam(":master_card_id", $payment_id['id']);
      } else {
        echo "<script>
          alert('Saldo kartu kredit Anda kurang!');
          window.location.href = '../halaman/cart.php';
        </script>";
      }
    } else {
      $order->bindParam(":master_card_id", null);
    }
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
