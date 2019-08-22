<?php
    session_start();
    $title = 'Registratie'; // titel van de pagina
    $currentPage = 'registratie'; // gebruikt in check sessie

    require_once __DIR__.'/classes/User.class.php';
    $user = new User();

    if (!empty($_POST['action'])) {
        //checken of het juiste formulier verstuurd is
        if ($_POST['action'] == 'insertUser') {
            $data = array(
              'user_voornaam' => $_POST['voornaam'],
              'user_achternaam' => $_POST['achternaam'],
              'email' => $_POST['email'],
              'paswoord' => password_hash($_POST['paswoord'], PASSWORD_DEFAULT), //paswoord hashen
              'isAdmin' => '0', //isAdmin-boolean
          );
            // poging tot insert, indien niet gelukt de fouten ophalen uit de DAO class
            $insertUser = $user->insertUser($data);
            //als het niet lukt --> errors
            if (!$insertUser) {
                $errors = $admin->validate($data);
            } else {
                header('Location: home.php');
                exit();
            }
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
      <h1 class="form__title">Registratie TickTock</h1>
      <form action="" method="post" class="login__form">
        <input type="hidden" name="action" value="insertUser">

        <div class="form__field">
          <label for="voornaam">Voornaam</label>
          <input type="text" name="voornaam" id="voornaam" placeholder="Typ je voornaam" class="inputField">
        </div>

        <div class="form__field">
          <label for="achternaam">Achternaam</label>
          <input type="text" name="achternaam" id="achternaam" placeholder="Typ je achternaam" class="inputField">
        </div>
        
        <div class="form__field">
          <label for="email">Email</label>
          <input type="email" name="email" id="email" placeholder="Typ je e-mailadres" class="inputField">
        </div>

        <div class="form__field">
          <label for="paswoord">Wachtwoord</label>
          <input type="password" name="paswoord" id="paswoord" placeholder="Kies een wachtwoord" class="inputField">
        </div>

        <input type="submit" value="Maak je TickTock-account aan" class="btn btn--primary">
      </form>
      <div>
        <p id="alreadyAccount">Al een account? <a href="index.php">Log hier in</a></p>
      </div>
    </main>
    </div>
    </section>
  </body>
</html>