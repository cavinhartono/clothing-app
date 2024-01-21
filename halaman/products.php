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
        <li class="relative"><a href="./home.php">Home</a></li>
        <li class="relative active"><a href="./products.php">Products</a></li>
        <li class="relative"><a href="./transaction.php">About</a></li>
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
    <div class="relative w-full min-h-screen flex justify-center items-center">
      <div class="flex justify-center items-center">
        <img src="" class="absolute top-0 left-0 w-full h-full object-cover">
        <h1 class="font-serif text-white text-6xl">Discount the New of Year!</h1>
        <ul class="flex w-full p-24 justify-between gap-8">
          <?php
          $products = mysqli_query(mysqli_connect("localhost", "root", "", "clothingshop"), "SELECT * FROM products;");
          while ($product = mysqli_fetch_array($products)) {
            echo "
              <li class='relative shadow-md rounded-md overflow-hidden'>
                <a href='./product.php?id=$product[id]' class='flex flex-col gap-4'>
                  <img src='./gambar/$product[src]' class='w-full h-[300px] object-cover' />
                  <div class='flex justify-between items-center px-6 py-4'>
                    <div>
                      <h1 class='font-serif text-2xl text-black text-justify'>$product[name]</h1>
                      <h1 class='text-lg mt-2 mb-4'>$product[price] - Stock: $product[stock]</h1>
                    </div>
                  </div>
                </a>
              </li>
            ";
          }
          ?>
        </ul>
      </div>
    </div>
  </main>
</body>

</html>