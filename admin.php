<?php
    $title = 'Admin';
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

<section>
<h2>Admin pagina</h2>
<article>
    <h3>Data app</h3>
    <p>Lijsten totaal:  <?php echo $lijsten['lijsten']; ?></p>
    <p>User totaal:  <?php echo $totaal['userTotaal']; ?></p>
    <p>users totaal:  <?php echo $users['users']; ?></p>
    <p>admins totaal:  <?php echo $admins['admins']; ?></p>

    <div>
        <h4>admin info</h4> <!-- overzicht van alle admins -->
        <ul>
            <?php foreach ($infoadmins as $info): ?>
                <li><?php echo $info['user_voornaam'].' '.$info['user_achternaam']; ?> <a class="confirmation" href="admin.php?id=<?php echo $info['id']; ?>&amp;action=delete_admin">X</a></li>
            <?php endforeach; ?>
        </ul>
    </div>

</article>
<article>
    <h3>Admin toevoegen</h3>
    <form action="admin.php" method="post">
        <input type="hidden" name="action"  value="insertadmin">
        <input type="text" name="user_voornaam" require placeholder="Voornaam">
        <input type="text" name="user_achternaam" require placeholder="Achternaam">
        <input type="email" name="email" require placeholder="E-mail">
        <input type="password" name="paswoord" require placeholder="Paswoord">
        <input type="submit" value="Nieuwe admin toevoegen">
    </form>
</article>
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