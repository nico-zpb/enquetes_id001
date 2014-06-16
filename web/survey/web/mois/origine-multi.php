<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 25/04/14
 * Time: 14:40
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
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h2>Origine de la connaissance de l'hôtel</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h3>Totalité de l'échantillon</h3>
                </div>
            </div>
            <div class="col-md-12">
                <p>Question : Comment avez-vous connu l'Hôtel Les Jardins de Beauval ? Etait-ce par...</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="barChartConnaissanceTotal"></div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header page-header-hotel">
                    <h3>Région Parisienne</h3>
                </div>
            </div>
            <div class="col-md-12">
                <p>
                    Question : Comment avez-vous connu l'Hôtel Les Jardins de Beauval ? Etait-ce par...
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="barChartConnaissanceParis"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4>En détail</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Départements</th>
                        <?php foreach($region_paris as $num=>$name): ?>
                            <th><?php echo $num; ?>  <?php echo $name; ?></th>
                        <?php endforeach; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($connaissance_types as $k=>$ct): ?>
                        <tr>
                            <td><?php echo $ct; ?></td>
                            <?php foreach($resultsConnaissanceParisParDepts as $depNum=>$values): ?>
                                <td><?php if($resultsConnaissanceParisParDeptsTotal[$depNum]>0){echo round(($values[$k] / $resultsConnaissanceParisParDeptsTotal[$depNum]) * 100);} else {echo "0";}  ?>%</td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
