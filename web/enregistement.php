<?php
session_start();
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrère
 * Date: 16/04/2014
 * Time: 13:06
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

include_once "../php/functions.php";

$page = "enregistement";



include_once "../php/header.php";

include_once "../php/navbar.php";

include_once "../datas/all.php"
?>
<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <img src="/img/logo3.png" alt="Les Jardins de Beauval"/>
            </div>
            <div class="col-md-10">
                <h1>Enquêtes Clientèle</h1>
                <h2>Enregistrement des enquêtes</h2>
            </div>
        </div>

    </div>
</div>


<form action="/process.php" method="post">

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_1">Q1. Comment avez-vous connu l'Hôtel Les Jardins de Beauval ? Etait-ce par...</h3>

                    </div>
                    <div class="checkbox">
                        <label for="q1_1"><input type="checkbox" name="form[q1][res_1]" id="q1_1"> un article de pressse</label>
                    </div>
                    <div class="checkbox">
                        <label for="q1_2"><input type="checkbox" name="form[q1][res_2]" id="q1_2"/> une affiche</label>
                    </div>
                    <div class="checkbox">
                        <label for="q1_3"><input type="checkbox" name="form[q1][res_3]" id="q1_3"/> le prospectus de l'hôtel</label>
                    </div>
                    <div class="checkbox">
                        <label for="q1_4"><input type="checkbox" name="form[q1][res_4]" id="q1_4"/> le prospectus du ZooParc de Beauval</label>
                    </div>
                    <div class="checkbox">
                        <label for="q1_5"><input type="checkbox" name="form[q1][res_5]" id="q1_5"/> le bouche à oreille (amis, relations...)</label>
                    </div>
                    <div class="checkbox">
                        <label for="q1_6"><input type="checkbox" name="form[q1][res_6]" id="q1_6"/> votre Comité d'Entreprise</label>
                    </div>
                    <div class="checkbox">
                        <label for="q1_7"><input type="checkbox" name="form[q1][res_7]" id="q1_7"/> lors d'un séminaire</label>
                    </div>
                    <div class="checkbox">
                        <label for="q1_8"><input type="checkbox" name="form[q1][res_8]" id="q1_8"/> internet</label>
                    </div>
                    <div class="checkbox">
                        <label for="q1_9"><input type="checkbox" name="form[q1][res_9]" id="q1_9"/> un guide touristique</label>
                    </div>
                    <div class="checkbox">
                        <label for="q1_10"><input type="checkbox" name="form[q1][res_10]" id="q1_10"/> une émission TV</label>
                    </div>
                    <div class="checkbox">
                        <label for="q1_11"><input type="checkbox" name="form[q1][res_11]" id="q1_11"/> autre</label>
                    </div>
                    <div class="form-group">
                        <label class="" for="q1_12">Précisez :</label>
                        <textarea class="form-control" rows="3" name="form[q1][res_12]" id="q1_12"></textarea>
                    </div>
                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_2">Q2. Merci de noter le numéro de votre département d'habitation (2 chiffres) ou votre pays de provenance si étranger:</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <label class="" for="q2_1">Département :</label>
                            <input type="text" name="form[q2][res_1]" id="q2_1" class="form-control"/>
                        </div>
                        <div class="col-md-4">
                            <label class="" for="q2_2">Pays :</label>
                            <input type="text" name="form[q2][res_2]" id="q2_2" value="France" class="form-control"/>
                        </div>
                    </div>


                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_3">Q3. Combien de temps a duré votre trajet jusqu'à l'Hôtel Les Jardins de Beauval ?</h3>
                    </div>
                    <div class="radio">
                        <label for="q3_1"><input type="radio" value="1" name="form[q3]" id="q3_1"/> moins d'une heure</label>
                    </div>

                    <div class="radio">
                        <label for="q3_2"><input type="radio" value="2" name="form[q3]" id="q3_2"/> de 1 à 2 heures</label>
                    </div>

                    <div class="radio">
                        <label for="q3_3"><input type="radio" value="3" name="form[q3]" id="q3_3"/> plus de 2 heures</label>
                    </div>

                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_4">Q4. Quel type de chambre avez-vous occupé pendant votre séjour à l'hôtel ?</h3>
                    </div>
                    <div class="radio">
                        <label for="q4_1"><input type="radio" name="form[q4]" value="1" id="q4_1"/> Familiale</label>
                    </div>

                    <div class="radio">
                        <label for="q4_2"><input type="radio" name="form[q4]" value="2" id="q4_2"/> Club</label>
                    </div>

                    <div class="radio">
                        <label for="q4_3"><input type="radio" name="form[q4]" value="3" id="q4_3"/> Junior Suite</label>
                    </div>

                    <div class="radio">
                        <label for="q4_4"><input type="radio" name="form[q4]" value="4" id="q4_4"/> Chambre pour personnes à mobilité réduite</label>
                    </div>
                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <?php
                $dateTimeZone = new DateTimeZone("Europe/Paris");
                $date = new DateTime('now', $dateTimeZone);
                $annee = $date->format("Y");
                $mois = $date->format("n");
                $jour = $date->format("j");
                $joursDansMois = $date->format("t");
                $yearRange = range($annee-4, $annee);
                ?>
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_5">Q5. Merci d'indiquer votre date d'arrivée à l'hôtel</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="q5_annee">Année :</label>
                            <select name="form[q5][annee]" id="q5_annee" class="form-control">
                                <?php foreach($yearRange as $year): ?>
                                    <option value="<?php echo $year; ?>" <?php if($year == $annee) { echo 'selected="selected"'; } ?>><?php echo $year; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="q5_mois">Mois :</label>
                            <select name="form[q5][mois]" id="q5_mois" class="form-control">
                                <?php foreach($datas_mois as $k=>$v): ?>
                                    <option value="<?php echo $k+1; ?>" <?php if($k+1 == $mois) { echo 'selected="selected"'; } ?>><?php echo $v; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="q5_jour">Jour :</label>
                            <select name="form[q5][jour]" id="q5_jour" class="form-control">
                                <?php for($i=0;$i<$joursDansMois; $i++): ?>
                                    <option value="<?php echo $i+1; ?>" <?php if($i+1 == $jour) { echo 'selected="selected"'; } ?>><?php echo $i+1; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_6">Q6. Combien de nuits y avez-vous dormi ?</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label class="" for="q6">Nombre de nuits :</label>
                            <input type="text" name="form[q6]" id="q6" class="form-control"/>
                        </div>
                        <div class="col-md-7"></div>
                    </div>
                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_7">Q7. Combien de personnes étiez-vous ?</h3>
                    </div>

                    <h4>Adultes et enfants de 11 ans et plus</h4>
                    <div class="radio">
                        <label for="q7_1_1"><input type="radio" name="form[q7_1]" value="1" id="q7_1_1"/> 1</label>
                    </div>
                    <div class="radio">
                        <label for="q7_1_2"><input type="radio" name="form[q7_1]" value="2" id="q7_1_2"/> 2</label>
                    </div>
                    <div class="radio">
                        <label for="q7_1_3"><input type="radio" name="form[q7_1]" value="3" id="q7_1_3"/> 3</label>
                    </div>
                    <div class="radio">
                        <label for="q7_1_4"><input type="radio" name="form[q7_1]" value="4" id="q7_1_4"/> 4</label>
                    </div>
                    <div class="radio">
                        <label for="q7_1_5"><input type="radio" name="form[q7_1]" value="5" id="q7_1_5"/> 5 ou plus</label>
                    </div>
                    <div class="radio">
                        <label for="q7_1_6"><input type="radio" name="form[q7_1]" value="0" id="q7_1_6"/> aucun</label>
                    </div>

                    <h4>Enfants de moins de 11 ans</h4>
                    <div class="radio">
                        <label for="q7_2_1"><input type="radio" name="form[q7_2]" value="1" id="q7_2_1"/> 1</label>
                    </div>
                    <div class="radio">
                        <label for="q7_2_2"><input type="radio" name="form[q7_2]" value="2" id="q7_2_2"/> 2</label>
                    </div>
                    <div class="radio">
                        <label for="q7_2_3"><input type="radio" name="form[q7_2]" value="3" id="q7_2_3"/> 3</label>
                    </div>
                    <div class="radio">
                        <label for="q7_2_4"><input type="radio" name="form[q7_2]" value="4" id="q7_2_4"/> 4</label>
                    </div>
                    <div class="radio">
                        <label for="q7_2_5"><input type="radio" name="form[q7_2]" value="5" id="q7_2_5"/> 5 ou plus</label>
                    </div>
                    <div class="radio">
                        <label for="q7_2_6"><input type="radio" name="form[q7_2]" value="0" id="q7_2_6"/> aucun</label>
                    </div>

                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_8">Q8. Globalement, en ce qui concerne votre séjour à l'Hôtel Les Jardins de Beauval, diriez-vous que vous êtes :</h3>
                    </div>
                    <div class="radio">
                        <label for="q8_1"><input type="radio" name="form[q8]" value="1" id="q8_1"/> très satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q8_2"><input type="radio" name="form[q8]" value="2" id="q8_2"/> satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q8_3"><input type="radio" name="form[q8]" value="3" id="q8_3"/> peu satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q8_4"><input type="radio" name="form[q8]" value="4" id="q8_4"/> pas du satisfait</label>
                    </div>
                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_9">Q9. Au regard de la qualité des chambres et de l'environement de l'hôtel, avez-vous trouvé le prix :</h3>
                    </div>
                    <div class="radio">
                        <label for="q9_1"><input type="radio" name="form[q9]" value="1" id="q9_1"/> trop cher</label>
                    </div>
                    <div class="radio">
                        <label for="q9_2"><input type="radio" name="form[q9]" value="2" id="q9_2"/> approprié</label>
                    </div>
                    <div class="radio">
                        <label for="q9_3"><input type="radio" name="form[q9]" value="3" id="q9_3"/> pas très cher</label>
                    </div>
                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_10">Q10. Et plus particulièrement, êtes-vous satisfait(e) des points suivants ?</h3>
                    </div>

                    <h4>les chambres (confort, propreté, atmosphère)</h4>
                    <div class="radio">
                        <label for="q10_1_1"><input type="radio" name="form[q10_1]" value="1" id="q10_1_1"/> très satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q10_1_2"><input type="radio" name="form[q10_1]" value="2" id="q10_1_2"/> satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q10_1_3"><input type="radio" name="form[q10_1]" value="3" id="q10_1_3"/> peu satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q10_1_4"><input type="radio" name="form[q10_1]" value="4" id="q10_1_4"/> pas du satisfait</label>
                    </div>


                    <h4>la restauration (qualité, diversité, prix, amabilité du personnel)</h4>
                    <div class="radio">
                        <label for="q10_2_1"><input type="radio" name="form[q10_2]" value="1" id="q10_2_1"/> très satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q10_2_2"><input type="radio" name="form[q10_2]" value="2" id="q10_2_2"/> satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q10_2_3"><input type="radio" name="form[q10_2]" value="3" id="q10_2_3"/> peu satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q10_2_4"><input type="radio" name="form[q10_2]" value="4" id="q10_2_4"/> pas du satisfait</label>
                    </div>


                    <h4>le bar (ambiance, diversité, prix, amabilité du personnel)</h4>
                    <div class="radio">
                        <label for="q10_3_1"><input type="radio" name="form[q10_3]" value="1" id="q10_3_1"/> très satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q10_3_2"><input type="radio" name="form[q10_3]" value="2" id="q10_3_2"/> satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q10_3_3"><input type="radio" name="form[q10_3]" value="3" id="q10_3_3"/> peu satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q10_3_4"><input type="radio" name="form[q10_3]" value="4" id="q10_3_4"/> pas du satisfait</label>
                    </div>


                    <h4>l'accueil du personnel en général (amabilité, rapidité, réactivité)</h4>
                    <div class="radio">
                        <label for="q10_4_1"><input type="radio" name="form[q10_4]" value="1" id="q10_4_1"/> très satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q10_4_2"><input type="radio" name="form[q10_4]" value="2" id="q10_4_2"/> satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q10_4_3"><input type="radio" name="form[q10_4]" value="3" id="q10_4_3"/> peu satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q10_4_4"><input type="radio" name="form[q10_4]" value="4" id="q10_4_4"/> pas du satisfait</label>
                    </div>


                    <h4>l'environnement (décoration, jardin, atmosphère du lieu)</h4>
                    <div class="radio">
                        <label for="q10_5_1"><input type="radio" name="form[q10_5]" value="1" id="q10_5_1"/> très satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q10_5_2"><input type="radio" name="form[q10_5]" value="2" id="q10_5_2"/> satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q10_5_3"><input type="radio" name="form[q10_5]" value="3" id="q10_5_3"/> peu satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q10_5_4"><input type="radio" name="form[q10_5]" value="4" id="q10_5_4"/> pas du satisfait</label>
                    </div>


                    <h4>le rapport qualité/prix</h4>
                    <div class="radio">
                        <label for="q10_6_1"><input type="radio" name="form[q10_6]" value="1" id="q10_6_1"/> très satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q10_6_2"><input type="radio" name="form[q10_6]" value="2" id="q10_6_2"/> satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q10_6_3"><input type="radio" name="form[q10_6]" value="3" id="q10_6_3"/> peu satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q10_6_4"><input type="radio" name="form[q10_6]" value="4" id="q10_6_4"/> pas du satisfait</label>
                    </div>

                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_11">Q11. En ce qui concerne la restauration de l'hôtel, avez-vous été satisfait de :</h3>
                    </div>
                    <h4>l'amabilité du personnel</h4>
                    <div class="radio">
                        <label for="q11_1_1"><input type="radio" name="form[q11_1]" value="1" id="q11_1_1"/> très satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q11_1_2"><input type="radio" name="form[q11_1]" value="2" id="q11_1_2"/> satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q11_1_3"><input type="radio" name="form[q11_1]" value="3" id="q11_1_3"/> peu satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q11_1_4"><input type="radio" name="form[q11_1]" value="4" id="q11_1_4"/> pas du satisfait</label>
                    </div>

                    <h4>la qualité du service</h4>
                    <div class="radio">
                        <label for="q11_2_1"><input type="radio" name="form[q11_2]" value="1" id="q11_2_1"/> très satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q11_2_2"><input type="radio" name="form[q11_2]" value="2" id="q11_2_2"/> satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q11_2_3"><input type="radio" name="form[q11_2]" value="3" id="q11_2_3"/> peu satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q11_2_4"><input type="radio" name="form[q11_2]" value="4" id="q11_2_4"/> pas du satisfait</label>
                    </div>

                    <h4>la diversité des plats proposés</h4>
                    <div class="radio">
                        <label for="q11_3_1"><input type="radio" name="form[q11_3]" value="1" id="q11_3_1"/> très satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q11_3_2"><input type="radio" name="form[q11_3]" value="2" id="q11_3_2"/> satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q11_3_3"><input type="radio" name="form[q11_3]" value="3" id="q11_3_3"/> peu satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q11_3_4"><input type="radio" name="form[q11_3]" value="4" id="q11_3_4"/> pas du satisfait</label>
                    </div>

                    <h4>la qualité des plats</h4>
                    <div class="radio">
                        <label for="q11_4_1"><input type="radio" name="form[q11_4]" value="1" id="q11_4_1"/> très satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q11_4_2"><input type="radio" name="form[q11_4]" value="2" id="q11_4_2"/> satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q11_4_3"><input type="radio" name="form[q11_4]" value="3" id="q11_4_3"/> peu satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q11_4_4"><input type="radio" name="form[q11_4]" value="4" id="q11_4_4"/> pas du satisfait</label>
                    </div>

                    <h4>les vins (qualité et choix)</h4>
                    <div class="radio">
                        <label for="q11_5_1"><input type="radio" name="form[q11_5]" value="1" id="q11_5_1"/> très satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q11_5_2"><input type="radio" name="form[q11_5]" value="2" id="q11_5_2"/> satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q11_5_3"><input type="radio" name="form[q11_5]" value="3" id="q11_5_3"/> peu satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q11_5_4"><input type="radio" name="form[q11_5]" value="4" id="q11_5_4"/> pas du satisfait</label>
                    </div>

                    <h4>les prix</h4>
                    <div class="radio">
                        <label for="q11_6_1"><input type="radio" name="form[q11_6]" value="1" id="q11_6_1"/> très satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q11_6_2"><input type="radio" name="form[q11_6]" value="2" id="q11_6_2"/> satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q11_6_3"><input type="radio" name="form[q11_6]" value="3" id="q11_6_3"/> peu satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q11_6_4"><input type="radio" name="form[q11_6]" value="4" id="q11_6_4"/> pas du satisfait</label>
                    </div>

                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_12">Q12. Si vous avez utilisé le SPA de l'hôtel, diriez-vous que vous êtes :</h3>
                    </div>
                    <div class="radio">
                        <label for="q12_1"><input type="radio" name="form[q12]" value="1" id="q12_1"/> très satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q12_2"><input type="radio" name="form[q12]" value="2" id="q12_2"/> satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q12_3"><input type="radio" name="form[q12]" value="3" id="q12_3"/> peu satisfait</label>
                    </div>
                    <div class="radio">
                        <label for="q12_4"><input type="radio" name="form[q12]" value="4" id="q12_4"/> pas du satisfait</label>
                    </div>
                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_13">Q13. Pendant votre séjour, avez-vous utilisé la connexion Internet wifi de l'hôtel ?</h3>
                    </div>
                    <div class="radio">
                        <label for="q13_1"><input type="radio" name="form[q13]" value="1" id="q13_1"/> oui, sans difficulté</label>
                    </div>
                    <div class="radio">
                        <label for="q13_2"><input type="radio" name="form[q13]" value="2" id="q13_2"/> j'ai cherché à me connecter mais j'ai eu des difficultés</label>
                    </div>
                    <div class="radio">
                        <label for="q13_3"><input type="radio" name="form[q13]" value="3" id="q13_3"/> Non je n'ai pas cherché à me connecter</label>
                    </div>

                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_14">Q14. Avez-vous visité le ZooParc de Beauval pendant votre séjour ?</h3>
                    </div>
                    <div class="radio">
                        <label for="q14_1"><input type="radio" name="form[q14]" value="1" id="q14_1"/> oui</label>
                    </div>
                    <div class="radio">
                        <label for="q14_2"><input type="radio" name="form[q14]" value="2" id="q14_2"/> non</label>
                    </div>
                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_15">Q15. Reviendriez-vous à l'Hôtel Les Jardins de Beauval si vous en aviez l'occasion ?</h3>
                    </div>
                    <div class="radio">
                        <label for="q15_1"><input type="radio" name="form[q15]" value="1" id="q15_1"/> probablement</label>
                    </div>
                    <div class="radio">
                        <label for="q15_2"><input type="radio" name="form[q15]" value="2" id="q15_2"/> certainement</label>
                    </div>
                    <div class="radio">
                        <label for="q15_3"><input type="radio" name="form[q15]" value="3" id="q15_3"/> propablement pas</label>
                    </div>
                    <div class="radio">
                        <label for="q15_4"><input type="radio" name="form[q15]" value="4" id="q15_4"/> certainement pas</label>
                    </div>
                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_16">Q16. Et recommanderiez-vous l'hôtel à des proches ?</h3>
                    </div>
                    <div class="radio">
                        <label for="q16_1"><input type="radio" name="form[q16]" value="1" id="q16_1"/> probablement</label>
                    </div>
                    <div class="radio">
                        <label for="q16_2"><input type="radio" name="form[q16]" value="2" id="q16_2"/> certainement</label>
                    </div>
                    <div class="radio">
                        <label for="q16_3"><input type="radio" name="form[q16]" value="3" id="q16_3"/> propablement pas</label>
                    </div>
                    <div class="radio">
                        <label for="q16_4"><input type="radio" name="form[q16]" value="4" id="q16_4"/> certainement pas</label>
                    </div>
                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_17">Q17. Vous pouvez noter ici vos commentaires, remarques et suggestions par rapport à l'Hôtel Les Jardins de Beauval (chambres, restauration, bar, accueil...)</h3>
                    </div>
                    <div class="form-group">
                        <label class="" for="q17">Commentaires :</label>
                        <textarea class="form-control" rows="6" name="form[q17]" id="q17"></textarea>
                    </div>
                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_18">Q18. Vous êtes :</h3>
                    </div>
                    <div class="radio">
                        <label for="q18_1"><input type="radio" name="form[q18]" value="1" id="q18_1"/> un homme</label>
                    </div>
                    <div class="radio">
                        <label for="q18_2"><input type="radio" name="form[q18]" value="2" id="q18_2"/> une femme</label>
                    </div>
                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_19">Q19. Dans quelle tranche d'âge vous situez-vous ?</h3>
                    </div>
                    <div class="radio">
                        <label for="q19_1"><input type="radio" name="form[q19]" value="1" id="q19_1"/> moins de 25 ans</label>
                    </div>
                    <div class="radio">
                        <label for="q19_2"><input type="radio" name="form[q19]" value="2" id="q19_2"/> 25 à 34 ans</label>
                    </div>
                    <div class="radio">
                        <label for="q19_3"><input type="radio" name="form[q19]" value="3" id="q19_3"/> 35 à 44ans</label>
                    </div>
                    <div class="radio">
                        <label for="q19_4"><input type="radio" name="form[q19]" value="4" id="q19_4"/> 45 à 54 ans</label>
                    </div>
                    <div class="radio">
                        <label for="q19_5"><input type="radio" name="form[q19]" value="5" id="q19_5"/> 55 à 64 ans</label>
                    </div>
                    <div class="radio">
                        <label for="q19_6"><input type="radio" name="form[q19]" value="6" id="q19_6"/> 65 et plus</label>
                    </div>

                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_20">Q20. Quelle est votre profession ?</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="q20">Profession :</label>
                            <select class="form-control" name="form[q20]" id="q20">
                                <option value="0" selected="selected"></option>
                                <?php foreach($profession as $k=>$v): ?>
                                    <option value="<?php echo $k+1; ?>"><?php echo $v; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3 id="question_21">Q21. Aimeriez-vous recevoir une ou deux fois par an des informations de l'hôtel (nouveautés, offres promotionnelles...) ?</h3>
                    </div>
                    <div class="radio">
                        <label for="q21_1"><input type="radio" name="form[q21]" value="1" id="q21_1"/> oui</label>
                    </div>
                    <div class="radio">
                        <label for="q21_2"><input type="radio" name="form[q21]" value="2" id="q21_2"/> non</label>
                    </div>


                    <h4>Infos</h4>
                    <div class="form-group">
                        <label for="q_nom">Nom :</label>
                        <input type="text" class="form-control" name="form[q_nom]" id="q_nom"/>
                    </div>
                    <div class="form-group">
                        <label for="q_prenom">Prénom :</label>
                        <input type="text" class="form-control" name="form[q_prenom]" id="q_prenom"/>
                    </div>
                    <div class="form-group">
                        <label for="q_email">Email :</label>
                        <input type="text" class="form-control" name="form[q_email]" id="q_email"/>
                    </div>
                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>

<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <!-- ---------------------------------------------------------------------------------------------------------------- -->
                <section class="question">
                    <div class="page-header page-header-hotel">
                        <h3>Enregistrer</h3>
                    </div>
                    <button type="submit" class="btn btn-hotel">Enregistrer</button>
                </section>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
</div>
</form>
<div class="container">
    <!-- Example row of columns -->


    <hr>

    <footer>
        <p>&copy; ZooParc de Beauval 2014</p>
    </footer>
</div> <!-- /container -->

<script src="/js/apps/main.js"></script>
<script src="/js/vendor/bootstrap.min.js"></script>

</body>
</html>
