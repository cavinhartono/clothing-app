<?php

include_once("../Config.php");

$id = $_SESSION['auth'];
$new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$users = $db->prepare("SELECT `email`
                      FROM `users`
                      WHERE `id` = $id");
$users->execute();

$user = $users->fetch(PDO::FETCH_ASSOC);

$email = $user['email'];

$statement = $db->prepare("UPDATE `users`
                            SET `password` = :password
                            WHERE `email` = '$email'");
$statement->bindParam(":password", $new_password);

$statement->execute();

echo "<script>alert('Mengubah password sukses!')</script>";

header("location: ../../halaman/home.php");
