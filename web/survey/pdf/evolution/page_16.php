<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 13/05/14
 * Time: 11:27
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
    <bookmark title="Recommandation à des proches" level="0"></bookmark>
    <table class="page-header">
        <tr>
            <td><span class="regular">Recommandation à des proches</span></td>
        </tr>
    </table>
    <table style="width: 100%;">
        <tr>
            <td style="width: 100%;" class="sub-header">Et recommanderiez-vous l'hôtel à des proches ?</td>
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
        <?php foreach($datas_intentions as $k=>$name): ?>
            <?php $totalProp = 0; ?>
            <tr <?php if(($k+1)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                <td style="width: 16%;"><?php echo $name; ?></td>
                <?php foreach($monthes as $l=>$w): ?>
                    <?php $totalProp += $satisfactionByMonth[$w]["recommander"][$k]; ?>
                    <td style="width:<?php echo $colwidth; ?>%;">
                        <?php if($satisfactionByMonthTotal[$w]>0){echo round(($satisfactionByMonth[$w]["recommander"][$k]/$satisfactionByMonthTotal[$w]) * 100,1);} else {echo "0";}  ?>%
                    </td>
                <?php endforeach; ?>
                <td style="width:<?php echo $colwidth; ?>%;">
                    <?php if($totalSatisfaction>0){echo round(($totalProp / $totalSatisfaction ) * 100,1);} else {echo "0";} ?>%
                </td>
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
