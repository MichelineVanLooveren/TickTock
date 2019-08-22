<?php
    session_start();
    $title = 'Detailpagina lijst'; // titel van deze pagina
    $currentPage = 'detaillijst'; // gebruikt in check sessie

    // checken of gebruiker sessie heeft --> indien geen sessie redirecten naar login
    if (!isset($_SESSION['User']) && $currentPage != 'login') {
        header('location:index.php');
        exit();
    }

    $date = date('Y-m-d'); // variabele geeft datum van vandaag weer
    include 'includes/header.inc.php';
    require_once __DIR__.'/classes/Lijst.class.php'; // klasse lijst oproepen
    require_once __DIR__.'/classes/Taak.class.php'; // klasse taak oproepen
    $lijst = new Lijst();
    $taak = new Taak();

    // checkt of er een id aanwezig is in url
    if (isset($_GET['id'])) {
        $lijstId = $lijst->selectById($_GET['id']);
        //toggle
        //bron: https://stackoverflow.com/questions/39478480/verifying-if-checkbox-is-checked-in-php
        if (isset($_POST['toggle'])) {
            if ($_POST['toggle'] == 'asc') {
                $taken = $taak->selectAllWuAsc($_GET['id']);
            }
        }
        if (isset($_POST['toggle'])) {
            if ($_POST['toggle'] == 'desc') {
                $taken = $taak->selectAllWuDesc($_GET['id']);
            }
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
    }

    // delete taak
        if (!empty($_GET['id']) && !empty($_GET['action'])) {
            if ($_GET['action'] == 'delete_taak') {
                $taken->deleteTaak($_GET['id']);
            }
        }
?>

<section>
    <div class="lijst__container">
        <a href="home.php"><img src="assets/back.png" class="goBack" alt="goBack"></a><br>
        <div class="taakToevoegen">
        <a class="toevoegen" href="taakTo.php?id=<?php echo $lijstId['id']; ?>"><label for="taakToevoegen">Taak toevoegen</label><img src="assets/add.png" class="addImg" alt="add"></a> <!-- lijstid meegeven zodat op andere pagina ook bekend is en eruit kan gehaald worden -->
        </div>
        <form method="POST" class="filter">
            <label>Filter o.b.v. werkuren:</label>
            <div class="container">
                <input type="checkbox" name="toggle" value="desc">meest-minst <!-- van meest naar minst -->
                <span class="checkmark"></span>
            </div>
            <div class="container">
                <input type="checkbox" name="toggle" value="asc">minst-meest <!-- van minst naar meest -->
                <span class="checkmark"></span>
            </div>
            <input type="submit" value="Pas filter toe" class="filterBtn">
        </form>
        <h2 class="taak__title">Taken in: <?php echo $lijstId['title']; ?></h2>
        <ul>
            <!-- taken uitlezen en resterende dagen berekenen -->
            <?php foreach ($taken as $taak): ?>
                <li>
                    <a href="taakBw.php?id=<?php echo $taak['id']; ?>"><?php echo $taak['titel'];
                    echo ' ('.$taak['werkuren'].'u werk) '.'</a>';
                    //bron: https://stackoverflow.com/questions/24608529/date-diff-expects-parameter-1-to-be-datetimeinterface-string-given/24608588
                    $eindDatum = $taak['datum'];
                    if ($date < $eindDatum) {
                        $datetime1 = new DateTime(date('Y-m-d'));
                        $datetime2 = new DateTime($eindDatum);
                        $interval = $datetime1->diff($datetime2);
                        echo $interval->format(' %a dagen resterend');
                    } else {
                        echo 'Deadline gemist!';
                    } ?>

                    <!-- comment achterlaten op taak met AJAX -->
                    <!-- bron: https://www.webslesson.info/2017/12/comments-system-using-php-and-ajax.html --> 
                    <!-- <div class="container">
                        <form method="POST" id="comment_form">
                            <label for="comment">Schrijf een opmerking bij deze taak:</label>
                            <div class="form-group">
                                <input type="text" name="comment_name" id="comment_name" class="form-control" placeholder="Enter Name" />
                            </div>-->
                        <!-- <div class="form-group">
                                <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Enter Comment" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="comment_id" id="comment_id" value="0" />
                                <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
                            </div>
                        </form>
                        <span id="comment_message"></span>
                        <br />
                        <div id="display_comment"></div>
                    </div>-->

                    <!-- taak markeren als to do/done met AJAX -->

                    <!-- delete taak !!!!! werkt niet--> 
                    <a class="confirmation" href="lijst.php?id=<?php echo $taak['id']; ?>&amp;action=delete_taak"></a><img src="assets/delete.png" class="deleteImg" alt="delete"></li>


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
            if (!confirm('Ben je zeker dat je deze taak wilt verwijderen?')) e.preventDefault();
          });
        });
      };
      init();
    }
    </script>

<?php
include 'includes/footer.inc.php'; ?>

<!--  script voor comment --> 
<script>
$(document).ready(function(){
 
 $('#comment_form').on('submit', function(event){
  event.preventDefault();
  var form_data = $(this).serialize();
  $.ajax({
   url:"ajax/addComment.php",
   method:"POST",
   data:form_data,
   dataType:"JSON",
   success:function(data)
   {
    if(data.error != '')
    {
     $('#comment_form')[0].reset();
     $('#comment_message').html(data.error);
     $('#comment_id').val('0');
     load_comment();
    }
   }
  })
 });

 load_comment();

 function load_comment()
 {
  $.ajax({
   url:"ajax/fetchComment.php",
   method:"POST",
   success:function(data)
   {
    $('#display_comment').html(data);
   }
  })
 }

 $(document).on('click', '.reply', function(){
  var comment_id = $(this).attr("id");
  $('#comment_id').val(comment_id);
  $('#comment_name').focus();
 });
 
});
</script>