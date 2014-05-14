<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 14/05/14
 * Time: 12:36
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
    <bookmark title="Origine de la connaissance de l'hôtel - Région Parisienne" level="0"></bookmark>
    <table class="page-header">
        <tr>
            <td><span class="regular">Origine de la connaissance de l'hôtel - Région Parisienne</span></td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td style="width: 100%; text-align: center; font-weight: bold;">Comment avez-vous connu l'Hôtel Les Jardins de Beauval ? Etait-ce par...</td>
        </tr>
    </table>
    <!-- TODO charts Origine de la connaissance de l'hôtel - Région Parisienne -->




    <table class="table" style="width: 100%; font-size: 8pt;">
        <thead>
        <tr>
            <th style="width: 20%;">Départements</th>
            <?php foreach($region_paris as $num=>$name): ?>
                <th style="width: 10%;"><?php echo $num; ?>  <?php echo $name; ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
        <tbody>
        <?php foreach($connaissance_types as $k=>$ct): ?>
            <tr <?php if(($k+1)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                <td><?php echo $ct; ?></td>
                <?php foreach($resultsConnaissanceParisParDepts as $depNum=>$values): ?>
                    <td><?php echo round(($values[$k] / $resultsConnaissanceParisParDeptsTotal[$depNum]) * 100,1); ?>%</td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
</page>
