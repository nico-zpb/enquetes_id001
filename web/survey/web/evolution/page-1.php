<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 26/04/2014
 * Time: 13:21
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
                    <h2>Origine de la connaissance de l'hôtel - Globale</h2>
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
                    <h4>Question : &laquo; Comment avez-vous connu l'Hôtel Les Jardins de Beauval ? Etait-ce...</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th></th>
                        <?php $monthes = []; ?>
                        <?php foreach($connaissancePercentByMonth as $name=>$v): ?>
                            <?php $monthes[] = $name; ?>
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
                                <td><?php echo $connaissancePercentByMonth[$w][$k]; ?>%</td>
                            <?php endforeach; ?>
                            <td><?php echo $connaissancePercentTotal[$k]; ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td>Total</td>
                        <?php foreach($monthes as $l=>$w): ?>
                            <td><?php echo $numEntryByMonth[$w]; ?></td>
                        <?php endforeach; ?>
                        <td><?php echo $numEntriesTotal; ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="spacer"></div>
                <div>
                    <!-- TODO chart evolution/page-1 -->
                </div>
            </div>
        </div>
    </div>
</div>
