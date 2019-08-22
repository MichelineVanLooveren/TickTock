<?php
    session_start();
    $title = 'Lijst toevoegen'; // titel van de pagina
    $currentPage = 'lijstToevoegen'; // gebruikt in check sessie

     // checken of gebruiker sessie heeft --> indien geen sessie redirecten naar login
    if (!isset($_SESSION['User']) && $currentPage != 'login') {
        header('location:index.php');
        exit();
    }

    require_once __DIR__.'/classes/Lijst.class.php';
    $lijst = new Lijst();

    if (!empty($_POST['action'])) {
        if ($_POST['action'] == 'insertlijst') {
            $data = array(
                'title' => $_POST['title'],
            );
            // poging tot insert, indien niet gelukt de fouten ophalen uit de DAO class
            $insertLijst = $lijst->insert($data);
            if ($insertLijst) {
                header('Location: home.php');
                exit();
            }
            if (!$insertLijst) {
                $errors = $lijst->validate($data);
            }
        }
    }

    include 'includes/header.inc.php';
?>

<section>
    <div class="lijstTo__container">
        <h2 class="lijstTo__title">Lijst toevoegen</h2>
        <form action="" method="post" class="lijstTo__form">
            <?php
                if (!empty($errors['title'])) { // als velden niet ingevuld zijn
                    echo '<span class="error">'.$errors['title'].'</span>';
                }
            ?>
            <input type="hidden" name="action" value="insertlijst">
            <div class="form__field">
            <input type="text" name="title" placeholder="Naam nieuwe lijst" class="inputField">
            </div>
            <input type="submit" value="Lijst toevoegen" class="btn btn--primary">
        </form>
    </div>
</section>

<?php include 'includes/footer.inc.php'; ?>