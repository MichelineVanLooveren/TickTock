<?php
    $title = 'Taak toevoegen ';
    require_once __DIR__.'/classes/Taak.class.php';
    $taak = new Taak();

    if (!empty($_POST['action'])) {
        if ($_POST['action'] == 'insertTaak') {
            $data = array(
                'titel' => $_POST['titel'],
                'werkuren' => $_POST['werkuren'],
                'datum' => $_POST['datum'],
                'gedaan' => '0',
                'file' => '/',
                'lijstId' => $_GET['id'], //neem id uit de url
            );
            // poging tot insert, indien niet gelukt de fouten ophalen uit de DAO class

            $insertTaak = $taak->insert($data);
            if ($insertTaak) {
                header('Location: lijst.php?id='.$_GET['id']); //!redirecten naar lijst waaraan taak werd toegevoegd
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
    <h2>Taak toevoegen</h2>
    <form action="taakTo.php?id=<?php echo $_GET['id']; ?>" method="post"> <!-- id van lijst meegeven zodat in kolom lijstId opgeslagen kan worden in tabel taken --> 
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
        <input type="text" name="titel" require>
        <input type="number" name="werkuren" min="1" max=24 require>
        <input type="date" name="datum">
        <input type="submit" value="Taak toevoegen">
    </form>
</section>

<?php include 'includes/footer.inc.php'; ?>