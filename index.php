<?php
    $title = 'Login'; // titel van de pagina
    $currentPage = 'login'; // gebruikt in check sessie

    require_once __DIR__.'/classes/User.class.php'; // klasse user oproepen
    $login = new User();

    session_start();

    // login gedeelte
    if (!empty($_POST)) {
        if (isset($_POST['action']) == 'login') {
            if (empty($_POST['username']) || empty($_POST['paswoord'])) {
                $error = 'E-mailadres of wachtwoord is niet ingevuld';
            } else {
                $user = $login->selectLogin($_POST['username']);

                if (!empty($user)) {
                    if (password_verify($_POST['paswoord'], $user['paswoord'])) {
                        $data = array(
                'userId' => $user['id'],
                'title' => $_POST['username'],
                'isAdmin' => $user['isAdmin'],
              );
                        $_SESSION['User'] = $data;
                        if ($_SESSION['User']['isAdmin'] == 0) {
                            header('location:home.php'); // voor user naar home.php
                            exit();
                        } else {
                            header('location:admin.php'); // voor admin naar admin.php
                            exit();
                        }
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
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/login.css">
  <title><?php echo $title; ?></title> <!-- titel per pagina laten veranderen -->
</head>
  <body>  
    <section>
      <div class="login__container">
        <header class="login"></header>
        <main class="login">
          <h1 class="form__title">Login TickTock</h1>
          <?php if (!empty($error)): ?> 
            <div class="form_error"><?php echo $error; ?></div>
          <?php endif; ?>
          <form action="" method="post" class="login__form">
            <input type="hidden" name="action" value="login">

            <div class="form__field">
              <label for="username">E-mailadres</label>
              <input type="text" name="username" id="username" placeholder="Typ je e-mailadres" class="inputField">
            </div>

            <div class="form__field">
              <label for="paswoord">Wachtwoord</label>
              <input type="password" name="paswoord" id="paswoord" placeholder="Typ je wachtwoord" class="inputField">
            </div>

            <input type="submit" value="Meld me aan" class="btn btn--primary">
          </form>
        
        <div>
          <p id="newAccount">Nog geen account? <a href="registratie.php">Registreer hier</a></p>
        </div>
        </main>
      </div>
    </section>
  </body>
</html>