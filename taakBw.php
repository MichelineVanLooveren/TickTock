<?php
    $title = 'Taak bewerken';
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
            $taak['datum'] = $_POST['datum'];
            $updatedTaak = $taak1->update($taak);
            if (empty($updatedTaak)) {
                $errors = $taak1->validate($taak);
            }
        }
    }
?>

<section>
    <h2>Taak bewerken</h2>
    <form action="taakBw.php?id=<?php echo $taak['id']; ?>" method="post">
    <input type="hidden" name="action" value="bewerkTaak">
        <input type="text" name="titel" require value="<?php echo $taak['titel']; ?>">
        <input type="number" name="werkuren" min="1" max=24 require value="<?php echo $taak['werkuren']; ?>">
        <input type="date" name="datum" value="<?php echo $taak['datum']; ?>">
        <input type="submit" value="Taak bewerken">
    </form>
</section>

<?php include 'includes/footer.inc.php'; ?>