<?php
require_once("../Config.php");

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $statement = $db->prepare("SELECT * FROM `users` WHERE `email` = :email");
  $statement->bindParam(":email", $email, PDO::PARAM_STR);
  $statement->execute();

  $auth = $statement->fetch(PDO::FETCH_ASSOC);

  if ($auth && password_verify($password, $auth['password'])) {
    $_SESSION['auth'] = $auth['id'];
    $_SESSION['counter'] = 0;
    header("Location: ../../halaman/home.php");
  }
}
