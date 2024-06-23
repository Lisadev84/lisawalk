<?php
namespace App;

session_start();
require_once "Autoloader.php";
Autoloader::register();
$title = "Error";
require_once "includes/header.php";
?>

<body>
       <div class="wrapper" style="padding-top: 50px;" >
       <div class="container">
           
           <div class="content">
               <h1 style="font-size:4rem;text-align:center;">Oups ! une erreur est survenue</h1>
           </div>
       </div>
       </div>
<?php require_once 'includes/footer.php' ?>
