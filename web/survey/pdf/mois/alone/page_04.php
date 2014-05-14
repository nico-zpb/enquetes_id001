<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 14/05/14
 * Time: 11:38
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
    <bookmark title="Satisfaction globale" level="0"></bookmark>
    <table class="page-header">
        <tr>
            <td><span class="regular">Satisfaction globale</span></td>
        </tr>
    </table>
    <?php
    $tauxSatisfaitTres = round(($globalSatisf[0] / $numEntry) * 100,1);
    $tauxSatisfait = round(($globalSatisf[1] / $numEntry) * 100,1);
    ?>
    <table style="width: 100%; margin-bottom: 10pt;">
        <tr>
            <td style="width: 100%; text-align: center; font-weight: bold; color: #97bf0d; font-size: 18pt;">Taux de satisfaits : <?php echo $tauxSatisfait + $tauxSatisfaitTres; ?>%</td>
        </tr>
        <tr>
            <td style="width: 100%; text-align: center; font-weight: bold; color: #97bf0d; font-size: 18pt;">dont "très satisfaits" : <?php echo $tauxSatisfaitTres; ?>%</td>
        </tr>
    </table>
    <table style="width: 100%;">
        <tr>
            <td style="width: 100%; text-align: center; font-weight: bold;">Globalement, en ce qui concerne votre séjour à l'Hôtel Les Jardins de Beauval, diriez-vous que vous êtes :</td>
        </tr>
    </table>

    <!-- TODO chart Satisfaction globale -->

</page>
