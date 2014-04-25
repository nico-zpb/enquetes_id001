<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 25/04/14
 * Time: 12:57
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
                <div class="page-header-hotel page-header">
                    <h2>Satisfaction, fidélisation et promotion</h2>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header-hotel page-header">
                    <h3>Satisfaction globale</h3>
                </div>

            </div>
            <div class="col-md-12">
                <?php
                $tauxSatisfaitTres = round(($globalSatisf[0] / $numEntry) * 100);
                $tauxSatisfait = round(($globalSatisf[1] / $numEntry) * 100)
                ?>
                <h4 class="text-success text-center">taux de satisfaits : <?php echo $tauxSatisfait + $tauxSatisfaitTres; ?>% dont <?php echo $tauxSatisfaitTres; ?>% de "très satisfaits".</h4>
                <p>Question : &laquo; Globalement, en ce qui concerne votre séjour à l'Hôtel Les Jardins de Beauval, diriez-vous que vous êtes &raquo;</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="pieChartGlobalSatisf"></div>
            </div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header-hotel page-header">
                    <h3>Satisfaction des différents services</h3>
                </div>

            </div>
            <div class="col-md-12">
                <p>Question : &laquo; Et plus particulièrement, êtes-vous satisfait(e) des points suivants &raquo;</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="fullStackedBarServicesSatif"></div>
            </div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header-hotel page-header">
                    <h3>Perception du rapport qualité/prix de l'hôtel</h3>
                </div>

            </div>
            <div class="col-md-12">
                <p>Question : &laquo; Au regard de la qualité des chambres et de l'environement de l'hôtel, avez-vous trouvé le prix &raquo;</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="pieChartPerceptionPrix"></div>
            </div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header-hotel page-header">
                    <h3>Satisfaction concernant la restauration</h3>
                </div>

            </div>
            <div class="col-md-12">
                <p>Question : &laquo; En ce qui concerne la restauration de l'hôtel, avez-vous été satisfait de &raquo;</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="fullStackedBarRestoSatif"></div>
            </div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header-hotel page-header">
                    <h3>Intention de revenir</h3>
                </div>

            </div>
            <div class="col-md-12">
                <h4 class="text-center text-success">Taux de fidélisation : <?php echo $revenirPercent[0] + $revenirPercent[1]; ?>%, dont reviendrait &laquo; certainement &raquo; : <?php echo $revenirPercent[0]; ?>%</h4>
                <p>Question : &laquo; Reviendriez-vous à l'Hôtel Les Jardins de Beauval si vous en aviez l'occasion &raquo;</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="pieChartRevenir"></div>
            </div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header-hotel page-header">
                    <h3>Recommandation à des proches</h3>
                </div>

            </div>
            <div class="col-md-12">
                <h4 class="text-center text-success">Taux de recommandation : <?php echo $recommanderPercent[0] + $recommanderPercent[1]; ?>%, dont &laquo; certainement &raquo; : <?php echo $recommanderPercent[0]; ?>%</h4>
                <p>Question : &laquo; Et recommanderiez-vous l'hôtel à des proches &raquo;</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="pieChartRecommander"></div>
            </div>
        </div>
    </div>
</div>
