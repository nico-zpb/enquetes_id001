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

    <table>
        <thead>
            <tr>

            </tr>
        </thead>
        <tbody>
            <?php foreach($connaissance_types as $k=>$v): ?>
                <tr>
                    <td><?php echo $v; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


</page>
