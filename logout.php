<?php
    session_start();
    $title = 'Logout'; // titel van de pagina
    $currentPage = 'Logout';

    session_destroy();
    setcookie('TickTock', null, time() - 3600); // cookie verwijderen
    header('location:index.php');
    exit();
?>
 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">
  <title><?php echo $title; ?></title> <!-- titel per pagina laten veranderen -->
</head>
  <body>  
  </body>
</html>