<?php

include_once("../algoritma/Config.php");

$name = $_POST['code'];

$statement = $db->prepare("SELECT `id`, `name`, `balance` FROM `master_cards` WHERE `number_serial` = :code");
$statement->bindParam(":code", $name);
$statement->execute();

$results = $statement->fetch(PDO::FETCH_ASSOC);

if (!empty($results)) {
  $balance = number_format($results['balance'], 0, ".", ".");
  echo "$results[id]. $results[name] - Rp. $balance";
} else {
  echo "Tidak ada";
}
