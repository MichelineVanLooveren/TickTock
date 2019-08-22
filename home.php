<?php
    session_start();
    $title = 'Home'; // titel van de pagina
    $currentPage = 'home'; // gebruikt in check sessie
     // checken of gebruiker sessie heeft --> indien geen sessie redirecten naar login
    if (!isset($_SESSION['User']) && $currentPage != 'login') {
        header('location:index.php');
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

    $lijsten = $lijst->selectAllFromUser($_SESSION['User']['userId']);

    include 'includes/header.inc.php';
?>


    <section>
      <div class="home__container">
        <div class="lijstToevoegen">
        <a href="lijstTo.php" class="toevoegen"><label for="lijstToevoegen">Voeg een nieuwe lijst toe</label>
        <img src="assets/add.png" class="addImg" alt="add"></a>
        </div>
        <h2 class="admin__title">Overzicht lijsten</h2>
        <!--  data lijst db -->
        <ul class="overzichtLijsten">
            <?php foreach ($lijsten as $lijst):?> 
                <li>
                  <a href="lijst.php?id=<?php echo $lijst['id']; ?>"><?php echo $lijst['title']; ?></a>
                  <a class="confirmation" href="home.php?id=<?php echo $lijst['id']; ?>&amp;action=delete_lijst"><img src="assets/delete.png" class="deleteImg" alt="delete"></a>
                </li>
            <?php endforeach; ?>
        </ul>
        </div>
    </section>

    <!-- confirmation voor deleten --> 
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