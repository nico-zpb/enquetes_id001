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
                        <tr>
                            <td><?php echo $name; ?></td>
                            <?php foreach($monthes as $l=>$w): ?>
                                <td><?php echo round(($satisfactionByMonth[$w]["prix"][$k]/$satisfactionByMonthTotal[$w]) * 100); ?>%</td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                        <tr>
                            <td>Total</td>
                            <?php foreach($monthes as $l=>$w): ?>
                                <td><?php echo $satisfactionByMonthTotal[$w]; ?></td>
                            <?php endforeach; ?>
                            <td></td>
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

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
