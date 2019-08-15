<?php
 $title = 'Lijst toevoegen';
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
                header('Location: index.php');
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
    <h2>Lijst toevoegen</h2>
    <form action="lijstTo.php" method="post">
        <?php
            if (!empty($errors['title'])) { // als velden niet ingevuld zijn
                echo '<span class="error">'.$errors['title'].'</span>';
            }
        ?>
        <input type="hidden" name="action" value="insertlijst">
        <input type="text" name="title">
        <input type="submit" value="Lijst toevoegen">
    </form>
</section>

<?php include 'includes/footer.inc.php'; ?>