<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 23/04/2014
 * Time: 09:00
 */
 /*
           ____________________
  __      /     ______         \
 {  \ ___/___ /       }         \
  {  /       / #      }          |
   {/ ô ô  ;       __}           |
   /          \__}    /  \       /\
<=(_    __<==/  |    /\___\     |  \
   (_ _(    |   |   |  |   |   /    #
    (_ (_   |   |   |  |   |   |
      (__<  |mm_|mm_|  |mm_|mm_|
*/
session_start();
include_once "../../datas/all.php";
include_once "../../php/functions.php";

if(!isConnected()){
    header("Location: /index.php");
    die();
}

include_once "../../php/header.php";
include_once "../../php/navbar.php";

?>
<?php
$dateTimeZone = new DateTimeZone("Europe/Paris");
$date = new DateTime('now', $dateTimeZone);
$date->sub(new DateInterval("P1M"));
$annee = $date->format("Y");
$mois = $date->format("n");
//$jour = $date->format("j");
$jourStart = 1;

$joursDansMois = $date->format("t");
$jourEnd = $joursDansMois;
$yearRange = range($annee-4, $annee);
?>
<div class="jumbotron">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <img src="/img/logo3.png" alt="Les Jardins de Beauval"/>
            </div>
            <div class="col-md-10">
                <h1>Statistiques</h1>
                <h2>Format Excel</h2>

            </div>
            <div class="col-md-10 col-md-offset-2"></div>
        </div>
    </div>
</div>
<?php if($msg = getFlash()): ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger"><p><strong>Erreur</strong> <?php echo $msg; ?></p></div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h3>Evolution des résultats mensuels</h3>
                </div>
                <p>Séléctionnez l'année</p>
            </div>
        </div>
        <form action="/survey/excel/global_year.php" method="post" id="form_excel_global">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2">
                            <select name="form_excel_global[annee]" id="form_excel_global_annee"  class="form-control">
                                <?php foreach($yearRange as $year): ?>
                                    <option value="<?php echo $year; ?>" <?php if($year == $annee) { echo 'selected="selected"'; } ?>><?php echo $year; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" id="submit_excel_global" class="btn btn-hotel">continuer &raquo;</button>
                            <div id="loader1" class="excel-loader">
                                <div id="excelSpinner1" class="excel-spinner"></div>
                                <p>génération du fichier en cours</p>
                            </div>

                            <div id="download-excel-global"><p><a href="" class="btn btn-hotel-inverse">télécharger</a></p></div>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- 
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h3>Données globales - sur un ou plusieurs mois</h3>
                </div>
                <p>Séléctionnez l'année</p>
            </div>
        </div>
        <form action="/survey/excel/global_month.php" method="post" id="form_excel_global_mensuel">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="form_excel_global_mensuel_annee">année</label>
                            <select class="form-control" name="form_excel_global_mensuel[annee]" id="form_excel_global_mensuel_annee">
                                <?php //  foreach($yearRange as $year): ?>
                                    <option value="<?php //  echo $year; ?>" <?php //  if($year == $annee) { echo 'selected="selected"'; } ?>><?php //  echo $year; ?></option>
                                <?php //  endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="form_excel_global_mensuel_month_start">début</label>
                            <select class="form-control" name="form_excel_global_mensuel[month_start]" id="form_excel_global_mensuel_month_start">
                                <?php //  for($i=0; $i<12;$i++): ?>
                                    <option value="<?php //  echo $i+1; ?>" <?php //  if($i+1 == $mois) { echo 'selected="selected"'; } ?>><?php //  echo ucfirst($datas_mois[$i]); ?></option>
                                <?php //  endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="form_excel_global_mensuel_month_end">fin</label>
                            <select class="form-control" name="form_excel_global_mensuel[month_end]" id="form_excel_global_mensuel_month_end">
                                <?php //  for($i=0; $i<12;$i++): ?>
                                    <option value="<?php //  echo $i+1; ?>" <?php //  if($i+1 == $mois) { echo 'selected="selected"'; } ?>><?php //  echo ucfirst($datas_mois[$i]); ?></option>
                                <?php //  endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
-->
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h3>Données brutes - sur l'année</h3>
                </div>
                <p>Séléctionnez l'année</p>
            </div>
        </div>
        <form action="/survey/excel/brutes.php" method="post" id="form_excel_brutes">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2">
                            <select name="form_excel_brutes[annee]" id="form_excel_global_brutes"  class="form-control">
                                <?php foreach($yearRange as $year): ?>
                                    <option value="<?php echo $year; ?>" <?php if($year == $annee) { echo 'selected="selected"'; } ?>><?php echo $year; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" id="submit_excel_brutes" class="btn btn-hotel">continuer &raquo;</button>
                            <div id="loader2" class="excel-loader">
                                <div id="excelSpinner2" class="excel-spinner"></div>
                                <p>génération du fichier en cours</p>
                            </div>

                            <div id="download-excel-brutes"><p><a href="" class="btn btn-hotel-inverse">télécharger</a></p></div>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="container">
    <hr/>
    <footer>
        <p>&copy; ZooParc de Beauval 2014</p>
    </footer>
</div>

<script src="/js/vendor/spin.min.js"></script>
<script src="/js/vendor/jquery.spin.js"></script>
<script src="/survey/js/apps/mainSurveyExcel.js"></script>

</body>
</html>
