<?php

include_once("../algoritma/Config.php");

$name = $_POST['code'];

$stmt = $db->prepare("SELECT `id`, `name`, `balance` FROM `master_cards` WHERE `number_serial` = :code");
$stmt->bindParam(":code", $name);
$stmt->execute();

$results = $stmt->fetch(PDO::FETCH_ASSOC);

if (!empty($results)) {
  $balance = number_format($results['balance'], 0, ".", ".");
  echo "$results[id]. $results[name] - $balance";
} else {
  echo "Tidak ada";
}
