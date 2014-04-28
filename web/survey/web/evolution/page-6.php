<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 28/04/14
 * Time: 15:57
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
                    <h2>Perception du rapport qualité/prix de l'hôtel</h2>
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
                    <h4>Question : &laquo; Au regard de la qualité des chambres et de l'environnement de l'hôtel, avez-vous trouvez le prix : &raquo;</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th></th>
                        <?php $monthes = [];?>
                        <?php foreach($connaissancePercentByMonth as $name=>$v): ?>
                            <?php $monthes[] = $name;?>
                            <th><?php echo $name; ?></th>
                        <?php endforeach; ?>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($datas_perception_prix as $k=>$name): ?>
                        <?php $totalProp = 0; ?>
                        <tr>
                            <td><?php echo $name; ?></td>
                            <?php foreach($monthes as $l=>$w): ?>
                                <?php $totalProp += $satisfactionByMonth[$w]["prix"][$k]; ?>
                                <td><?php echo round(($satisfactionByMonth[$w]["prix"][$k]/$satisfactionByMonthTotal[$w]) * 100); ?>%</td>
                            <?php endforeach; ?>
                            <td><?php echo round(($totalProp / $totalSatisfaction ) * 100); ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                        <tr>
                            <td>Total</td>
                            <?php foreach($monthes as $l=>$w): ?>
                                <td><?php echo $satisfactionByMonthTotal[$w]; ?></td>
                            <?php endforeach; ?>
                            <td><?php echo $totalSatisfaction; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h2>Satisfaction concernant le SPA</h2>
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
                    <h4>Question : &laquo; Si vous avez utilisé le SPA de l'hôtel, diriez-vous que vous êtes : &raquo;</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th></th>
                        <?php $monthes = [];?>
                        <?php foreach($connaissancePercentByMonth as $name=>$v): ?>
                            <?php $monthes[] = $name;?>
                            <th><?php echo $name; ?></th>
                        <?php endforeach; ?>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach($datas_satisfaction_bis as $k=>$name): ?>
                            <?php $totalProp = 0; ?>
                            <tr>
                                <td><?php echo $name; ?></td>
                                <?php foreach($monthes as $l=>$w): ?>
                                    <?php $totalProp += $satisfactionByMonth[$w]["spa"][$k]; ?>
                                    <td><?php echo round(($satisfactionByMonth[$w]["spa"][$k]/$satisfactionByMonthTotal[$w]) * 100); ?>%</td>
                                <?php endforeach; ?>
                                <td><?php echo round(($totalProp / $totalSatisfaction ) * 100); ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td>Total</td>
                            <?php foreach($monthes as $l=>$w): ?>
                                <td><?php echo $satisfactionByMonthTotal[$w]; ?></td>
                            <?php endforeach; ?>
                            <td><?php echo $totalSatisfaction; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h2>Intention de revenir (fidélisation)</h2>
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
                    <h4>Question : &laquo; Reviendriez-vous à l'Hôtel Les Jardins de Beauval si vous en aviez l'occasion ? &raquo;</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th></th>
                        <?php $monthes = [];?>
                        <?php foreach($connaissancePercentByMonth as $name=>$v): ?>
                            <?php $monthes[] = $name;?>
                            <th><?php echo $name; ?></th>
                        <?php endforeach; ?>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($datas_intentions as $k=>$name): ?>
                        <?php $totalProp = 0; ?>
                        <tr>
                            <td><?php echo $name; ?></td>
                            <?php foreach($monthes as $l=>$w): ?>
                                <?php $totalProp += $satisfactionByMonth[$w]["revenir"][$k]; ?>
                                <td><?php echo round(($satisfactionByMonth[$w]["revenir"][$k]/$satisfactionByMonthTotal[$w]) * 100); ?>%</td>
                            <?php endforeach; ?>
                            <td><?php echo round(($totalProp / $totalSatisfaction ) * 100); ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td>Total</td>
                        <?php foreach($monthes as $l=>$w): ?>
                            <td><?php echo $satisfactionByMonthTotal[$w]; ?></td>
                        <?php endforeach; ?>
                        <td><?php echo $totalSatisfaction; ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h2>Recommandation à des proches</h2>
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
                    <h4>Question : &laquo; Et recommandriez-vous l'hôtel à des proches ? &raquo;</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th></th>
                        <?php $monthes = [];?>
                        <?php foreach($connaissancePercentByMonth as $name=>$v): ?>
                            <?php $monthes[] = $name;?>
                            <th><?php echo $name; ?></th>
                        <?php endforeach; ?>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>


                    <?php foreach($datas_intentions as $k=>$name): ?>
                        <?php $totalProp = 0; ?>
                        <tr>
                            <td><?php echo $name; ?></td>
                            <?php foreach($monthes as $l=>$w): ?>
                                <?php $totalProp += $satisfactionByMonth[$w]["recommander"][$k]; ?>
                                <td><?php echo round(($satisfactionByMonth[$w]["recommander"][$k]/$satisfactionByMonthTotal[$w]) * 100); ?>%</td>
                            <?php endforeach; ?>
                            <td><?php echo round(($totalProp / $totalSatisfaction ) * 100); ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td>Total</td>
                        <?php foreach($monthes as $l=>$w): ?>
                            <td><?php echo $satisfactionByMonthTotal[$w]; ?></td>
                        <?php endforeach; ?>
                        <td><?php echo $totalSatisfaction; ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h2>Visite du ZooParc pendant la durée du séjour</h2>
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
                    <h4>Question : &laquo; Avez-vous visité le ZooParc de Beauval pendant votre séjour ? &raquo;</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th></th>
                        <?php $monthes = [];?>
                        <?php foreach($connaissancePercentByMonth as $name=>$v): ?>
                            <?php $monthes[] = $name;?>
                            <th><?php echo $name; ?></th>
                        <?php endforeach; ?>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Oui</td>
                            <?php $totalOui = 0; $totalNon = 0; $totalAll=0; ?>
                            <?php foreach($monthes as $l=>$w): ?>
                                <?php
                                    $totalOui += $visiteZooByMonth[$w][0];
                                    $totalAll += $visiteZooTotalByMonth[$w];
                                ?>
                                <td><?php echo round(($visiteZooByMonth[$w][0] / $visiteZooTotalByMonth[$w]) * 100); ?>%</td>
                            <?php endforeach; ?>
                            <td><?php echo round(($totalOui/$totalAll) * 100); ?>%</td>
                        </tr>
                        <tr>
                            <td>Non</td>
                            <?php foreach($monthes as $l=>$w): ?>
                                <?php $totalNon += $visiteZooByMonth[$w][1]; ?>
                                <td><?php echo round(($visiteZooByMonth[$w][1] / $visiteZooTotalByMonth[$w]) * 100); ?>%</td>
                            <?php endforeach; ?>
                            <td><?php echo round(($totalNon/$totalAll) * 100); ?>%</td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <?php foreach($monthes as $l=>$w): ?>
                                <td><?php echo $visiteZooTotalByMonth[$w]; ?></td>
                            <?php endforeach; ?>
                            <td><?php echo $totalAll; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
