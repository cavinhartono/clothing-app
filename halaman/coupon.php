<?php

include_once("../algoritma/Config.php");

$name = $_POST['code'];

$stmt = $db->prepare("SELECT `discount` FROM `coupons` WHERE `code` = :code");
$stmt->bindParam(":code", $name);
$stmt->execute();

$results = $stmt->fetch(PDO::FETCH_ASSOC);

if (!empty($results)) {
  echo $results['discount'];
} else {
  echo null;
}
