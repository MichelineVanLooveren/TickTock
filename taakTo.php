<?php
    session_start();
    $title = 'Taak toevoegen '; // titel van de pagina
    $currentPage = 'taakToevoegen'; // gebruikt in check sessie

    // checken of gebruiker sessie heeft --> indien geen sessie redirecten naar login
    if (!isset($_SESSION['User']) && $currentPage != 'login') {
        header('location:index.php');
        exit();
    }

    require_once __DIR__.'/classes/Taak.class.php';
    $taak = new Taak();

    if (!empty($_POST['action'])) {
        if ($_POST['action'] == 'insertTaak') {
            $datum = $_POST['datum'];
            if (empty($_POST['datum'])) { // deadline aan taak toevoegen is optioneel
                $datum = null;
            }
            $data = array(
                'titel' => $_POST['titel'],
                'werkuren' => $_POST['werkuren'],
                'datum' => $datum,
                'gedaan' => '0',
                'file' => '/',
                'lijstId' => $_GET['id'], // neemt id uit de url
            );

            // poging tot insert, indien niet gelukt de fouten ophalen uit de DAO class
            $insertTaak = $taak->insert($data);
            if ($insertTaak) {
                header('Location: lijst.php?id='.$_GET['id']); // redirecten naar lijst waaraan taak werd toegevoegd
                exit();
            }
            if (!$insertTaak) {
                $errors = $taak->validate($data);
            }
        }
    }

    include 'includes/header.inc.php';
?>

<section>
    <div class="taak__container">
    <h2 class="taak__title">Taak toevoegen</h2>
        <form action="taakTo.php?id=<?php echo $_GET['id']; ?>" method="post" class="taak__form"> <!-- id van lijst meegeven zodat in kolom lijstId opgeslagen kan worden in tabel taken --> 
            <?php
                if (!empty($errors['titel'])) {
                    echo '<span class="error">'.$errors['titel'].'</span>';
                }
            ?>
            <?php
                if (!empty($errors['werkuren'])) {
                    echo '<span class="error">'.$errors['werkuren'].'</span>';
                }
            ?>
            <input type="hidden" name="action" value="insertTaak">
            <div class="form__field">
            <input type="text" name="titel" placeholder="Titel taak" require class="inputField">
            </div>
            <div class="form__field">
            <input type="number" name="werkuren" min="1" max=24 require>
            </div>
            <div class="form__field">
            <input type="date" name="datum">
            </div>
            <input type="submit" value="Taak toevoegen" class="btn btn--primary">
        </form>
    </div>
</section>

<?php include 'includes/footer.inc.php'; ?>