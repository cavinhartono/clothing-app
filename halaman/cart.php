<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style/output.css">
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
  <main class="relative w-full p-[100px]">
    <form action='./transaction.php' method='POST'>
      <ul class="flex flex-col gap-6">
        <?php if (!empty($carts)) : ?>
          <?php foreach ($carts as $cart) : ?>
            <li class="w-full flex gap-6 items-center bg-white shadow-md px-4 py-8">
              <img src="./gambar/<?= $cart['src'] ?>" class="w-[100px] h-[100px] object-cover">
              <div class="flex flex-col gap-2">
                <h1 class="text-2xl font-serif"><?= $cart['name'] ?></h1>
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
      <ul class="relative w-full">
        <?php
        $users = $db->prepare("SELECT `name`, `email`, `address` FROM `users` WHERE `id` = $auth");
        $users->execute();

        $user = $users->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <?php foreach ($user as $u) : ?>
          <li class="relative w-full my-6 flex justify-between gap-8">
            <div class="flex flex-col gap-2 w-full  bg-white shadow-md px-4 py-8">
              <p class="text-lg">Full Name:</p>
              <input type="text" class="p-2" value="<?= $u['name']; ?>" disabled>
            </div>
            <div class="flex flex-col gap-2 w-full  bg-white shadow-md px-4 py-8">
              <p class="text-lg">Email:</p>
              <input type="text" class="p-2" value="<?= $u['email']; ?>" disabled>
            </div>
          </li>
          <li class="relative w-full my-6 flex justify-between gap-8">
            <div class="flex flex-col gap-2 w-full  bg-white shadow-md px-4 py-8">
              <p class="text-lg">Address:</p>
              <input type="text" class="p-2" value="<?= $u['address']; ?>" disabled>
            </div>
            <div class="flex flex-col gap-2 w-full  bg-white shadow-md px-4 py-8">
              <p class="text-lg">Phone Number:</p>
              <input type="text" class="p-2" value="081232134321" disabled>
            </div>
          </li>
        <?php endforeach; ?>

      </ul>
      <h1 class="text-lg px-4 py-8">Total, Rp. <?= number_format(($subtotal + 3000), 0, ".", ".") ?></h1>
      <button name='submit' <?php if (empty($carts)) : ?> disabled <?php endif; ?> class="w-[150px] py-4 bg-blue-600 text-white rounded-md">Buy</button>
    </form>
  </main>
</body>

</html>