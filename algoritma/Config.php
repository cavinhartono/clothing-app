<?php
session_start();

try {
  $db = new PDO("mysql:host=localhost;dbname=clothingshop", "root", "");
} catch (\Throwable $th) {
  die($th->getMessage());
}
