*<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 14/05/14
 * Time: 12:25
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
    <table style="width: 100%; margin-bottom: 10pt;">
        <tr>
            <td style="width: 100%; text-align: center; font-weight: bold; color: #97bf0d; font-size: 18pt;">Taux de recommandation : <?php echo $recommanderPercent[0] + $recommanderPercent[1]; ?>%</td>
        </tr>
        <tr>
            <td style="width: 100%; text-align: center; font-weight: bold; color: #97bf0d; font-size: 18pt;">dont "certainement" : <?php echo $recommanderPercent[0]; ?>%</td>
        </tr>
    </table>
    <table style="width: 100%;">
        <tr>
            <td style="width: 100%; text-align: center; font-weight: bold;">Et recommanderiez-vous l'hôtel à des proches ?</td>
        </tr>
    </table>
    <!-- TODO charts Recommandation à des proches -->
    <table style="width: 100%;">
        <tr>
            <td style="width: 100%; text-align: center;">
                <img src="img/recommander.png" alt=""/>
            </td>
        </tr>
    </table>
</page>
