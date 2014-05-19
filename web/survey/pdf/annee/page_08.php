<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 19/05/14
 * Time: 17:27
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
    <bookmark title="Intention de revenir (fidélisation)" level="0"></bookmark>
    <table class="page-header">
        <tr>
            <td><span class="regular">Intention de revenir (fidélisation)</span></td>
        </tr>
    </table>
    <table style="width: 100%; margin-bottom: 10pt;">
        <tr>
            <td style="width: 100%; text-align: center; font-weight: bold; color: #97bf0d; font-size: 18pt;">Taux de fidélisation : <?php echo $revenirPercent[0] + $revenirPercent[1]; ?>%</td>
        </tr>
        <tr>
            <td style="width: 100%; text-align: center; font-weight: bold; color: #97bf0d; font-size: 18pt;">dont reviendrait "certainement" : <?php echo $revenirPercent[0]; ?>%</td>
        </tr>
    </table>
    <table style="width: 100%;">
        <tr>
            <td style="width: 100%; text-align: center; font-weight: bold;">Reviendriez-vous à l'Hôtel Les Jardins de Beauval si vous en aviez l'occasion ?</td>
        </tr>
    </table>
    <table style="width: 100%;">
        <tr>
            <td style="width: 100%; text-align: center;">
                <img src="img/revenir-annee.png" alt=""/>
            </td>
        </tr>
    </table>
</page>
