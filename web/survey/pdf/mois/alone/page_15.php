<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 15/05/14
 * Time: 17:28
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
    <bookmark title="Visite du ZooParc pendant la durée du séjour" level="0"></bookmark>
    <table class="page-header">
        <tr>
            <td><span class="regular">Visite du ZooParc pendant la durée du séjour</span></td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td style="width: 25%;"></td>
            <td style="width: 50%; font-weight: bold;">
                Avez-vous visité le ZooParc de Beauval pendant votre séjour ?
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
                    <tr class="odd">
                        <td style="width: 50%;">Oui</td>
                        <td style="width: 25%;"><?php echo $visiteZoo[0]; ?></td>
                        <td style="width: 25%;"><?php echo $visiteZooPercent[0]; ?>%</td>
                    </tr>
                    <tr class="even">
                        <td style="width: 50%;">Non</td>
                        <td style="width: 25%;"><?php echo $visiteZoo[1]; ?></td>
                        <td style="width: 25%;"><?php echo $visiteZooPercent[1]; ?>%</td>
                    </tr>
                    <tr class="odd">
                        <td style="width: 50%;">Total</td>
                        <td style="width: 25%;"><?php echo $countVisite; ?></td>
                        <td style="width: 25%;">100%</td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td style="width: 25%;"></td>
        </tr>
    </table>
</page>
