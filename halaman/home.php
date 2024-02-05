<!DOCTYPE html>
<html lang="en">

<?php

include_once('../algoritma/Config.php');

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style/output.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <title>Home</title>
</head>

<body>
  <main class="relative w-full overflow-hidden">
    <h1 class="fixed bottom-0 left-0 px-4 py-2 bg-green-500 text-white text-2xl transition-all z-10" id="greeting">Hello, <?= !empty($_SESSION['name']) ? $_SESSION['name'] : "User" ?></h1>
    <header class="fixed top-0 left-0 w-full px-24 py-10 flex justify-between items-center shadow-none transition-all -translate-y-0 z-10">
      <h1 class="font-medium text-white">BajuOnlen</h1>
      <ul class="flex gap-6">
        <li class="relative text-white"><a href="./home.php">Home</a></li>
        <li class="relative text-white opacity-75"><a href="./products.php">Products</a></li>
        <li class="relative text-white opacity-75"><a href="./about.php">About</a></li>
      </ul>
      <ul class="flex gap-6">
        <li class="relative text-white">
          <a href="./cart.php">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M4.00488 16V4H2.00488V2H5.00488C5.55717 2 6.00488 2.44772 6.00488 3V15H18.4433L20.4433 7H8.00488V5H21.7241C22.2764 5 22.7241 5.44772 22.7241 6C22.7241 6.08176 22.7141 6.16322 22.6942 6.24254L20.1942 16.2425C20.083 16.6877 19.683 17 19.2241 17H5.00488C4.4526 17 4.00488 16.5523 4.00488 16ZM6.00488 23C4.90031 23 4.00488 22.1046 4.00488 21C4.00488 19.8954 4.90031 19 6.00488 19C7.10945 19 8.00488 19.8954 8.00488 21C8.00488 22.1046 7.10945 23 6.00488 23ZM18.0049 23C16.9003 23 16.0049 22.1046 16.0049 21C16.0049 19.8954 16.9003 19 18.0049 19C19.1095 19 20.0049 19.8954 20.0049 21C20.0049 22.1046 19.1095 23 18.0049 23Z"></path>
            </svg>
          </a>
        </li>
        <li class="relative text-white">
          <a href="./profile.php">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
              <path d="M20 22H18V20C18 18.3431 16.6569 17 15 17H9C7.34315 17 6 18.3431 6 20V22H4V20C4 17.2386 6.23858 15 9 15H15C17.7614 15 20 17.2386 20 20V22ZM12 13C8.68629 13 6 10.3137 6 7C6 3.68629 8.68629 1 12 1C15.3137 1 18 3.68629 18 7C18 10.3137 15.3137 13 12 13ZM12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z"></path>
            </svg>
          </a>
        </li>
      </ul>
    </header>
    <div class="relative p-[100px] w-full max-h-screen bg-gradient-to-b from-[#850E0E] to-[#990000] flex gap-40 justify-between items-center">
      <h1 class="relative text-white" id="text-homepage">
        <span class="text-6xl"> Discount All Item up to</span> <br>
        <span class="text-[96px] font-extrabold py-8">75</span><s class="text-[48px] font-extrabold">%</s>
      </h1>
      <img data-aos="zoom-in-up" src="./gambar/hero_image.png" class="w-[450px] h-[610px]">
    </div>
    <div class="p-6 flex w-[200%]" id="marquee">
      <h1 class="text-[76px]"><span id="discount">DISCOUNT ALL ITEM</span> UP TO 75%</h1>
      <h1 class="text-[76px]"><span id="discount">DISCOUNT ALL ITEM</span> UP TO 75%</h1>
    </div>
    <section class="p-[100px] w-full flex justify-center gap-24 items-center">
      <img src="./gambar/product_17.png" class="w-[350px] h-auto">
      <div class="flex flex-col gap-8">
        <h1 data-aos="fade-up" data-aos-anchor-placement="center-bottom" class="w-[150px] py-2 bg-blue-500 rounded-full text-white text-center">Coming Soon</h1>
        <h1 data-aos="fade-up" data-aos-delay="300" data-aos-anchor-placement="center-bottom" class="text-6xl font-serif text-[#2B334A]">Leather Jacket <br /> Biawak Aseli</h1>
        <div data-aos="fade-up" data-aos-delay="600" data-aos-anchor-placement="center-bottom" class="relative">
          <h1 class="text-3xl font-serif opacity-50"><s>Rp. 400.000</s></h1>
          <h1 class="text-5xl font-serif">Rp. 300.000</h1>
        </div>
      </div>
    </section>
    <section class="p-[100px] w-full flex justify-center gap-24 items-center">
      <ul class="flex gap-8 justify-between items-center">
        <?php

        $statement = $db->prepare("SELECT `discounts`.`product_id`, `src`, `discounts`.`discount` FROM `products` 
                                INNER JOIN `discounts` ON `products`.`id` = `discounts`.`product_id`");
        $statement->execute();

        $products = $statement->fetchAll(PDO::FETCH_ASSOC);

        ?>
        <?php foreach ($products as $product) : ?>
          <li class='group relative'>
            <a href='./product.php?id=<?= $product['product_id'] ?>'>
              <img src='./gambar/<?= $product['src'] ?>' class='w-[350px] h-auto'>
              <div class='absolute top-0 left-0 w-full h-full bg-gradient-to-t from-[#222222BF] to-[#22222200] flex justify-center items-center overflow-hidden opacity-0 transition-all group-hover:overflow-visible group-hover:opacity-100'>
                <h1 class='font-serif text-8xl text-white'><?= $product['discount'] * 100 ?>%</h1>
              </div>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </section>
    <footer class="pb-4 px-[100px]">&copy; Tugas Logika dan Algoritma oleh Kelompok 8&trade;</footer>
  </main>
  <script>
    const header = document.querySelector('header');

    function scrolled() {
      if (window.pageYOffset > 100) {
        header.classList.add('-translate-y-20', 'shadow-md');
      } else {
        header.classList.remove('-translate-y-20', 'shadow-md');
      }
    }

    window.addEventListener('scroll', scrolled);
  </script>
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>

</html>