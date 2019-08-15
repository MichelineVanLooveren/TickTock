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
  <main>
    <header class="header">
        <h1 class="hidden">TickTock</h1> <!-- layout en SEO-score -->
        <img class="header__logo" src="assets/logo.png" alt="logo">
        <nav>
            <ul class="header__menu">
                <li><a class="menu__item__link" href="index.php">Home</a></li>
                <li><a class="menu__item__link" href="admin.php">Admin</a></li>
            </ul>
        </nav>
    </header>
    <main>