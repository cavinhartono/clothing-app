<?php

include_once("../Config.php");

$id = $_SESSION['auth'];

if (isset($_POST['submit'])) {
  $statement = $db->prepare("UPDATE `users`
                            SET `name` = :name, `email` = :email, `phone_number` = :phone_number, `address` = :address
                            WHERE `id` = $id");
  $statement->bindParam(":email", $_POST['email']);
  $statement->bindParam(":phone_number", $_POST['phone_number']);
  $statement->bindParam(":name", $_POST['name']);
  $statement->bindParam(":address", $_POST['address']);

  $statement->execute();

  echo "<script>alert('Update profil sukses!')</script>";
  header("Location: ../../halaman/profile.php");
}
