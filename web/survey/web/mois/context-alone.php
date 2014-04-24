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
            <div class="col-md-12">
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
                        <td><?php echo round(($countEffectifOtherDepts / $numEntry) * 100); ?>%</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td><?php echo $numEntry; ?></td>
                        <td>100%</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>Question : &laquo; combien de temps a duré votre trajet jusqu'à l'Hôtel Les Jardins de Beauval &raquo;</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
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
        </div>
    </div>
</div>