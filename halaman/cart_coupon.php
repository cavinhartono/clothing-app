<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style/output.css">
  <title>Cart</title>
</head>

<?php

require_once('../algoritma/Config.php');

$auth = $_SESSION['auth'];

if (!isset($auth)) {
  $_SESSION['counter'] = 0;
  echo "<script>window.location.href ='login.php'</script>";
}

if (isset($_POST['submit'])) {
  $statement = $db->prepare("INSERT INTO carts(`user_id`, `product_id`, `qty`) VALUES (:user_id, :product_id, :qty)");
  $statement->bindParam(':product_id', $_POST['product_id']);
  $statement->bindParam(':user_id', $auth);
  $statement->bindParam(':qty', $_POST['qty']);
  $statement->execute();
  header("Location: ./cart.php");
}

$statement = $db->prepare("SELECT `carts`.`id`, `products`.`name`, `products`.`price`, `products`.`src`, `carts`.`qty`,
                          CASE
                              WHEN `discounts`.`product_id` = `products`.`id` THEN 
                                  `products`.`price` * `discounts`.`discount`
                              ELSE `products`.`price`
                          END AS `discounted_price` FROM `carts`
                          LEFT JOIN `products` ON `carts`.`product_id` = `products`.`id`
                          LEFT JOIN `discounts` ON `discounts`.`product_id` = `products`.`id`
                          WHERE `carts`.`user_id` = $auth");
$statement->execute();

$carts = $statement->fetchAll(PDO::FETCH_ASSOC);

$subtotal = 0;

?>

<body>
  <main class="relative w-full p-[100px]">
    <header class="fixed top-0 left-0 w-full px-32 py-10 flex justify-between items-center shadow-none transition-all -translate-y-0 z-10">
      <a href="./home.php" class="relative flex gap-2 items-center">
        <span class="w-4 h-4">
          <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 512 512">
            <polyline points="244 400 100 256 244 112" style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:48px" />
            <line x1="120" y1="256" x2="412" y2="256" style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:48px" />
          </svg>
        </span>
        Back
      </a>
      <a href="./profile.php" class="relative flex gap-2 items-center">
        Profile
        <span class="w-4 h-4">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M20 22H18V20C18 18.3431 16.6569 17 15 17H9C7.34315 17 6 18.3431 6 20V22H4V20C4 17.2386 6.23858 15 9 15H15C17.7614 15 20 17.2386 20 20V22ZM12 13C8.68629 13 6 10.3137 6 7C6 3.68629 8.68629 1 12 1C15.3137 1 18 3.68629 18 7C18 10.3137 15.3137 13 12 13ZM12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z"></path>
          </svg>
        </span>
      </a>
    </header>
    <form action='../algoritma/Checkout.php' method='POST'>
      <ul class="flex flex-col gap-6">
        <?php if (!empty($carts)) : ?>
          <?php foreach ($carts as $cart) : ?>
            <li class="w-full bg-white shadow-md px-4 py-8">
              <a href="../algoritma/DeleteCart.php?id=<?= $cart['id'] ?>" class="flex gap-6 items-center">
                <img src="./gambar/<?= $cart['src'] ?>" class="w-[100px] h-[100px] object-cover">
                <div class="flex flex-col gap-2">
                  <h1 class="text-2xl font-serif"><?= $cart['name'] ?></h1>
                  <?php if ($cart['price'] == $cart['discounted_price']) : ?>
                    <p class="opacity-75 text-md">Rp. <?= number_format($cart['price'], 0, ".", ".") ?> X <?= $cart['qty'] ?></p>
                  <?php else : ?>
                    <p class="opacity-75 text-md">
                      <s>Rp. <?= number_format($cart['price'], 0, ".", ".") ?></s>
                      Rp. <?= number_format($cart['discounted_price'], 0, ".", ".") ?> X <?= $cart['qty'] ?>
                    </p>
                  <?php endif; ?>
                </div>
              </a>
            </li>
            <?php $subtotal += $cart['discounted_price'] * $cart['qty'] ?>
          <?php endforeach; ?>
          <li class="w-full bg-white shadow-md px-4 py-8">
            <h1 class="text-lg">Ongkir</h1>
            <p class="opacity-75 text-md">Rp. 3.000</p>
          </li>
          <?php $subtotal += 3000 ?>
          <h1 class="text-lg px-4 py-8" id="displayDiscount">
            Total, Rp. <span id="total"><?= number_format($subtotal, 0, ".", ".") ?></span>
          </h1>
          <input type="hidden" name="subtotal" id="subtotal" value="<?= $subtotal ?>">
          <div class="flex gap-8">
            <input type="text" name="code" id="coupon" class="w-full border uppercase">
            <button type="button" onclick="getDiscount()" class="bg-blue-600 text-white w-full py-4 px-2">Try</button>
          </div>
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
                  <input type="text" class="p-2" name="address" value="<?= $u['address']; ?>">
                </div>
                <div class="flex flex-col gap-2 w-full  bg-white shadow-md px-4 py-8">
                  <p class="text-lg">Phone Number:</p>
                  <input type="text" class="p-2" value="081232134321" disabled>
                </div>
              </li>
              <li class="relative w-full my-6 flex justify-between gap-8">
                <div class="flex flex-col gap-2 w-full  bg-white shadow-md px-4 py-8">
                  <p class="text-lg">Payment Type:</p>
                  <select onchange="showTunai()" name="payment_type" id="paymentType">
                    <option value="cod">COD</option>
                    <option value="tunai">Tunai</option>
                  </select>
                </div>
                <div class="flex flex-col gap-2 w-full  bg-white shadow-md px-4 py-8">
                  <p class="text-lg">Master Card:</p>
                  <input type="text" id="masterCard" class="p-2" disabled>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
          <button name='submit' <?php if (empty($carts)) : ?> disabled <?php endif; ?> class="w-[150px] py-4 bg-blue-600 text-white rounded-md disabled:opacity-50">Buy</button>
        <?php else : ?>
          <li class="w-full bg-white shadow-md px-4 py-8">
            <h1 class="text-lg">Tidak ada produk di keranjang!</h1>
          </li>
        <?php endif; ?>
      </ul>
    </form>
    <footer class="py-4">&copy; Tugas Logika dan Algoritma oleh Kelompok 8&trade;</footer>
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

    function showTunai() {
      var selectedOption = document.querySelector("#paymentType").value;
      var masterCard = document.querySelector("#masterCard");

      switch (selectedOption) {
        case "cod":
          masterCard.disabled = true;
          break;
        case "tunai":
          masterCard.disabled = false;
          break;
      }
    }

    function getDiscount() {
      var total = document.querySelector("#total").innerText;
      fetch("coupon.php", {
          method: 'POST',
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: "code=" + encodeURIComponent(document.querySelector("#coupon").value)
        })
        .then(response => response.text())
        .then(result => {
          let discountedPrice = parseFloat(total) - (parseFloat(total) * result);
          var formattedNumber = new Intl.NumberFormat('id-ID').format(discountedPrice);
          document.querySelector("#displayDiscount").innerHTML = `Total, <s>Rp. <span id="total">${total}</span></s> <span id='subtotal'>Rp. ${formattedNumber}rb</span>`
        })
        .catch(error => console.error(error));
    }
  </script>
</body>

</html>