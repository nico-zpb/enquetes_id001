<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 12/05/14
 * Time: 10:34
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
            <td><span class="regular">Origine de la connaissance de l'hôtel</span></td>
        </tr>
    </table>
    <table style="width: 100%;">
        <?php $cols = count($connaissancePercentByMonth) + 1; $colwidth = (84/$cols); ?>
        <tr>
            <td style="width: 15%;">
                Région Parisienne
            </td>
            <td style="width: 85%;">
                <table class="table" style="font-size: 6pt; width: 100%;">
                    <thead>
                    <tr>
                        <th style="width: 16%;"></th>
                        <?php $monthes = []; $totalByType=0;?>
                        <?php foreach($connaissancePercentByMonth as $name=>$v): ?>
                            <?php $monthes[] = $name; $totalByType += $connaissanceRegionParisByMonthTotal[$name];?>
                            <th style="width:<?php echo $colwidth; ?>%;"><?php echo $name; ?></th>
                        <?php endforeach; ?>
                        <th style="width:<?php echo $colwidth; ?>%;">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($connaissance_types as $k=>$v): ?>
                        <tr <?php if(($k+1)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                            <td style="width: 16%;"><?php echo $v; ?></td>
                            <?php foreach($monthes as $l=>$w): ?>
                                <td style="width:<?php echo $colwidth; ?>%;">
                                    <?php if($connaissanceRegionParisByMonthTotal[$w]>0){echo round(($connaissanceRegionParisByMonth[$w][$k]/$connaissanceRegionParisByMonthTotal[$w]) * 100,1);} else {echo "0";}  ?>%
                                </td>
                            <?php endforeach; ?>
                            <?php
                            $sum = 0;
                            foreach($monthes as $l=>$w){
                                $sum += $connaissanceRegionParisByMonth[$w][$k];
                            }
                            $percent = 0;
                            if($totalByType>0){
                                $percent = round(($sum / $totalByType) * 100, 1);
                            }

                            ?>
                            <td style="width:<?php echo $colwidth; ?>%;"><?php echo $percent; ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td style="width: 15%;">
                Région Centre
            </td>
            <td style="width: 85%;">
                <table class="table" style="font-size: 6pt; width: 100%;">
                    <thead>
                    <tr>
                        <th style="width: 16%;"></th>
                        <?php $monthes = []; $totalByType=0;?>
                        <?php foreach($connaissancePercentByMonth as $name=>$v): ?>
                            <?php $monthes[] = $name; $totalByType += $connaissanceRegionCentreByMonthTotal[$name];?>
                            <th style="width:<?php echo $colwidth; ?>%;"><?php echo $name; ?></th>
                        <?php endforeach; ?>
                        <th style="width:<?php echo $colwidth; ?>%;">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($connaissance_types as $k=>$v): ?>
                        <tr <?php if(($k+1)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                            <td style="width: 16%;"><?php echo $v; ?></td>
                            <?php foreach($monthes as $l=>$w): ?>
                                <td style="width:<?php echo $colwidth; ?>%;">
                                    <?php if($connaissanceRegionCentreByMonthTotal[$w]>0){echo round(($connaissanceRegionCentreByMonth[$w][$k]/$connaissanceRegionCentreByMonthTotal[$w]) * 100,1);} else {echo "0";}  ?>%
                                </td>
                            <?php endforeach; ?>
                            <?php
                            $sum = 0;
                            foreach($monthes as $l=>$w){
                                $sum += $connaissanceRegionCentreByMonth[$w][$k];
                            }
                            $percent = 0;
                            if($totalByType>0){
                                $percent = round(($sum / $totalByType) * 100,1);
                            }

                            ?>
                            <td style="width:<?php echo $colwidth; ?>%;"><?php echo $percent; ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td style="width: 15%;">
                Autres départements
            </td>
            <td style="width: 85%;">
                <table class="table" style="font-size: 6pt; width: 100%;">
                    <thead>
                    <tr>
                        <th style="width: 16%;"></th>
                        <?php $monthes = []; $totalByType=0;?>
                        <?php foreach($connaissancePercentByMonth as $name=>$v): ?>
                            <?php $monthes[] = $name; $totalByType += $connaissanceRegionAutresByMonthTotal[$name];?>
                            <th style="width:<?php echo $colwidth; ?>%;"><?php echo $name; ?></th>
                        <?php endforeach; ?>
                        <th style="width:<?php echo $colwidth; ?>%;">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($connaissance_types as $k=>$v): ?>
                        <tr <?php if(($k+1)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                            <td style="width: 16%;"><?php echo $v; ?></td>
                            <?php foreach($monthes as $l=>$w): ?>
                                <td style="width:<?php echo $colwidth; ?>%;">
                                    <?php if($connaissanceRegionAutresByMonthTotal[$w]>0){echo round(($connaissanceRegionAutresByMonth[$w][$k]/$connaissanceRegionAutresByMonthTotal[$w]) * 100,1);} else {echo "0";}  ?>%
                                </td>
                            <?php endforeach; ?>
                            <?php
                            $sum = 0;
                            foreach($monthes as $l=>$w){
                                $sum += $connaissanceRegionAutresByMonth[$w][$k];
                            }
                            $percent = 0;
                            if($totalByType>0){
                                $percent = round(($sum / $totalByType) * 100,1);
                            }
                            ?>
                            <td style="width:<?php echo $colwidth; ?>%;"><?php echo $percent; ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</page>
