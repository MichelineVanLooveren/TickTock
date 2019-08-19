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
                header('Location: index.php');
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
  <link rel="stylesheet" href="css/style.css">
  <title><?php echo $title; ?></title> <!-- titel per pagina laten veranderen -->
</head>
  <body>  
    <section>
      <h1>Registratie</h1>
      <form action="registratie.php" method="post">
        <input type="hidden" name="action" value="insertUser">

        <label for="voornaam">Voornaam</label>
        <input type="text" name="voornaam" id="voornaam">

        <label for="achternaam">Achternaam</label>
        <input type="text" name="achternaam" id="achternaam">

        <label for="email">Email</label>
        <input type="email" name="email" id="email">

        <label for="paswoord">Paswoord</label>
        <input type="password" name="paswoord" id="paswoord">

        <input type="submit" value="Maak je TickTock-account aan">
      </form>
      <div>
        <p>Al een account? <a href="index.php">Log hier in</a></p>
      </div>
    </section>
  </body>
</html>