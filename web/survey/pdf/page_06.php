<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 12/05/14
 * Time: 10:23
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
    <table class="page-header">
        <tr>
            <td><span class="regular">Origine de la connaissance de l'hôtel</span></td>
        </tr>
    </table>
    <?php $cols = count($connaissancePercentByMonth) + 1; $colwidth = (84/$cols);?>
    <table class="table" style="width: 100%;" cellspacing="0">
        <thead>
            <tr>
                <th style="width: 16%;"></th>
                <?php $monthes = []; ?>
                <?php foreach($connaissancePercentByMonth as $name=>$v): ?>
                    <?php $monthes[] = $name; ?>
                    <th style="width:<?php echo $colwidth; ?>%;"><?php echo $name; ?></th>
                <?php endforeach; ?>
                <th style="width:<?php echo $colwidth; ?>%;">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($connaissance_types as $k=>$v): ?>

                <tr <?php if(($k+1)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                    <td style="width: 16%;"><?php echo $v; ?></td>
                    <?php foreach($monthes as $l=>$w): ?>
                        <td style="width:<?php echo $colwidth; ?>%;"><?php echo $connaissancePercentByMonth[$w][$k]; ?>%</td>
                    <?php endforeach; ?>
                    <td style="width:<?php echo $colwidth; ?>%;"><?php echo $connaissancePercentTotal[$k]; ?>%</td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<!-- TODO graph -->
</page>
