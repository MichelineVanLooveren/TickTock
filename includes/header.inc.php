<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css?family=Cabin|Raleway:300,400,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/login.css">
  <link rel="stylesheet" href="css/header.css">
  <title><?php echo $title; ?></title> <!-- titel per pagina laten veranderen -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
  <body>
    <header class="header">
        <h1 class="hidden">TickTock</h1> <!-- layout en SEO-score -->
       <a href="home.php"><img class="header__logo" src="assets/logov2.png" alt="logo"></a>
        <nav class=header>
            <ul class="header__menu">
                <?php if ($_SESSION['User']['isAdmin'] == 0):?> <!-- indien 0 wordt student-gedeelte getoond --> 
                <li><a class="menu__item__link" href="home.php">Home</a></li>
                <?php endif; ?>
                <?php if ($_SESSION['User']['isAdmin'] == 1):?> <!-- indien 1 wordt admin-gedeelte getoond --> 
                  <li><a class="menu__item__link" href="admin.php">Admin</a></li>
                <?php endif; ?>
                <li><a class="menu__item__link logout" href="logout.php">Logout?</a></li>
            </ul>
        </nav>
    </header>
    <main>