<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 06/05/14
 * Time: 12:39
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
                <h2>Format PDF</h2>
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
        <form action="/survey/pdf/evolution/page_00.php" method="post" id="form_pdfe">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2">
                            <select name="form_pdfe_range[annee]" id="form_pdfe_range_annee" class="form-control">
                                <?php foreach($yearRange as $year): ?>
                                    <option value="<?php echo $year; ?>" <?php if($year == $annee) { echo 'selected="selected"'; } ?>><?php echo $year; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" id="submit_cwe" class="btn btn-hotel">continuer &raquo;</button>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h3>Données globales - sur l'année</h3>
                </div>
                <p>Séléctionnez l'année</p>
            </div>

        </div>
        <form action="/survey/pdf/annee/page_00.php" method="post" id="form_pdfa">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2">
                            <select name="form_pdfa_range[annee]" id="form_pdfa_range_annee" class="form-control">
                                <?php foreach($yearRange as $year): ?>
                                    <option value="<?php echo $year; ?>" <?php if($year == $annee) { echo 'selected="selected"'; } ?>><?php echo $year; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" id="submit_cwg" class="btn btn-hotel">continuer &raquo;</button>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h3>Données globales - sur un ou plusieurs mois</h3>
                </div>
                <p>Séléctionnez la périoder</p>
            </div>

        </div>
        <form action="/survey/pdf/mois/alone/page_00.php" method="post" id="form_pdfm">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="form_pdfm_range_annee">année</label>
                            <select name="form_pdfm_range[annee]" id="" class="form-control">
                                <?php foreach($yearRange as $year): ?>
                                    <option value="<?php echo $year; ?>" <?php if($year == $annee) { echo 'selected="selected"'; } ?>><?php echo $year; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="form_pdfm_range_month_start">mois</label>
                            <select name="form_pdfm_range[month_start]" id="form_pdfm_range_month_start" class="form-control">
                                <?php for($i=0; $i<12;$i++): ?>
                                    <option value="<?php echo $i+1; ?>" <?php if($i+1 == $mois) { echo 'selected="selected"'; } ?>><?php echo ucfirst($datas_mois[$i]); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-md-8"></div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-12">
                    <div class="spacer"></div>
                    <button type="submit" id="submit_pdfm" class="btn btn-hotel">continuer &raquo;</button>
                </div>
                <?php if(!$debug): ?>
                    <div class="col-md-12">
                        <div class="spacer"></div>
                        <div class="alert alert-success" id="cwmSuccess"></div>
                        <div class="alert alert-danger" id="cwmError"></div>
                    </div>
                <?php endif; ?>
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
<?php if(!$debug): ?>
    <script src="/js/vendor/spin.min.js"></script>
    <script src="/js/vendor/jquery.spin.js"></script>
    <script src="/survey/js/apps/mainSurveyWeb.js"></script>
<?php endif; ?>
</body>
</html>
