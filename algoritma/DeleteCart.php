<?php

include_once("./Config.php");

$id = $_GET['id'];
$auth = $_SESSION['auth'];

$statement = $db->prepare("DELETE FROM `carts` WHERE `id` = $id");
$statement->execute();

header("Location: ../halaman/cart.php");
