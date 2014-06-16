<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 12/05/14
 * Time: 16:53
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
    <bookmark title="Satisfaction globale par service" level="0"></bookmark>
    <table class="page-header">
        <tr>
            <td><span class="regular">Satisfaction globale par service</span></td>
        </tr>
    </table>


    <table style="width: 100%;">
        <?php $cols = count($connaissancePercentByMonth) + 1; $colwidth = (84/$cols); ?>
        <tr>
            <td style="width: 15%;"></td>
            <td style="width: 85%;" class="sub-header">Avez-vous été satisfaits des points suivants : </td>
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
                    <?php foreach($datas_services_bis_shorts as $k=>$name): ?>
                        <tr>
                            <td style="width: 16%; background-color: #dfe782;"><?php echo $datas_services_bis[$k]; ?></td>
                            <?php $totalBySatisfaction = 0; ?>
                            <?php foreach($monthes as $l=>$w): ?>
                                <?php
                                $totalBySatisfaction += $satisfactionByMonth[$w][$name][0] + $satisfactionByMonth[$w][$name][1];
                                $percentVS = 0;
                                $percentS = 0;
                                if($satisfactionByMonthTotal[$w]>0){
                                    $percentVS = round(($satisfactionByMonth[$w][$name][0] / $satisfactionByMonthTotal[$w]) * 100);
                                }
                                if($satisfactionByMonthTotal[$w]>0){
                                    $percentS = round(($satisfactionByMonth[$w][$name][1] / $satisfactionByMonthTotal[$w]) * 100);
                                }
                                $sum = $percentS + $percentVS;
                                $style = "";
                                if($sum >= 90){
                                    $style = " background-color:#63b451;";
                                } elseif($sum<90 && $sum >= 80){
                                    $style = " background-color:#dfe782;";
                                } else {
                                    $style = " background-color:#d03838;";
                                }
                                ?>
                                <td style="width:<?php echo $colwidth; ?>%;<?php echo $style; ?>" ><?php echo $sum; ?>%</td><!-- !pourcentage -->
                            <?php endforeach; ?>
                            <?php
                            $total = 0;
                            if($totalSatisfaction>0){
                                $total = round(($totalBySatisfaction/$totalSatisfaction) * 100);
                            }
                            if($total >= 90){
                                $style = " background-color:#63b451;";
                            } elseif($total<90 && $total >= 80){
                                $style = " background-color:#dfe782;";
                            } else {
                                $style = " background-color:#d03838;";
                            }
                            ?>
                            <td style="width:<?php echo $colwidth; ?>%;<?php echo $style; ?>"><?php echo $total; ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>

                </table>
            </td>
        </tr>
        <tr>
            <td style="width: 15%; padding-top:2mm; padding-bottom: 2mm;"></td>
            <td style="width: 85%; font-weight: bold; font-size:14pt; padding-top:4mm; padding-bottom: 6mm;" class="">Vert soutenu : 90% et +, vert clair : 80 à moins de 90%, rouge : &lt; 80% de satisfaits</td>
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
                    <?php foreach($datas_services_bis_shorts as $k=>$name): ?>
                        <tr>
                            <td style="width: 16%; background-color: #dfe782;"><?php echo $datas_services_bis[$k]; ?></td>
                            <?php $totalBySatisfaction = 0; ?>
                            <?php foreach($monthes as $l=>$w): ?>
                                <?php $totalBySatisfaction += $satisfactionByMonth[$w][$name][0]; ?>
                                <td style="width:<?php echo $colwidth; ?>%; background-color: #dfe782;">
                                    <?php if($satisfactionByMonthTotal[$w]>0){echo round(($satisfactionByMonth[$w][$name][0] / $satisfactionByMonthTotal[$w]) * 100);} else {echo "0";}  ?>%
                                </td><!-- !pourcentage -->
                            <?php endforeach; ?>
                            <?php
                            $total =0;
                            if($totalSatisfaction>0){
                                $total = round(($totalBySatisfaction/$totalSatisfaction) * 100);
                            }
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
