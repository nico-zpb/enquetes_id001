<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 28/04/14
 * Time: 15:40
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
                    <h2>Satisfaction restauration</h2>
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
                    <h4>Question : &laquo; En ce qui concerne la restauration de l'hôtel, avez-vous été satisfait de : &raquo;</h4>
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
                    <h3>Pourcentage de satisfaits</h3>
                </div>
            </div>
        </div>
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
                    <?php foreach($datas_resto_shorts as $k=>$name): ?>
                        <tr>
                            <td><?php echo $datas_resto[$k]; ?></td>
                            <?php foreach($monthes as $l=>$w): ?>
                                <?php
                                $percentVS = round(($satisfactionByMonth[$w][$name][0] / $satisfactionByMonthTotal[$w]) * 100);
                                $percentS = round(($satisfactionByMonth[$w][$name][1] / $satisfactionByMonthTotal[$w]) * 100);
                                $sum = $percentS + $percentVS;
                                $class = "";
                                if($sum >= 90){
                                    $class = " class='success'";
                                } elseif($sum<90 && $sum >= 80){
                                    $class = " class='info'";
                                } else {
                                    $class = " class='danger'";
                                }
                                ?>
                                <td <?php echo $class; ?>><?php echo $sum; ?>%</td><!-- !pourcentage -->
                            <?php endforeach; ?>
                            <td><!-- todo total--></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <p>En vert : 90% satisfait et plus, en bleu : 80 à 90% satisfait, en rouge moins de 80% satisfait</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h3>Dont pourcentage de très satisfaits</h3>
                </div>
            </div>
        </div>
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
                    <?php foreach($datas_resto_shorts as $k=>$name): ?>
                        <tr>
                            <td><?php echo $datas_resto[$k]; ?></td>
                            <?php foreach($monthes as $l=>$w): ?>
                                <td><?php echo round(($satisfactionByMonth[$w][$name][0] / $satisfactionByMonthTotal[$w]) * 100); ?>%</td><!-- !pourcentage -->
                            <?php endforeach; ?>
                            <td><!-- todo total--></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
