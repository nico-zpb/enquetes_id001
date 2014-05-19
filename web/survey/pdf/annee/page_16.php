<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 19/05/14
 * Time: 17:34
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
            <td style="width: 25%;"></td>
            <td style="width: 50%; font-weight: bold;">
                Si vous avez utilisé le SPA de l'hôtel, diriez-vous que vous êtes :
            </td>
            <td style="width: 25%;"></td>
        </tr>
        <tr>
            <td style="width: 25%;"></td>
            <td style="width: 50%;">
                <table class="table" style="width: 100%;">
                    <thead>
                    <tr>
                        <th style="width: 50%;"></th>
                        <th style="width: 25%;">Effectifs</th>
                        <th style="width: 25%;">%</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($datas_satisfaction as $k => $v): ?>
                        <tr <?php if(($k+1)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                            <td style="width: 50%;"><?php echo $v["name"]; ?></td>
                            <td style="width: 25%;"><?php echo $spa[$k]; ?></td>
                            <td style="width: 25%;"><?php echo $spaPercent[$k]; ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                    <tr <?php if(($k+2)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                        <td style="width: 50%;">Total</td>
                        <td style="width: 25%;"><?php echo $spaCounter; ?></td>
                        <td style="width: 25%;">100%</td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td style="width: 25%;"></td>
        </tr>
    </table>

</page>
