<?php
    $title = 'Detailpagina lijst';
    $date = date('Y-m-d'); //variabele geeft datum van vandaag weer
    include 'includes/header.inc.php';
    require_once __DIR__.'/classes/Lijst.class.php';
    require_once __DIR__.'/classes/Taak.class.php';
    $lijst = new Lijst();
    $taak = new Taak();

    //checkt of er een id aanwezig is in url
    if (isset($_GET['id'])) {
        $lijstId = $lijst->selectById($_GET['id']);
        //toggle
        //bron: https://stackoverflow.com/questions/39478480/verifying-if-checkbox-is-checked-in-php
        if (isset($_POST['toggle'])) {
            $taken = $taak->selectAllDesc($_GET['id']);
        } else {
            $taken = $taak->selectAllAsc($_GET['id']);
        }
    }

    //als er nog geen taken zijn
    if (empty($taken)) {
        echo '<p>Deze lijst heeft nog geen taken.</p>';
    }

    //als er nog geen lijsten zijn
    if (empty($lijstId)) {
        echo '<p>Deze lijst bestaat niet.</p>';
    } else {
        ?>

<section>
<a class="toevoegen" href="taakTo.php?id=<?php echo $lijstId['id']; ?>">Taak toevoegen</a> <!-- lijstid meegeven zodat op andere pagina ook bekend is en eruit kan gehaald worden -->
<a class="toevoegen" href="index.php"><--Terug</a>
<form method="POST">
    <input type="radio" name="toggle" checked>meeste-minste werkuren <!-- van meest naar minst -->
    <input type="radio" name="toggle" >minste-meeste werkuren <!-- van minst naar meest -->
    <input type="submit" value="Pas filter toe">
</form>
<h2><?php echo $lijstId['title']; ?></h2>
<ul>
    <!-- taken uitlezen en resterende dagen berekenen -->
    <?php foreach ($taken as $taak): ?>
        <li><a href="taakBw.php?id=<?php echo $taak['id']; ?>"><?php echo $taak['titel'];
        echo ' ('.$taak['werkuren'].' werkuren) '.'</a>';
        //bron: https://stackoverflow.com/questions/24608529/date-diff-expects-parameter-1-to-be-datetimeinterface-string-given/24608588
        $eindDatum = $taak['datum'];
        if ($date < $eindDatum) {
            $datetime1 = new DateTime(date('Y-m-d'));
            $datetime2 = new DateTime($eindDatum);
            $interval = $datetime1->diff($datetime2);
            echo $interval->format(' %a dagen resterend');
        } else {
            echo 'Deadline gemist!';
        } ?></li>
    <?php endforeach; ?>
</ul> 
</section>


<?php
    }
include 'includes/footer.inc.php'; ?>