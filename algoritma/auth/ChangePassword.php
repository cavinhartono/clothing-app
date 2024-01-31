<?php

include_once("../Config.php");

$id = $_SESSION['auth'];
$new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$statement = $db->prepare("UPDATE `users`
                            SET `password` = :password
                            WHERE `id` = $id");
$statement->bindParam(":password", $new_password);

$statement->execute();

echo "<script>alert('Mengubah password sukses!')</script>";

header("location: ../../halaman/home.php");
