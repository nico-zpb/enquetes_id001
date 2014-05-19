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
    <bookmark title="Utilisation de la connexion Wifi de l'hôtel" level="0"></bookmark>
    <table class="page-header">
        <tr>
            <td><span class="regular">Utilisation de la connexion Wifi de l'hôtel</span></td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td style="width: 25%;"></td>
            <td style="width: 50%; font-weight: bold;">
                Pendant votre séjour, avez-vous utilisé la connexion Internet wifi de l'hôtel ?
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
                    <?php foreach($datas_wifi as $k=>$v): ?>
                        <tr <?php if(($k+1)%2 == 0){echo 'class="even"'; } else {echo 'class="odd"';} ?>>
                            <td style="width: 50%;"><?php echo $v; ?></td>
                            <td style="width: 25%;"><?php echo $wifi[$k]; ?></td>
                            <td style="width: 25%;"><?php echo $wifiPercent[$k]; ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </td>
            <td style="width: 25%;"></td>
        </tr>
    </table>
</page>
