<?php

include_once("../algoritma/Config.php");

$id = $_SESSION['auth'];

if (!isset($id)) {
  echo "<script>window.location.href = 'login.php';</script>";
}

$users = $db->prepare("SELECT * FROM `users` WHERE `id` = $id");
$users->execute();

$user = $users->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style/output.css">
  <title>Edit Profile</title>
</head>

<body class="h-screen flex justify-center items-center bg-[#f5f5f5]">
  <main class="relative w-full p-[100px]">
    <?php foreach ($user as $u) : ?>
      <form action="../algoritma/auth/Update.php" method="POST" class="p-8 bg-white shadow-md">
        <ul class="flex gap-6">
          <li class="w-full flex flex-col gap-2">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= $u['name'] ?>" class="border p-2 rounded-md">
          </li>
          <li class="w-full flex flex-col gap-2">
            <label for="email">Email</label>
            <input type="text" id="email" name="email" value="<?= $u['email'] ?>" class="border p-2 rounded-md">
          </li>
        </ul>
        <ul class="my-3 flex gap-6">
          <li class="w-full flex flex-col gap-2">
            <label for="phone_number">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number" value="<?= $u['phone_number'] ?>" class="border p-2 rounded-md">
          </li>
          <li class="w-full flex flex-col gap-2">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" value="<?= $u['address'] ?>" class="border p-2 rounded-md">
          </li>
        </ul>
        <button type="submit" name="submit" class="my-4 px-12 py-4 bg-blue-500 w-full text-md text-white rounded-sm">Continue</button>
      </form>
    <?php endforeach; ?>
  </main>
</body>

</html>