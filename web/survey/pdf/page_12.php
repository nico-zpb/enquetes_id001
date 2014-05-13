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
    <table class="page-header">
        <tr>
            <td><span class="regular">Perception du rapport qualité/prix de l'hôtel</span></td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="width: 100%;" class="sub-header">Au regard de la qualité des chambres et de l'environnement de l'hôtel, avez-vous trouvé le prix :</td>
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
                <th><?php echo $name; ?></th>
            <?php endforeach; ?>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($datas_perception_prix as $k=>$name): ?>
            <?php $totalProp = 0; ?>
            <tr <?php if(($k+1)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                <td style="width: 16%;"><?php echo $name; ?></td>
                <?php foreach($monthes as $l=>$w): ?>
                    <?php $totalProp += $satisfactionByMonth[$w]["prix"][$k]; ?>
                    <td style="width:<?php echo $colwidth; ?>%;"><?php echo round(($satisfactionByMonth[$w]["prix"][$k]/$satisfactionByMonthTotal[$w]) * 100,1); ?>%</td>
                <?php endforeach; ?>
                <td style="width:<?php echo $colwidth; ?>%;"><?php echo round(($totalProp / $totalSatisfaction ) * 100,1); ?>%</td>
            </tr>
        <?php endforeach; ?>
        <tr class="even">
            <td style="width: 16%;">Total</td>
            <?php foreach($monthes as $l=>$w): ?>
                <td style="width:<?php echo $colwidth; ?>%;"><?php echo $satisfactionByMonthTotal[$w]; ?></td>
            <?php endforeach; ?>
            <td style="width:<?php echo $colwidth; ?>%;"><?php echo $totalSatisfaction; ?></td>
        </tr>
        </tbody>
    </table>

</page>
