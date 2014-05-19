<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 19/05/14
 * Time: 15:38
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
    <bookmark title="Evolution des résultats mensuels" level="0"></bookmark>
    <table class="page-header">
        <tr>
            <td><span class="regular">Profil des répondants</span></td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;"> <!-- genre -->
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; font-weight: bold;">
                            Vous êtes :
                        </td>
                        <td style="width: 5%;"></td>
                    </tr>
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%;">
                            <table style="width: 100%" class="table">
                                <thead>
                                <tr>
                                    <th style="width: 60%;"></th>
                                    <th style="width: 20%;">Effectif</th>
                                    <th style="width: 20%;">%</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="odd">
                                    <td style="width: 60%;">des hommes</td>
                                    <td style="width: 20%;"><?php echo $numMale; ?></td>
                                    <td style="width: 20%;"><?php echo $numMalePercent ?>%</td>
                                </tr>
                                <tr class="even">
                                    <td style="width: 60%;">des femmes</td>
                                    <td style="width: 20%;"><?php echo $numFemale; ?></td>
                                    <td style="width: 20%;"><?php echo $numFemalePercent ?>%</td>
                                </tr>
                                <tr class="odd">
                                    <td style="width: 60%;">Total</td>
                                    <td style="width: 20%;"><?php echo $numEntry; ?></td>
                                    <td style="width: 20%;">100%</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
            <td style="width: 50%;"> <!-- age -->
                <table style="w100%">
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%; font-weight: bold;">
                            Dans quelle tranche d'âge vous situez-vous ?
                        </td>
                        <td style="width: 5%;"></td>
                    </tr>
                    <tr>
                        <td style="width: 5%;"></td>
                        <td style="width: 90%;">
                            <table style="w100%" class="table">
                                <thead>
                                <tr>
                                    <th style="width: 60%;"></th>
                                    <th style="width: 20%;">Effectif</th>
                                    <th style="width: 20%;">%</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($tranchesAge as $k => $v): ?>
                                    <tr <?php if ($k === $highlightAge) { echo ' class="highlight"'; } else { if(($k+1)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} } ?>>
                                        <td style="width: 60%;"><?php echo $v["name"]; ?></td>
                                        <td style="width: 20%;"><?php echo $v["num"]; ?></td>
                                        <td style="width: 20%;"><?php echo $v["percent"]; ?>%</td>
                                    </tr>
                                <?php endforeach; $k++;?>
                                <tr <?php if(($k+1)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                                    <td style="width: 60%;">Total</td>
                                    <td style="width: 20%;"><?php echo $numEntry; ?></td>
                                    <td style="width: 20%;">100%</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                        <td style="width: 5%;"></td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>
    <table style="width: 100%;">
        <tr>
            <td style="width: 10%;"></td>
            <td style="width: 80%;"> <!-- prof -->
                <table style="width: 100%;">
                    <tr>
                        <td style="font-weight: bold;">
                            Quelle est votre profession ?
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table class="table" style="width: 100%;">
                                <thead>
                                <tr>
                                    <th style="width: 60%;"></th>
                                    <th style="width: 20%;">Effectif</th>
                                    <th style="width: 20%;">%</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($prof as $k => $v): ?>
                                    <tr <?php if ($k === $highlightProf) { echo ' class="highlight"'; } else { if(($k+1)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} } ?>>
                                        <td style="width: 60%;"><?php echo $v["name"]; ?></td>
                                        <td style="width: 20%;"><?php echo $v["num"]; ?></td>
                                        <td style="width: 20%;"><?php echo $v["percent"]; ?>%</td>
                                    </tr>
                                <?php endforeach; $k++;?>
                                <tr <?php if(($k+1)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                                    <td style="width: 60%;">Total</td>
                                    <td style="width: 20%;"><?php echo $numEntry; ?></td>
                                    <td style="width: 20%;">100%</td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
            <td style="width: 10%;"></td>
        </tr>
    </table>

</page>
