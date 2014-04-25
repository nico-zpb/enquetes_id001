<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 25/04/14
 * Time: 11:46
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
                    <h2>Autres Services</h2>
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
                    <h3>Satisfaction concernant le SPA</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>Question : &laquo; Si vous avez utilisé le SPA de l'hôtel, diriez-vous que vous êtes : &raquo;</p>
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
                    <?php foreach ($datas_satisfaction as $k => $v): ?>
                        <tr>
                            <td><?php echo $v["name"]; ?></td>
                            <td><?php echo $spa[$k]; ?></td>
                            <td><?php echo $spaPercent[$k]; ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td>Total</td>
                        <td><?php echo $spaCounter; ?></td>
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
                    <h3>Utilisation  de la connexion WIFI de l'hôtel</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>Question : &laquo; Pendant votre séjour, avez-vous utilisé la connexion internet wifi de l'hôtel ? &raquo;</p>
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
                        <?php foreach($datas_wifi as $k=>$v): ?>
                            <tr>
                                <td><?php echo $v; ?></td>
                                <td><?php echo $wifi[$k]; ?></td>
                                <td><?php echo $wifiPercent[$k]; ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>
