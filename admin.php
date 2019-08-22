<?php
    session_start();
    $title = 'Admin'; // titel van de pagina
    $currentPage = 'admin'; // gebruikt in check sessie

     // checken of gebruiker sessie heeft --> indien geen sessie redirecten naar login
    if (!isset($_SESSION['User']) && $currentPage != 'login') {
        header('location:index.php');
        exit();
    }

    include 'includes/header.inc.php';

    require_once __DIR__.'/classes/Admin.class.php';
    $admin = new Admin();

    //checken of er een formulier verstuurd is
    if (!empty($_POST['action'])) {
        //checken of het juiste formulier verstuurd is
        if ($_POST['action'] == 'insertadmin') {
            $data = array(
                'user_voornaam' => $_POST['user_voornaam'],
                'user_achternaam' => $_POST['user_achternaam'],
                'email' => $_POST['email'],
                'paswoord' => password_hash($_POST['paswoord'], PASSWORD_DEFAULT), //paswoord hashen
                'isAdmin' => '1', //isAdmin-boolean
            );
            // poging tot insert, indien niet gelukt de fouten ophalen uit de DAO class
            $insertAdmin = $admin->insertadmin($data);
            //als het niet lukt --> errors
            if (!$insertAdmin) {
                $errors = $admin->validate($data);
            }
        }
    }

    //checken voor id en delete-actie in url; als dat er niet is, dan kan admin dus niet verwijderd worden
    if (!empty($_GET['id']) && !empty($_GET['action'])) {
        //checken of juiste delete-actie er is
        if ($_GET['action'] == 'delete_admin') {
            $admin->delete($_GET['id']);
        }
    }

    //queries voor data uit te halen --> moeten na delete-functie zodat alles nog eens ingeladen wordt
    $infoadmins = $admin->selectAllAdminInfo();
    $lijsten = $admin->selectAllLijsten();
    $totaal = $admin->selectAllUsersTotaal();
    $users = $admin->selectAllUsers();
    $admins = $admin->selectAllAdmins();

?>

<section >
    <div class="admin__container">
        <h2 class="admin__title">Admin pagina</h2>
        <article>
            <h3 class="admin__title">Data app</h3>
            <p>Totaal aantal lijsten:  <?php echo $lijsten['lijsten']; ?></p>
            <p>Totaal aantal gebruikers:  <?php echo $totaal['userTotaal']; ?></p>
            <p>Totaal aantal studenten:  <?php echo $users['users']; ?></p>
            <p>Totaal aantal admins:  <?php echo $admins['admins']; ?></p>

            <div>
                <h3 class="admin__title">Overzicht admins:</h3> <!-- overzicht van alle admins -->
                <ul>
                    <?php foreach ($infoadmins as $info): ?>
                        <li><?php echo $info['user_voornaam'].' '.$info['user_achternaam']; ?> <a class="confirmation" href="admin.php?id=<?php echo $info['id']; ?>&amp;action=delete_admin"><img src="assets/delete.png" class="deleteImg" alt="delete"></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </article>
        <article>
            <div class="admin__container"></div>
            <h3 class="admin__title">Admin toevoegen</h3>
            <form action="" method="post" class="admin__form">
                <input type="hidden" name="action"  value="insertadmin">
                <div class="form__field">
                <input type="text" name="user_voornaam" require placeholder="Voornaam" class="inputField">
                </div>
                <div class="form__field">
                <input type="text" name="user_achternaam" require placeholder="Achternaam" class="inputField">
                </div>
                <div class="form__field">
                <input type="email" name="email" require placeholder="E-mail" class="inputField">
                </div>
                <div class="form__field">
                <input type="password" name="paswoord" require placeholder="Paswoord" class="inputField">
                </div>
                <input type="submit" value="Nieuwe admin toevoegen" class="btn btn--primary">
            </form>
        </article>
</div>
</section>

<!-- script checkt array en gaat zoeken naar elementen met klasse confirmation en dan gaat na klik vragen of je zeker bent--> 
<script type="text/javascript">
    {
      const init = () => {
        const confirmationLinks = Array.from(document.getElementsByClassName(`confirmation`));
        confirmationLinks.forEach($confirmationLink => {
          $confirmationLink.addEventListener(`click`, e => {
            if (!confirm('Ben je zeker dat je deze admin wilt verwijderen?')) e.preventDefault(); //veld blijft staan tot je klikt (houdt default-gedrag tegen)
          });
        });
      };
      init();
    }
    </script>

<?php include 'includes/footer.inc.php'; ?>