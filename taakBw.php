<?php
    session_start();
    $title = 'Taak bewerken'; //titel van de pagina
    $currentPage = 'taakBewerken'; // gebruikt in check sessie

     // checken of gebruiker sessie heeft --> indien geen sessie redirecten naar login
    if (!isset($_SESSION['User']) && $currentPage != 'login') {
        header('location:index.php');
        exit();
    }

    include 'includes/header.inc.php';

    require_once __DIR__.'/classes/Taak.class.php';
    $taak1 = new Taak();

    if (isset($_GET['id'])) {
        $taak = $taak1->selectById($_GET['id']);
    }

    //taken aanpassen
    if (!empty($_POST['action'])) {
        if ($_POST['action'] == 'bewerkTaak') {
            $taak['titel'] = $_POST['titel'];
            $taak['werkuren'] = $_POST['werkuren'];
            $datum = $_POST['datum'];
            if (empty($_POST['datum'])) {
                $datum = null;
            }
            $taak['datum'] = $datum;
            $updatedTaak = $taak1->update($taak);
            if (empty($updatedTaak)) {
                $errors = $taak1->validate($taak);
            }
        }
    }

?>

<section>
    <div class="taak__container">
    <h2 class="taak__title">Taak bewerken</h2>
    <form action="taakBw.php?id=<?php echo $taak['id']; ?>" method="post" class="taak__form">
    <input type="hidden" name="action" value="bewerkTaak">
    <div class="form__field">
        <input type="text" name="titel" require value="<?php echo $taak['titel']; ?>" placeholder="Bewerk titel taak" class="inputField">
    </div> 
    <div class="form__field">
        <input type="number" name="werkuren" min="1" max=24 require value="<?php echo $taak['werkuren']; ?>">
    </div> 
    <div class="form__field">
        <input type="date" name="datum" value="<?php echo $taak['datum']; ?>">
    </div> 
    <input type="submit" value="Taak bewerken" class="btn btn--primary">
    </form>
</section>

<?php include 'includes/footer.inc.php'; ?>