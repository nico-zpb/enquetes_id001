<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 23/04/2014
 * Time: 17:17
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
                <div class="page-header-hotel page-header">
                    <h2>Satisfaction, fidélisation et promotion</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header-hotel page-header">
                    <h3>Satisfaction globale</h3>
                </div>
                <?php
                $tauxSatisfaitTres = round(($globalSatisf[0] / $numEntry) * 100);
                $tauxSatisfait = round(($globalSatisf[1] / $numEntry) * 100)
                ?>
                <h4 class="text-success text-center">taux de satisfaits : <?php echo $tauxSatisfait + $tauxSatisfaitTres; ?>% dont <?php echo $tauxSatisfaitTres; ?>% de "très satisfaits".</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div id="pieChartGlobalSatisf">

                </div>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>Effectif</th>
                        <th>%</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($datas_satisfaction as $k=>$v): ?>
                        <tr>
                            <td><?php echo $v["name"]; ?></td>
                            <td><?php echo $globalSatisf[$k]; ?></td>
                            <td><?php echo round(($globalSatisf[$k] / $numEntry) * 100); ?></td>
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
