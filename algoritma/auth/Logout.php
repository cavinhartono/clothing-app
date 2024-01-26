<?php

session_start();

unset($_SESSION['auth']);

header('Location: ../../halaman/login.php');
