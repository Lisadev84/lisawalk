<?php
session_start();
 if(!isset($_SESSION["user"])){
    header("Location: auth.php");
    exit;
}

unset($_SESSION["user"]);

header("Location: index.php");

?>