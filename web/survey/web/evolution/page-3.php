<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 28/04/14
 * Time: 10:36
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
                    <h2>Origine de la connaissance de l'hôtel - Par zone d'attraction</h2>
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
                    <h4>Question : &laquo; Comment avez-vous connu l'Hôtel Les Jardins de Beauval ? Etait-ce...&raquo;</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ################### Région Parisienne ################### -->
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h3>Région Parisienne</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <?php $monthes = []; $totalByType=0;?>
                            <?php foreach($connaissancePercentByMonth as $name=>$v): ?>
                                <?php $monthes[] = $name; $totalByType += $connaissanceRegionParisByMonthTotal[$name];?>
                                <th><?php echo $name; ?></th>
                            <?php endforeach; ?>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($connaissance_types as $k=>$v): ?>
                            <tr>
                                <td><?php echo $v; ?></td>
                                <?php foreach($monthes as $l=>$w): ?>
                                    <td><?php echo round(($connaissanceRegionParisByMonth[$w][$k]/$connaissanceRegionParisByMonthTotal[$w]) * 100); ?>%</td>
                                <?php endforeach; ?>
                                <?php
                                $sum = 0;
                                foreach($monthes as $l=>$w){
                                    $sum += $connaissanceRegionParisByMonth[$w][$k];
                                }
                                $percent = round(($sum / $totalByType) * 100);
                                ?>
                                <td><?php echo $percent; ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="originConnaissanceHotelParis"></div>
            </div>
        </div>
    </div>
</div>
<!-- ################### Région Centre ################### -->
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h3>Région Centre</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <?php $monthes = []; $totalByType=0;?>
                            <?php foreach($connaissancePercentByMonth as $name=>$v): ?>
                                <?php $monthes[] = $name; $totalByType += $connaissanceRegionCentreByMonthTotal[$name];?>
                                <th><?php echo $name; ?></th>
                            <?php endforeach; ?>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($connaissance_types as $k=>$v): ?>
                            <tr>
                                <td><?php echo $v; ?></td>
                                <?php foreach($monthes as $l=>$w): ?>
                                    <td><?php echo round(($connaissanceRegionCentreByMonth[$w][$k]/$connaissanceRegionCentreByMonthTotal[$w]) * 100); ?>%</td>
                                <?php endforeach; ?>
                                <?php
                                $sum = 0;
                                foreach($monthes as $l=>$w){
                                    $sum += $connaissanceRegionCentreByMonth[$w][$k];
                                }
                                $percent = round(($sum / $totalByType) * 100);
                                ?>
                                <td><?php echo $percent; ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="originConnaissanceHotelCentre"></div>
            </div>
        </div>
    </div>
</div>
<!-- ################### Autres départements ################### -->
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h3>Autres départements</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <?php $monthes = []; $totalByType=0;?>
                            <?php foreach($connaissancePercentByMonth as $name=>$v): ?>
                                <?php $monthes[] = $name; $totalByType += $connaissanceRegionAutresByMonthTotal[$name];?>
                                <th><?php echo $name; ?></th>
                            <?php endforeach; ?>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($connaissance_types as $k=>$v): ?>
                            <tr>
                                <td><?php echo $v; ?></td>
                                <?php foreach($monthes as $l=>$w): ?>
                                    <td><?php echo round(($connaissanceRegionAutresByMonth[$w][$k]/$connaissanceRegionAutresByMonthTotal[$w]) * 100); ?>%</td>
                                <?php endforeach; ?>


                                <?php
                                $sum = 0;
                                foreach($monthes as $l=>$w){
                                    $sum += $connaissanceRegionAutresByMonth[$w][$k];
                                }
                                $percent = round(($sum / $totalByType) * 100);
                                ?>
                                <td><?php echo $percent; ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="originConnaissanceHotelAutres"></div>
            </div>
        </div>
    </div>
</div>
