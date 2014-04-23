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

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="page-header page-header-hotel">
                    <h3>Obtenir toutes les données sous forme de fichier Excel</h3>
                </div>

                <p>Séléctionnez votre période</p>

            </div>


        </div>
        <form action="/survey/processing/excel.php" method="post" id="excelForm">
            <div class="row">

                <div class="col-md-6">
                    <h5>Date de début</h5>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="annee_start">année</label>
                            <select name="form_excel_range[annee_start]" id="annee_start" class="form-control">
                                <?php foreach($yearRange as $year): ?>
                                    <option value="<?php echo $year; ?>" <?php if($year == $annee) { echo 'selected="selected"'; } ?>><?php echo $year; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="mois_start">mois</label>
                            <select name="form_excel_range[mois_start]" id="mois_start" class="form-control">
                                <?php foreach($datas_mois as $k=>$v): ?>
                                    <option value="<?php echo $k+1; ?>" <?php if($k+1 == $mois) { echo 'selected="selected"'; } ?>><?php echo $v; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="jour_start">jour</label>
                            <select name="form_excel_range[jour_start]" id="jour_start" class="form-control">
                                <?php for($i=0;$i<$joursDansMois; $i++): ?>
                                    <option value="<?php echo $i+1; ?>" <?php if($i+1 == $jourStart) { echo 'selected="selected"'; } ?>><?php echo $i+1; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <h5>Date de fin</h5>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="annee_end">année</label>
                            <select name="form_excel_range[annee_end]" id="annee_end" class="form-control">
                                <?php foreach($yearRange as $year): ?>
                                    <option value="<?php echo $year; ?>" <?php if($year == $annee) { echo 'selected="selected"'; } ?>><?php echo $year; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="mois_end">mois</label>
                            <select name="form_excel_range[mois_end]" id="mois_end" class="form-control">
                                <?php foreach($datas_mois as $k=>$v): ?>
                                    <option value="<?php echo $k+1; ?>" <?php if($k+1 == $mois) { echo 'selected="selected"'; } ?>><?php echo $v; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="jour_end">jour</label>
                            <select name="form_excel_range[jour_end]" id="jour_end" class="form-control">
                                <?php for($i=0;$i<$joursDansMois; $i++): ?>
                                    <option value="<?php echo $i+1; ?>" <?php if($i+1 == $jourEnd) { echo 'selected="selected"'; } ?>><?php echo $i+1; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                </div>

            </div>
            <div class="spacer"></div>
            <div class="row">

                <div class="col-md-12">
                    <button type="submit" id="excelSubmit" class="btn btn-hotel">Générer le fichier excel</button><span class="" id="excelSpinner"><span class="spinner" ></span>Récupération de vos données en cours...</span>
                </div>

                <div class="col-md-12">
                    <div class="alert alert-success" id="excelSuccess"></div>
                    <div class="alert alert-danger" id="excelError"></div>
                </div>
            </div>
        </form>


    </div> <!-- /container -->
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
