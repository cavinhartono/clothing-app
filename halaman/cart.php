<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<?php

require_once('../algoritma/Config.php');

$auth = $_SESSION['auth'];

if (!isset($auth)) {
  header("Location: login.php");
}

if (isset($_POST['submit'])) {
  $statement = $db->prepare("INSERT INTO carts(`user_id`, `product_id`, `qty`) VALUES (:user_id, :product_id, :qty)");
  $statement->bindParam(':product_id', $_POST['product_id']);
  $statement->bindParam(':user_id', $auth);
  $statement->bindParam(':qty', $_POST['qty']);
  $statement->execute();
  header("Location: ./cart.php");
}

$statement = $db->prepare("SELECT `products`.`id`, `name`, `price`, `src`, `carts`.`qty` FROM `products` 
                          INNER JOIN `carts` ON `carts`.`product_id` = `products`.`id` 
                          WHERE `carts`.`user_id` = $auth");
$statement->execute();

$carts = $statement->fetchAll(PDO::FETCH_ASSOC);

$subtotal = 0;

?>

<body>
  <main class="relative w-full overflow-hidden">
    <form action='./transaction.php' method='POST'>
      <ul class="flex flex-col gap-6">
        <?php if (!empty($carts)) : ?>
          <?php foreach ($carts as $cart) : ?>
            <li class="w-full flex gap-6 bg-white shadow-md px-4 py-8">
              <img src="./gambar/<?= $cart['src'] ?>" class="w-[100px] h-[100px]">
              <div class="flex flex-col gap-4">
                <h1 class="text-lg font-serif"><?= $cart['name'] ?></h1>
                <p class="opacity-75 text-md">Rp. <?= number_format($cart['price'], 0, ".", ".") ?> X <?= $cart['qty'] ?></p>
              </div>
            </li>
            <?php $subtotal += $cart['price'] * $cart['qty'] ?>
          <?php endforeach; ?>
          <li class="w-full bg-white shadow-md px-4 py-8">
            <h1 class="text-lg">Ongkir</h1>
            <p class="opacity-75 text-md">Rp. 3.000</p>
          </li>
        <?php endif; ?>
      </ul>
      <h1 class="text-black text-lg">Total, Rp. <?= number_format(($subtotal + 3000), 0, ".", ".") ?></h1>
      <button name='submit' <?php if (empty($carts)) : ?> disabled <?php endif; ?>>Buy</button>
    </form>
  </main>
</body>

</html>