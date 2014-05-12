<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 26/04/2014
 * Time: 14:09
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
                    <h2>Région d'attraction <small>zone d'attraction</small></h2>
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
                    <h4>Question : &laquo; Merci de séléctionner votre département d'habitation &raquo; <small>regroupement en régions</small></h4>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Régions</th>
                            <?php $monthes = []; ?>
                            <?php foreach($ClientsByMonth as $name=>$v): ?>
                                <?php $monthes[] = $name; ?>
                                <th><?php echo $name; ?></th>
                            <?php endforeach; ?>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Région Centre</td>
                            <?php foreach($numCentreByMonthPercent as $k=>$v): ?>
                                <td><?php echo $v; ?>%</td>
                            <?php endforeach; ?>
                            <td><?php echo round(($totalCentre/$totalOriginEntry) * 100,1); ?>%</td>
                        </tr>
                        <tr>
                            <td>Région Parisienne</td>
                            <?php foreach($numParisByMonthPercent as $k=>$v): ?>
                                <td><?php echo $v; ?>%</td>
                            <?php endforeach; ?>
                            <td><?php echo round(($totalParis/$totalOriginEntry) * 100,1);  ?>%</td>
                        </tr>
                        <tr>
                            <td>Autres départements</td>
                            <?php foreach($numOtherByMonthPercent as $k=>$v): ?>
                                <td><?php echo $v; ?>%</td>
                            <?php endforeach; ?>
                            <td><?php echo round(($totalOther/$totalOriginEntry) * 100,1);  ?>%</td>
                        </tr>
                        <tr>
                            <td>Pays étrangers</td>
                            <?php foreach($numEtrangerByMonthPercent as $k=>$v): ?>
                                <td><?php echo $v; ?>%</td>
                            <?php endforeach; ?>
                            <td><?php echo round(($totalEtranger/$totalOriginEntry) * 100,1);  ?>%</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <?php foreach($ClientsByMonth as $name=>$v): ?>
                                <td><?php echo count($v); ?></td>
                            <?php endforeach; ?>
                            <td><?php echo $totalOriginEntry; ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>








