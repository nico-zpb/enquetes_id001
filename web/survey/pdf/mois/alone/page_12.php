<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 15/05/14
 * Time: 15:44
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
    <bookmark title="Principaux départements d'origine et durée du trajet" level="0"></bookmark>
    <table class="page-header">
        <tr>
            <td><span class="regular">Principaux départements d'origine et durée du trajet</span></td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 10%;"></td>
                        <td style="width: 80%; font-weight: bold;">
                            Merci de noter le numéro de votre département d'habitation (2 chiffres) ou votre pays de provenance si étranger:
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
                                        <th style="width: 25%;">Effectif</th>
                                        <th style="width: 25%;">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($selected as $k=>$sel): ?>
                                    <tr <?php if(($k+1)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                                        <td style="width: 50%;"><?php echo $sel["dept_num"] . " - " .$sel["dept_name"] ?></td>
                                        <td style="width: 25%;"><?php echo $sel["effectif"]; ?></td>
                                        <td style="width: 25%;"><?php echo $sel["percent"]; ?>%</td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr <?php if(($k+2)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                                        <td style="width: 50%;">Autres</td>
                                        <td style="width: 25%;"><?php echo $countEffectifOtherDepts; ?></td>
                                        <td style="width: 25%;"><?php echo round(($countEffectifOtherDepts / $numEntry) * 100,1); ?>%</td>
                                    </tr>
                                    <tr <?php if(($k+3)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                                        <td style="width: 50%;">Total</td>
                                        <td style="width: 25%;"><?php echo $numEntry; ?></td>
                                        <td style="width: 25%;">100%</td>
                                    </tr>
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
                            Combien de temps a duré votre trajet jusqu'à l'Hôtel Les Jardins de Beauval ?
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
                                    <th style="width: 25%;">Effectifs</th>
                                    <th style="width: 25%;">%</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($datas_tps_trajet as $k=>$v): ?>
                                    <tr <?php if(($k+1)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                                        <td style="width: 50%;"><?php echo $v; ?></td>
                                        <td style="width: 25%;"><?php echo $tpsTrajet[$k]; ?></td>
                                        <td style="width: 25%;"><?php echo $tpsTrajetPercent[$k]; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr <?php if(($k+2)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                                    <td style="width: 50%;">Total</td>
                                    <td style="width: 25%;"><?php echo $numEntry; ?></td>
                                    <td style="width: 25%;">100%</td>
                                </tr>

                                </tbody>
                            </table>
                        </td>
                        <td style="width: 10%;"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</page>
