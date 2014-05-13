<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 13/05/14
 * Time: 09:08
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
    <bookmark title="Satisfaction concernant le SPA" level="0"></bookmark>
    <table class="page-header">
        <tr>
            <td><span class="regular">Satisfaction concernant le SPA</span></td>
        </tr>
    </table>
    <table style="width: 100%;">
        <tr>
            <td style="width: 100%;" class="sub-header">Si vous avez utilisé le SPA de l'hôtel, diriez-vous que vous êtes :</td>
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
        <?php foreach($datas_satisfaction_bis as $k=>$name): ?>
            <?php $totalProp = 0; ?>
            <tr <?php if(($k+1)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                <td style="width: 16%;"><?php echo $name; ?></td>
                <?php foreach($monthes as $l=>$w): ?>
                    <?php $totalProp += $satisfactionByMonth[$w]["spa"][$k]; ?>
                    <td style="width:<?php echo $colwidth; ?>%;"><?php echo round(($satisfactionByMonth[$w]["spa"][$k]/$satisfactionByMonthTotal[$w]) * 100); ?>%</td>
                <?php endforeach; ?>
                <td style="width:<?php echo $colwidth; ?>%;"><?php echo round(($totalProp / $totalSatisfaction ) * 100); ?>%</td>
            </tr>
        <?php endforeach; ?>
        <tr class="odd">
            <td style="width: 16%;">Total</td>
            <?php foreach($monthes as $l=>$w): ?>
                <td style="width:<?php echo $colwidth; ?>%;"><?php echo $satisfactionByMonthTotal[$w]; ?></td>
            <?php endforeach; ?>
            <td style="width:<?php echo $colwidth; ?>%;"><?php echo $totalSatisfaction; ?></td>
        </tr>
        </tbody>
    </table>

</page>
