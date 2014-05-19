<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 19/05/14
 * Time: 17:33
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
    <bookmark title="Type de chambre occupée et nombre de nuits" level="0"></bookmark>
    <table class="page-header">
        <tr>
            <td><span class="regular">Type de chambre occupée et nombre de nuits</span></td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td style="width: 100%; text-align: center; font-weight: bold;">Quel type de chambre avez-vous occupé pendant votre séjour à l'hôtel ?</td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td style="width: 100%; text-align: center;">
                <img src="img/chambre-annee.png" alt=""/>
            </td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td style="width: 100%; text-align: center; font-weight: bold;">Combien de nuits y avez-vous dormi ?</td>
        </tr>
    </table>

    <table style="width: 100%;">
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
                    <?php foreach($datas_nbr_nuits as $k=>$v): ?>
                        <tr <?php if(($k+1)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                            <td style="width: 50%;"><?php echo $v; ?></td>
                            <td style="width: 25%;"><?php echo $nuites[$k]; ?></td>
                            <td style="width: 25%;"><?php echo $nuitesPercent[$k]; ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                    <tr <?php if(($k+2)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                        <td style="width: 50%;">Total</td>
                        <td style="width: 25%;"><?php echo $countNuites; ?></td>
                        <td style="width: 25%;">100%</td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td style="width: 25%;"></td>
        </tr>
    </table>

</page>
