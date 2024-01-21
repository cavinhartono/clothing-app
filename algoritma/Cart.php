<?php

include_once("./Config.php");

if (isset($_POST['product_id'])) {
  $id = $_POST['product_id'];

  $getProduct = $db->prepare("SELECT * FROM `products` WHERE `id` = $id");
  $getProduct->execute();

  $product = $getProduct->fetchAll(PDO::FETCH_ASSOC);

  foreach ($product as $p) {
    $_SESSION['cart'][$id] = [
      'id' => $p['id'],
      'src' => $p['src'],
      'name' => $p['name'],
      'qty' => $_POST['qty'],
      'total' => $p['price'] * $_POST['qty']
    ];
  }
}

$subtotal = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <?php if (!empty($_SESSION['cart'])) : ?>
    <ul class="flex flex-col gap-6">
      <?php foreach ($_SESSION['cart'] as $cart) : ?>
        <li class="w-full flex gap-6">
          <a href="cancel.php?id=<?= $cart['id'] ?>">
            <img src="../halaman/gambar/<?= $cart['src'] ?>" class="w-[100px] h-[100px]">
            <div class="flex flex-col gap-4">
              <h1 class="text-black text-lg font-serif"><?= $cart['name'] ?></h1>
              <h1 class="text-gray-800 text-md">Rp. <?= number_format($cart['total'], 0, ".", ".") ?></h1>
            </div>
          </a>
        </li>
        <?php $subtotal += $cart['total'] ?>
      <?php endforeach ?>
      <h1><?= $subtotal ?></h1>
      <a href="./Checkout.php">Beli</a>
    </ul>
  <?php else : ?>
    <h1>Tidak ada</h1>
  <?php endif ?>
</body>

</html>