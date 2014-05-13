<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 13/05/14
 * Time: 11:06
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

<page pageset="old">
    <bookmark title="Visite du zoo pendant la durée du séjour" level="0"></bookmark>
    <table class="page-header">
        <tr>
            <td><span class="regular">Visite du zoo pendant la durée du séjour</span></td>
        </tr>
    </table>
    <table style="width: 100%;">
        <tr>
            <td style="width: 100%;" class="sub-header">Avez-vous visitez le ZooParc de Beauval pendant votre séjour ?</td>
        </tr>
    </table>
    <?php $cols = count($connaissancePercentByMonth) + 1; $colwidth = (84/$cols); ?>
    <table class="table" style="width: 100%;">
        <thead>
        <tr>
            <th style="width: 16%;"></th>
            <?php $monthes = [];?>
            <?php foreach($connaissancePercentByMonth as $name=>$v): ?>
                <?php $monthes[] = $name;?>
                <th style="width:<?php echo $colwidth; ?>%;"><?php echo $name; ?></th>
            <?php endforeach; ?>
            <th style="width:<?php echo $colwidth; ?>%;">Total</th>
        </tr>
        </thead>
        <tbody>
        <tr class="odd">
            <td style="width: 16%;">Oui</td>
            <?php $totalOui = 0; $totalNon = 0; $totalAll=0; ?>
            <?php foreach($monthes as $l=>$w): ?>
                <?php
                $totalOui += $visiteZooByMonth[$w][0];
                $totalAll += $visiteZooTotalByMonth[$w];
                ?>
                <td style="width:<?php echo $colwidth; ?>%;"><?php echo round(($visiteZooByMonth[$w][0] / $visiteZooTotalByMonth[$w]) * 100); ?>%</td>
            <?php endforeach; ?>
            <td style="width:<?php echo $colwidth; ?>%;"><?php echo round(($totalOui/$totalAll) * 100); ?>%</td>
        </tr>
        <tr class="even">
            <td style="width: 16%;">Non</td>
            <?php foreach($monthes as $l=>$w): ?>
                <?php $totalNon += $visiteZooByMonth[$w][1]; ?>
                <td style="width:<?php echo $colwidth; ?>%;"><?php echo round(($visiteZooByMonth[$w][1] / $visiteZooTotalByMonth[$w]) * 100); ?>%</td>
            <?php endforeach; ?>
            <td style="width:<?php echo $colwidth; ?>%;"><?php echo round(($totalNon/$totalAll) * 100); ?>%</td>
        </tr>
        <tr class="odd">
            <td style="width: 16%;">Total</td>
            <?php foreach($monthes as $l=>$w): ?>
                <td style="width:<?php echo $colwidth; ?>%;"><?php echo $visiteZooTotalByMonth[$w]; ?></td>
            <?php endforeach; ?>
            <td style="width:<?php echo $colwidth; ?>%;"><?php echo $totalAll; ?></td>
        </tr>
        </tbody>
    </table>
</page>
