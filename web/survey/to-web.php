<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 23/04/2014
 * Time: 09:01
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
                <h2>Format Internet</h2>
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
                    <h3>Données globales</h3>
                </div>
                <p>Séléctionnez l'année</p>
            </div>

        </div>
        <form action="" method="post" id="form_cwg">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2">
                            <select name="form_cwg_range[annee]" id="form_cwg_range_annee" class="form-control">
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
                    <h3>Données globales - par mois</h3>
                </div>
                <p>Séléctionnez les mois à comparer</p>
            </div>

        </div>
        <form action="/survey/web/classic-mois.php" method="post" id="form_cwm">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2">
                            <label for="form_cwm_range_annee">année</label>
                            <select name="form_cwm_range[annee]" id="" class="form-control">
                                <?php foreach($yearRange as $year): ?>
                                    <option value="<?php echo $year; ?>" <?php if($year == $annee) { echo 'selected="selected"'; } ?>><?php echo $year; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="form_cwm_range_month_start">début</label>
                            <select name="form_cwm_range[month_start]" id="form_cwm_range_month_start" class="form-control">
                                <?php for($i=0; $i<12;$i++): ?>
                                    <option value="<?php echo $i+1; ?>" <?php if($i+1 == $mois) { echo 'selected="selected"'; } ?>><?php echo ucfirst($datas_mois[$i]); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="form_cwm_range_month_end">fin</label>
                            <select name="form_cwm_range[month_end]" id="form_cwm_range_month_end" class="form-control">
                                <?php for($i=0; $i<12;$i++): ?>
                                    <option value="<?php echo $i+1; ?>" <?php if($i+1 == $mois) { echo 'selected="selected"'; } ?>><?php echo ucfirst($datas_mois[$i]); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-12">
                    <div class="spacer"></div>
                    <button type="submit" id="submit_cwm" class="btn btn-hotel">continuer &raquo;</button>
                </div>
                <div class="col-md-12">
                    <div class="spacer"></div>
                    <div class="alert alert-success" id="cwmSuccess"></div>
                    <div class="alert alert-danger" id="cwmError"></div>
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
                    <h3>Données classiques - filtrées</h3>
                </div>
                <p>Séléctionnez votre période</p>
            </div>
        </div>
        <form action="/survey/web/classic-filtre.php" method="post" id="cwForm">
            <div class="row">
                <div class="col-md-6">
                    <h5>Date de début</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="annee_start_cw">année</label>
                            <select name="form_cw_range[annee_start]" id="annee_start_cw" class="form-control">
                                <?php foreach($yearRange as $year): ?>
                                    <option value="<?php echo $year; ?>" <?php if($year == $annee) { echo 'selected="selected"'; } ?>><?php echo $year; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="mois_start_cw">mois</label>
                            <select name="form_cw_range[mois_start]" id="mois_start_cw" class="form-control">
                                <?php foreach($datas_mois as $k=>$v): ?>
                                    <option value="<?php echo $k+1; ?>" <?php if($k+1 == $mois) { echo 'selected="selected"'; } ?>><?php echo $v; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="jour_start_cw">jour</label>
                            <select name="form_cw_range[jour_start]" id="jour_start_cw" class="form-control">
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
                            <label for="annee_end_cw">année</label>
                            <select name="form_cw_range[annee_end]" id="annee_end_cw" class="form-control">
                                <?php foreach($yearRange as $year): ?>
                                    <option value="<?php echo $year; ?>" <?php if($year == $annee) { echo 'selected="selected"'; } ?>><?php echo $year; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="mois_end_cw">mois</label>
                            <select name="form_cw_range[mois_end]" id="mois_end_cw" class="form-control">
                                <?php foreach($datas_mois as $k=>$v): ?>
                                    <option value="<?php echo $k+1; ?>" <?php if($k+1 == $mois) { echo 'selected="selected"'; } ?>><?php echo $v; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="jour_end_cw">jour</label>
                            <select name="form_cw_range[jour_end]" id="jour_end_cw" class="form-control">
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
                    <button type="submit" class="btn btn-hotel" id="cwSubmit">continuer &raquo;</button><span class="" id="cwSpinner"><span class="spinner" ></span>Vérification des dates en cours...</span>
                </div>



                <div class="col-md-12">
                    <div class="spacer"></div>
                    <div class="alert alert-success" id="cwSuccess"></div>
                    <div class="alert alert-danger" id="cwError"></div>
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
<?php if(!$debug): ?>
<script src="/js/vendor/spin.min.js"></script>
<script src="/js/vendor/jquery.spin.js"></script>
<script src="/survey/js/apps/mainSurveyWeb.js"></script>
<?php endif; ?>
</body>
</html>
