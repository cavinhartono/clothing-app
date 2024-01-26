<?php

include_once("../algoritma/Config.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $statement = $db->prepare("SELECT * FROM `users` WHERE `email` = :email");
    $statement->bindParam(":email", $email, PDO::PARAM_STR);
    $statement->execute();

    $auth = $statement->fetch(PDO::FETCH_ASSOC);

    if ($auth && password_verify($password, $auth['password'])) {
      $_SESSION['auth'] = $auth['id'];
      $_SESSION['name'] = explode(" ", $auth['name'])[0];
      $_SESSION['counter'] = 0;
      header("Location: ../halaman/home.php");
    } else {
      $_SESSION['counter']++;
      if ($_SESSION['counter'] > 3) {
        $_SESSION['counter'] = 0;
        echo "<script>
        alert('Anda sudah melebihi 3 dan halaman ini akan otomatis close');
        window.close();
        </script>";
      }
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style/output.css">
  <title><?= $_SESSION['counter'] ?> Login</title>
</head>

<body class="bg-gray-200 flex justify-center items-center min-h-screen">
  <form method="post" class="w-[400px] py-12 px-8 rounded-md bg-white shadow-sm">
    <h1 class="font-serif text-2xl text-black">Log in Account</h1>
    <div class="relative w-full mt-10 mb-6">
      <input type="text" id="email" name="email" class="peer w-full px-3 py-2 border placeholder:text-transparent" placeholder="email" required>
      <label for="email" class="absolute left-0 ml-1 -translate-y-6 text-sm duration-100 ease-linear peer-placeholder-shown:translate-y-2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:-translate-y-6 peer-focus:text-sm">Email</label>
    </div>
    <div class="relative w-full my-6">
      <input type="password" name="password" id="password" placeholder="Password" required class="peer w-full px-3 py-2 border placeholder:text-transparent">
      <label for="password" class="absolute left-0 ml-1 -translate-y-6 text-sm duration-100 ease-linear peer-placeholder-shown:translate-y-2 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-500 peer-focus:-translate-y-6 peer-focus:text-sm">Password</label>
    </div>
    <button type="submit" name="submit" class="bg-blue-500 w-full py-2 text-md text-white rounded-sm">Continue</button>
    <p class="my-4 text-sm">Do you haven't account? <a href="./register.php" class="text-blue-500">Register</a>.</p>
  </form>
</body>

</html>