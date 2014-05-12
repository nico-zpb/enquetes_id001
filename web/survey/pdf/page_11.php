<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 12/05/14
 * Time: 16:55
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
            <td><span class="regular">Satisfaction restauration</span></td>
        </tr>
    </table>
    <table style="width: 100%;">
        <?php $cols = count($connaissancePercentByMonth) + 1; $colwidth = (84/$cols); ?>
        <tr>
            <td style="width: 15%;"></td>
            <td style="width: 85%;" class="sub-header">En ce qui concerne la restauration de l'hôtel, avez-vous été satisfait de : </td>
        </tr>
        <tr>
            <td style="width: 15%;" class="sub-header">% Satisfaits</td>
            <td style="width: 85%;">
                <table class="table">
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
                    <?php foreach($datas_resto_shorts as $k=>$name): ?>

                        <tr>
                            <td style="width: 16%; background-color: #dfe782;"><?php echo $datas_resto[$k]; ?></td>
                            <?php $totalBySatisfaction = 0; ?>
                            <?php foreach($monthes as $l=>$w): ?>
                                <?php
                                $totalBySatisfaction += $satisfactionByMonth[$w][$name][0] + $satisfactionByMonth[$w][$name][1];
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
                                <td style="width:<?php echo $colwidth; ?>%;" <?php echo $class; ?>><?php echo $sum; ?>%</td><!-- !pourcentage -->
                            <?php endforeach; ?>
                            <?php
                            $total = round(($totalBySatisfaction/$totalSatisfaction) * 100);
                            if($total >= 90){
                                $classT = " class='success'";
                            } elseif($total<90 && $total >= 80){
                                $classT = " class='info'";
                            } else {
                                $classT = " class='danger'";
                            }
                            ?>
                            <td style="width:<?php echo $colwidth; ?>%;" <?php echo $classT; ?>><?php echo $total; ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>

                </table>
            </td>
        </tr>
        <tr>
            <td style="width: 15%;"></td>
            <td style="width: 85%; font-weight: bold; font-size:12pt;" class="">Vert soutenu : 90% et +, vert clair : 80 à moins de 90%, rouge : &lt; 80% de satisfaits</td>
        </tr>
        <tr>
            <td style="width: 15%;" class="sub-header">Dont % de très satisfaits</td>
            <td style="width: 85%;">
                <table class="table">
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
                    <?php foreach($datas_resto_shorts as $k=>$name): ?>
                        <tr>
                            <td style="width: 16%; background-color: #dfe782;"><?php echo $datas_resto[$k]; ?></td>
                            <?php $totalBySatisfaction = 0; ?>
                            <?php foreach($monthes as $l=>$w): ?>
                                <?php $totalBySatisfaction += $satisfactionByMonth[$w][$name][0]; ?>
                                <td style="width:<?php echo $colwidth; ?>%; background-color: #dfe782;"><?php echo round(($satisfactionByMonth[$w][$name][0] / $satisfactionByMonthTotal[$w]) * 100); ?>%</td><!-- !pourcentage -->

                            <?php endforeach; ?>
                            <?php
                            $total = round(($totalBySatisfaction/$totalSatisfaction) * 100);
                            ?>
                            <td style="width:<?php echo $colwidth; ?>%; background-color: #dfe782;"><?php echo $total; ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>

                </table>
            </td>
        </tr>
    </table>
</page>
