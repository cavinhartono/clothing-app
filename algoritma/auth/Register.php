<?php

require_once("../Config.php");

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $name = $_POST['name'];
  $address = $_POST['address'];

  $statement = $db->prepare("INSERT INTO users(name, email, address, password) VALUES (:name, :email, :address, :password)");
  $statement->bindParam(":name", $name, PDO::PARAM_STR);
  $statement->bindParam(":email", $email, PDO::PARAM_STR);
  $statement->bindParam(":address", $address, PDO::PARAM_STR);
  $statement->bindParam(":password", $password, PDO::PARAM_STR);

  if ($statement->execute()) header("location: ../../halaman/home.php");
  else header('location: ../../halaman/auth/register.php');
}
