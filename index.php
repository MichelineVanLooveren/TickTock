<?php
    $title = 'Login'; // titel van de pagina
    $currentPage = 'login'; // gebruikt in check sessie

    require_once __DIR__.'/classes/User.class.php'; // klasse user oproepen
    $login = new User();

    session_start();

    //login gedeelte
    if (!empty($_POST)) {
        if (isset($_POST['action']) == 'login') {
            if (empty($_POST['username']) || empty($_POST['paswoord'])) {
                $error = 'E-mailadres of wachtwoord is niet ingevuld';
            } else {
                $user = $login->selectLogin($_POST['username']);

                if (!empty($user)) {
                    if (password_verify($_POST['paswoord'], $user['paswoord'])) {
                        $data = array(
                'title' => $_POST['username'],
                'isAdmin' => $user['isAdmin'],
              );
                        $_SESSION['User'] = $data;
                        header('location:home.php');
                        exit();
                    } else {
                        $error = 'Het opgegeven wachtwoord is niet correct';
                    }
                } else {
                    $error = 'E-mailadres of wachtwoord is niet correct';
                    exit();
                }
            }
        } else {
            echo 'Error';
        }
    }
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
    <section>
      <h1>Login</h1>
      <?php if (!empty($error)): ?> 
        <div class="error"><?php echo $error; ?></div>
      <?php endif; ?>
      <form action="index.php" method="post">
        <input type="hidden" name="action" value="login">
        
        <label for="username">Email</label>
        <input type="text" name="username" id="username">

        <label for="paswoord">Paswoord</label>
        <input type="password" name="paswoord" id="paswoord">

        <input type="submit" value="login">
      </form>
      <a href="registratie.php">registreer hier</a>
    </section>
  </body>
</html>