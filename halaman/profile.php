<!DOCTYPE html>
<html lang="en">

<?php

require_once('../algoritma/Config.php');

$auth = $_SESSION['auth'];

if (!isset($auth)) {
  $_SESSION['counter'] = 0;
  echo "<script>window.location.href ='login.php'</script>";
}

$statement_one = $db->prepare("SELECT * FROM `users` WHERE `id` = $auth");
$statement_one->execute();

$user = $statement_one->fetchAll(PDO::FETCH_ASSOC);

$statement_two = $db->prepare("SELECT `orders`.`id`, `products`.`src`, `products`.`name`, `total`, `status`, `date`, `qty`, `created_at` 
                              FROM `orders` 
                              INNER JOIN `products` ON `orders`.`product_id` = `products`.`id`
                              WHERE `user_id` = $auth
                              ORDER BY `date` DESC
                              ");
$statement_two->execute();

$orders = $statement_two->fetchAll(PDO::FETCH_ASSOC);

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style/output.css">
  <title>Profile</title>
</head>

<body>
  <main class="relative w-full overflow-hidden">
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
      <a href="./cart.php" class="relative flex gap-2 items-center">
        Cart
        <span class="w-4 h-4">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M4.00488 16V4H2.00488V2H5.00488C5.55717 2 6.00488 2.44772 6.00488 3V15H18.4433L20.4433 7H8.00488V5H21.7241C22.2764 5 22.7241 5.44772 22.7241 6C22.7241 6.08176 22.7141 6.16322 22.6942 6.24254L20.1942 16.2425C20.083 16.6877 19.683 17 19.2241 17H5.00488C4.4526 17 4.00488 16.5523 4.00488 16ZM6.00488 23C4.90031 23 4.00488 22.1046 4.00488 21C4.00488 19.8954 4.90031 19 6.00488 19C7.10945 19 8.00488 19.8954 8.00488 21C8.00488 22.1046 7.10945 23 6.00488 23ZM18.0049 23C16.9003 23 16.0049 22.1046 16.0049 21C16.0049 19.8954 16.9003 19 18.0049 19C19.1095 19 20.0049 19.8954 20.0049 21C20.0049 22.1046 19.1095 23 18.0049 23Z"></path>
          </svg>
        </span>
      </a>
    </header>
    <div class="relative p-[100px] bg-white rounded-sm">
      <div class="p-8">
        <?php foreach ($user as $u) : ?>
          <div class="w-full flex justify-between items-center p-4">
            <div class="flex flex-col gap-2">
              <h1 class="font-serif text-5xl"><?= $u['name'] ?></h1>
              <p class="text-2xl opacity-75"><?= $u['email'] ?></p>
            </div>
            <ul class="flex flex-col items-end">
              <li>
                <a href="./edit_profile.php" class="flex items-center gap-2">
                  Edit
                  <span class="w-4 h-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M2 11.9998C2 11.1353 2.1097 10.2964 2.31595 9.49631C3.40622 9.55283 4.48848 9.01015 5.0718 7.99982C5.65467 6.99025 5.58406 5.78271 4.99121 4.86701C6.18354 3.69529 7.66832 2.82022 9.32603 2.36133C9.8222 3.33385 10.8333 3.99982 12 3.99982C13.1667 3.99982 14.1778 3.33385 14.674 2.36133C16.3317 2.82022 17.8165 3.69529 19.0088 4.86701C18.4159 5.78271 18.3453 6.99025 18.9282 7.99982C19.5115 9.01015 20.5938 9.55283 21.6841 9.49631C21.8903 10.2964 22 11.1353 22 11.9998C22 12.8643 21.8903 13.7032 21.6841 14.5033C20.5938 14.4468 19.5115 14.9895 18.9282 15.9998C18.3453 17.0094 18.4159 18.2169 19.0088 19.1326C17.8165 20.3043 16.3317 21.1794 14.674 21.6383C14.1778 20.6658 13.1667 19.9998 12 19.9998C10.8333 19.9998 9.8222 20.6658 9.32603 21.6383C7.66832 21.1794 6.18354 20.3043 4.99121 19.1326C5.58406 18.2169 5.65467 17.0094 5.0718 15.9998C4.48848 14.9895 3.40622 14.4468 2.31595 14.5033C2.1097 13.7032 2 12.8643 2 11.9998ZM6.80385 14.9998C7.43395 16.0912 7.61458 17.3459 7.36818 18.5236C7.77597 18.8138 8.21005 19.0652 8.66489 19.2741C9.56176 18.4712 10.7392 17.9998 12 17.9998C13.2608 17.9998 14.4382 18.4712 15.3351 19.2741C15.7899 19.0652 16.224 18.8138 16.6318 18.5236C16.3854 17.3459 16.566 16.0912 17.1962 14.9998C17.8262 13.9085 18.8225 13.1248 19.9655 12.7493C19.9884 12.5015 20 12.2516 20 11.9998C20 11.7481 19.9884 11.4981 19.9655 11.2504C18.8225 10.8749 17.8262 10.0912 17.1962 8.99982C16.566 7.90845 16.3854 6.65378 16.6318 5.47605C16.224 5.18588 15.7899 4.93447 15.3351 4.72552C14.4382 5.52844 13.2608 5.99982 12 5.99982C10.7392 5.99982 9.56176 5.52844 8.66489 4.72552C8.21005 4.93447 7.77597 5.18588 7.36818 5.47605C7.61458 6.65378 7.43395 7.90845 6.80385 8.99982C6.17376 10.0912 5.17754 10.8749 4.03451 11.2504C4.01157 11.4981 4 11.7481 4 11.9998C4 12.2516 4.01157 12.5015 4.03451 12.7493C5.17754 13.1248 6.17376 13.9085 6.80385 14.9998ZM12 14.9998C10.3431 14.9998 9 13.6567 9 11.9998C9 10.343 10.3431 8.99982 12 8.99982C13.6569 8.99982 15 10.343 15 11.9998C15 13.6567 13.6569 14.9998 12 14.9998ZM12 12.9998C12.5523 12.9998 13 12.5521 13 11.9998C13 11.4475 12.5523 10.9998 12 10.9998C11.4477 10.9998 11 11.4475 11 11.9998C11 12.5521 11.4477 12.9998 12 12.9998Z"></path>
                    </svg>
                  </span>
                </a>
              </li>
              <li>
                <a href="../algoritma/auth/Logout.php" class="flex justify-end items-center gap-2">
                  Logout
                  <span class="w-4 h-4">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                      <path d="M5 22C4.44772 22 4 21.5523 4 21V3C4 2.44772 4.44772 2 5 2H19C19.5523 2 20 2.44772 20 3V6H18V4H6V20H18V18H20V21C20 21.5523 19.5523 22 19 22H5ZM18 16V13H11V11H18V8L23 12L18 16Z"></path>
                    </svg>
                  </span>
                </a>
              </li>
            </ul>
          </div>
        <?php endforeach; ?>
        <section class="my-8">
          <h1 class="px-4 text-2xl font-semibold">Transaksi</h1>
          <?php if (!empty($orders)) : ?>
            <ul class="flex flex-col gap-4 my-4">
              <?php foreach ($orders as $order) : ?>
                <li class="relative p-4 flex gap-8 items-center rounded-md shadow-md">
                  <img src="./gambar/<?= $order['src'] ?>" class="w-[100px] h-[100px] object-cover">
                  <div class="w-full flex justify-between items-center gap-2">
                    <div class="mx-4">
                      <?php if ($order['status'] == 'pending') : ?>
                        <span class="px-4 py-2 bg-orange-500 text-white rounded-full">
                          <?php
                          $date = new DateTime("now");

                          if ($order['date'] > $date) {
                            $statement = $db->prepare("UPDATE `orders`
                                                      SET `status` = 'paid'
                                                      WHERE `id` = $order[id]");
                            $days = "";
                            $statement->execute();
                          } else {
                            $calculated = $date->diff(new DateTime($order['date']));
                            if ($calculated->days <= 1) {
                              $days = "$calculated->days day to go";
                            } else {
                              $days = "$calculated->days days to go";
                            }
                          }

                          echo $days;
                          ?>
                        </span>
                      <?php else : ?>
                        <span class="px-4 py-2 bg-green-600 text-white rounded-full">
                          Complete
                        </span>
                      <?php endif ?>
                      <h1 class="mt-2 text-2xl font-serif"><?= $order['name'] ?></h1>
                      <p class="text-lg opacity-75"><?= $order['qty'] ?> - Rp. <?= number_format($order['total'], 0, ".", "."); ?></p>
                    </div>
                    <h1 class="text-lg opacity-75">
                      <?php
                      $date = new DateTime();

                      $calculated = $date->diff(new DateTime($order['created_at']));

                      if ($calculated->days > 0) {
                        $within_last_days = "$calculated->days hari lalu";
                      } else {
                        $within_last_days = "Saat ini";
                      }

                      echo $within_last_days;
                      ?>
                    </h1>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php else : ?>
            <h1 class="my-6 text-lg">Anda belum membeli melakukan transaksi</h1>
          <?php endif; ?>
        </section>
      </div>
    </div>
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
</body>

</html>