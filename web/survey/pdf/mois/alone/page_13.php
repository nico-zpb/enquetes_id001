<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 15/05/14
 * Time: 16:09
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
    <bookmark title="Nombre de personnes" level="0"></bookmark>
    <table class="page-header">
        <tr>
            <td><span class="regular">Nombre de personnes</span></td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 10%;"></td>
                        <td style="width: 80%; font-weight: bold;">
                            Adultes et enfants de 11 ans et plus
                        </td>
                        <td style="width: 10%;"></td>
                    </tr>
                    <tr>
                        <td style="width: 10%;"></td>
                        <td style="width: 80%;">
                            <table class="table" style="width: 100%;">
                                <thead>
                                <tr>
                                    <th style="width: 50%;"></th>
                                    <th style="width: 25%;">Effecfifs</th>
                                    <th style="width: 25%;">%</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($datas_nbr_personnes as $k=>$v): ?>
                                    <tr <?php if(($k+1)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                                        <td style="width: 50%;"><?php echo $v; ?></td>
                                        <td style="width: 25%;"><?php echo $nbrAdultes[$k]; ?></td>
                                        <td style="width: 25%;"><?php echo $nbrAdultesPercent[$k]; ?>%</td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </td>
                        <td style="width: 10%;"></td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%;">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 10%;"></td>
                        <td style="width: 80%; font-weight: bold;">
                            Enfants de moins de 11 ans
                        </td>
                        <td style="width: 10%;"></td>
                    </tr>
                    <tr>
                        <td style="width: 10%;"></td>
                        <td style="width: 80%;">
                            <table class="table" style="width: 100%;">
                                <thead>
                                <tr>
                                    <th style="width: 50%;"></th>
                                    <th style="width: 25%;">Effecfifs</th>
                                    <th style="width: 25%;">%</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($datas_nbr_personnes as $k=>$v): ?>
                                    <tr <?php if(($k+1)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                                        <td style="width: 50%;"><?php echo $v; ?></td>
                                        <td style="width: 25%;"><?php echo $nbrEnfants[$k]; ?></td>
                                        <td style="width: 25%;"><?php echo $nbrEnfantsPercent[$k]; ?>%</td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </td>
                        <td style="width: 10%;"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <table style="width: 100%; margin-top: 30mm;">
        <tr>
            <td style="width: 20%;"></td>
            <td style="width: 60%; font-weight: bold;">
                Nombre moyen de personnes
            </td>
            <td style="width: 20%;"></td>
        </tr>
        <tr>
            <td style="width: 20%;"></td>
            <td style="width: 60%;">
                <table class="table" style="width: 100%;">
                    <thead>
                    <tr>
                        <th style="width: 75%;"></th>
                        <th style="width: 25%;">Nombre moyen</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="odd">
                        <td style="width: 75%;">Adultes et enfants de 11 ans et plus</td>
                        <td style="width: 25%;"><?php echo $moyenAdulte = round(($nbrAdultes[0] + ($nbrAdultes[1]*2) +  ($nbrAdultes[2]*3) + ($nbrAdultes[3]*4) + ($nbrAdultes[4]*5)) / $counterPersons, 1);?></td>
                    </tr>
                    <tr class="even">
                        <td style="width: 75%;">Enfants de moins de 11 ans</td>
                        <td style="width: 25%;"><?php echo $moyenEnfant = round(($nbrEnfants[0] + ($nbrEnfants[1]*2) +  ($nbrEnfants[2]*3) + ($nbrEnfants[3]*4) + ($nbrEnfants[4]*5)) / $counterPersons, 1);?></td>
                    </tr>
                    <tr class="odd">
                        <td style="width: 75%;">Total</td>
                        <td style="width: 25%;"><?php echo $moyenAdulte + $moyenEnfant; ?></td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td style="width: 20%;"></td>
        </tr>
    </table>

</page>
