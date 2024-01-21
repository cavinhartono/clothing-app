<?php
require_once("../algoritma/Config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link rel="stylesheet" href="../style/output.css">
</head>

<body>
  <main class="container">
    <header class="fixed top-0 left-0 w-full px-24 py-6 flex justify-between items-center shadow-none transition-all -translate-y-0 z-10">
      <h1 class="font-medium text-lg">Clothing</h1>
      <ul class="flex gap-6">
        <li class="relative active"><a href="#">Home</a></li>
        <li class="relative"><a href="#">Products</a></li>
        <li class="relative"><a href="#">About</a></li>
      </ul>
      <ul class="flex gap-6">
        <li class="text-gray-800">
          <a href="#">
            <span class="w-6 h-6"></span>
          </a>
        </li>
        <li class="text-gray-800">
          <a href="#">
            <span class="w-6 h-6"></span>
          </a>
        </li>
      </ul>
    </header>
    <div class="relative w-full min-h-screen p-24 flex justify-between items-center gap-10">
      <?php

      $id = $_GET['id'];
      $products = mysqli_query(mysqli_connect("localhost", "root", "", "clothingshop"), "SELECT * FROM products WHERE `id`=$id;");
      while ($product = mysqli_fetch_array($products)) {
        $price = "Rp. " . number_format($product['price'], 0, ".", ".");
        echo "
          <img src='./gambar/$product[src]' class='w-full h-[400px] object-cover' />
          <div>
            <h1 class='font-serif text-6xl text-black text-justify'>$product[name]</h1>
            <h1 class='text-2xl mt-4 mb-6'>$price - Stock: $product[stock]</h1>
            <div class='my-4 flex'>
              <form action='./cart.php' method='POST'>
                <input type='number' name='qty' value='1' />
                <input type='hidden' name='product_id' value='$product[id]' />
                <button type='submit' name='submit' class='px-12 py-4 bg-blue-500 text-white rounded-sm'>Cart</button>
              </form>
            </div>
            $product[desc]
          </div>
        ";
      }
      ?>

    </div>
  </main>
</body>

</html>