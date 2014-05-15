<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 24/04/14
 * Time: 16:01
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
?>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h2>Context du séjour à l'hôtel Les Jardins de Beauval</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h3>Principaux départements d'origine et durée du trajet</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>Question : &laquo; merci de noter le numéro de votre département d'habitation... &raquo;</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Effectif</th>
                        <th>%</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($selected as $sel): ?>
                    <tr>
                        <td><?php echo $sel["dept_num"] . " - " .$sel["dept_name"] ?></td>
                        <td><?php echo $sel["effectif"]; ?></td>
                        <td><?php echo $sel["percent"]; ?>%</td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td>Autres</td>
                        <td><?php echo $countEffectifOtherDepts; ?></td>
                        <td><?php echo round(($countEffectifOtherDepts / $numEntry) * 100,1); ?>%</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td><?php echo $numEntry; ?></td>
                        <td>100%</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>Question : &laquo; combien de temps a duré votre trajet jusqu'à l'Hôtel Les Jardins de Beauval &raquo;</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Effectifs</th>
                        <th>%</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($datas_tps_trajet as $k=>$v): ?>
                    <tr>
                        <td><?php echo $v; ?></td>
                        <td><?php echo $tpsTrajet[$k]; ?></td>
                        <td><?php echo $tpsTrajetPercent[$k]; ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td>Total</td>
                        <td><?php echo $numEntry; ?></td>
                        <td>100%</td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h3>Nombres de personnes</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h4>Nombre moyen de personnes (base <?php echo $counterPersons; ?> réponses)</h4>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Nombre moyen</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Adultes et enfants de 11 ans et plus</td>
                        <td><?php echo $moyenAdulte = round(($nbrAdultes[0] + ($nbrAdultes[1]*2) +  ($nbrAdultes[2]*3) + ($nbrAdultes[3]*4) + ($nbrAdultes[4]*5)) / $counterPersons, 1);?></td>
                    </tr>
                    <tr>
                        <td>Enfants de moins de 11 ans</td>
                        <td><?php echo $moyenEnfant = round(($nbrEnfants[0] + ($nbrEnfants[1]*2) +  ($nbrEnfants[2]*3) + ($nbrEnfants[3]*4) + ($nbrEnfants[4]*5)) / $counterPersons, 1);?></td>
                    </tr>
                    <tr class="success">
                        <td>Total</td>
                        <td><?php echo $moyenAdulte + $moyenEnfant; ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="col-md-6">
            <h4>Adultes et enfants de 11 ans et plus</h4>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th></th>
                    <th>Effecfifs</th>
                    <th>%</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($datas_nbr_personnes as $k=>$v): ?>
                    <tr>
                        <td><?php echo $v; ?></td>
                        <td><?php echo $nbrAdultes[$k]; ?></td>
                        <td><?php echo $nbrAdultesPercent[$k]; ?>%</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h4>Enfants de moins de 11 ans</h4>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th></th>
                    <th>Effecfifs</th>
                    <th>%</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach($datas_nbr_personnes as $k=>$v): ?>
                        <tr>
                            <td><?php echo $v; ?></td>
                            <td><?php echo $nbrEnfants[$k]; ?></td>
                            <td><?php echo $nbrEnfantsPercent[$k]; ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h3>Type de chambre occupé et nombre de nuits</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>Question : &laquo; Quel type de chambre avez-vous occupé pendant votre séjour à l'hôtel ? &raquo;</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <!-- chart -->
                <div id="barChartTypeRooms"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>Question : &laquo; Combien de nuits y avez-vous dormis ? &raquo;</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Effectifs</th>
                        <th>%</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach($datas_nbr_nuits as $k=>$v): ?>
                            <tr>
                                <td><?php echo $v; ?></td>
                                <td><?php echo $nuites[$k]; ?></td>
                                <td><?php echo $nuitesPercent[$k]; ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                    <tr>
                        <td>Total</td>
                        <td><?php echo $countNuites; ?></td>
                        <td>100%</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-2"></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h3>Visite du zoo pendant la durée du séjour</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>Question : &laquo; Avez-vous visité le ZooParc de Beauval pendant votre séjour ? &raquo;</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Effectifs</th>
                        <th>%</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Oui</td>
                        <td><?php echo $visiteZoo[0]; ?></td>
                        <td><?php echo $visiteZooPercent[0]; ?>%</td></td>
                    </tr>
                    <tr>
                        <td>Non</td>
                        <td><?php echo $visiteZoo[1]; ?></td>
                        <td><?php echo $visiteZooPercent[1]; ?>%</td></td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td><?php echo $countVisite; ?></td>
                        <td>100%</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-2"></div>

        </div>

    </div>
</div>

