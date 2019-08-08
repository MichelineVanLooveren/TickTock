<?php
//foutboodschappen via try catch
require_once 'bootstrap.php';

if (!empty($_POST)) {
    $list = new Lijst();
    $list->setList_name($_POST['listName']);
    $list->createList();
}

?>
<!DOCTYPE html>
<?php
include_once 'includes/head.inc.php';
?>
<body>
    <form action="" method="post">
        <label for="listName">Maak een nieuwe lijst aan</label>
        <input type="text" id="listName" name="listName">
        <input type="submit" value="Maak lijst aan">
    </form>
</body>
</html>