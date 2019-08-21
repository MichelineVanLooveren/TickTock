<?php
    session_start();
    $title = 'Home'; // titel van de pagina
    $currentPage = 'home'; // gebruikt in check sessie
     // checken of gebruiker sessie heeft --> indien geen sessie redirecten naar login
    if (!isset($_SESSION['User']) && $currentPage != 'login') {
        header('location:login.php');
        exit();
    }
    require_once __DIR__.'/classes/Lijst.class.php';
    require_once __DIR__.'/classes/Taak.class.php';

    $lijst = new Lijst();
    $taken = new Taak();

    if (!empty($_GET['id']) && !empty($_GET['action'])) {
        if ($_GET['action'] == 'delete_lijst') {
            $taken->delete($_GET['id']);
            $lijst->delete($_GET['id']);
        }
    }

    $lijsten = $lijst->selectAllFromUser($_SESSION["User"]["userId"]);

    include 'includes/header.inc.php';
?>


    <section>
        <a class="toevoegen" href="lijstTo.php">Lijst toevoegen</a>
        <h2>Overzicht lijsten</h2>
        <!--  data lijst db -->
        <ul>
            <?php foreach ($lijsten as $lijst):?> 
                <li>
                  <a href="lijst.php?id=<?php echo $lijst['id']; ?>"><?php echo $lijst['title']; ?></a>
                  <a class="confirmation" href="home.php?id=<?php echo $lijst['id']; ?>&amp;action=delete_lijst">X</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <script type="text/javascript">
    {
      const init = () => {
        const confirmationLinks = Array.from(document.getElementsByClassName(`confirmation`));
        confirmationLinks.forEach($confirmationLink => {
          $confirmationLink.addEventListener(`click`, e => {
            if (!confirm('Ben je zeker dat je deze lijst wilt verwijderen?')) e.preventDefault();
          });
        });
      };
      init();
    }
    </script>
<?php include 'includes/footer.inc.php'; ?>