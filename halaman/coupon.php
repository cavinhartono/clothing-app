<?php

include_once("../algoritma/Config.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $name = $_POST['code'];

  $stmt = $db->prepare("SELECT `discount` FROM `coupons` WHERE `code` = :code");
  $stmt->bindParam(":code", $name);
  $stmt->execute();

  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (!empty($results)) {
    foreach ($results as $result) {
      echo "Anda mendapatkan diskon $result[discount]";
    }
  } else {
    echo null;
  }
}
