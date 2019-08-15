<?php
    $title = 'Home';
    require_once __DIR__.'/classes/Lijst.class.php';

    $lijst = new Lijst();

    if (!empty($_GET['id']) && !empty($_GET['action'])) {
        if ($_GET['action'] == 'delete_lijst') {
            $lijst->delete($_GET['id']);
        }
    }

    $lijsten = $lijst->selectAll();

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
                  <a class="confirmation" href="index.php?id=<?php echo $lijst['id']; ?>&amp;action=delete_lijst">X</a>
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