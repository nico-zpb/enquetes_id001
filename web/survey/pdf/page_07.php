<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 12/05/14
 * Time: 10:25
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
    <table class="page-header">
        <tr>
            <td><span class="regular">Région d'habitation (zone d'attraction)</span></td>
        </tr>
    </table>
    <?php $cols = count($clientsByMonth) + 1; $colwidth = (84/$cols);?>
    <table class="table">
        <thead>
            <tr>
                <th style="width: 16%;">Régions</th>
                <?php foreach($clientsByMonth as $name=>$v): ?>
                    <th><?php echo $name; ?></th>
                <?php endforeach; ?>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr class="odd">
                <td style="width: 16%;">Région Centre</td>
                <?php foreach($numCentreByMonthPercent as $k=>$v): ?>
                    <td style="width:<?php echo $colwidth; ?>%;"><?php echo $v; ?>%</td>
                <?php endforeach; ?>
                <td style="width:<?php echo $colwidth; ?>%;"><?php echo round(($totalCentre/$totalOriginEntry) * 100,1); ?>%</td>
            </tr>
            <tr class="even">
                <td style="width: 16%;">Région Parisienne</td>
                <?php foreach($numParisByMonthPercent as $k=>$v): ?>
                    <td style="width:<?php echo $colwidth; ?>%;"><?php echo $v; ?>%</td>
                <?php endforeach; ?>
                <td style="width:<?php echo $colwidth; ?>%;"><?php echo round(($totalParis/$totalOriginEntry) * 100,1);  ?>%</td>
            </tr>
            <tr class="odd">
                <td style="width: 16%;">Autres départements</td>
                <?php foreach($numOtherByMonthPercent as $k=>$v): ?>
                    <td style="width:<?php echo $colwidth; ?>%;"><?php echo $v; ?>%</td>
                <?php endforeach; ?>
                <td style="width:<?php echo $colwidth; ?>%;"><?php echo round(($totalOther/$totalOriginEntry) * 100,1);  ?>%</td>
            </tr>
            <tr class="even">
                <td style="width: 16%;">Pays étrangers</td>
                <?php foreach($numEtrangerByMonthPercent as $k=>$v): ?>
                    <td style="width:<?php echo $colwidth; ?>%;"><?php echo $v; ?>%</td>
                <?php endforeach; ?>
                <td style="width:<?php echo $colwidth; ?>%;"><?php echo round(($totalEtranger/$totalOriginEntry) * 100,1);  ?>%</td>
            </tr>
            <tr class="odd">
                <td style="width: 16%;">Total</td>
                <?php foreach($clientsByMonth as $name=>$v): ?>
                    <td style="width:<?php echo $colwidth; ?>%;"><?php echo count($v); ?></td>
                <?php endforeach; ?>
                <td style="width:<?php echo $colwidth; ?>%;"><?php echo $totalOriginEntry; ?></td>
            </tr>
        </tbody>
    </table>

</page>
