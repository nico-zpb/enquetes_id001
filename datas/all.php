<?php
/**
 * Created by PhpStorm.
 * User: grosloup
 * Date: 01/04/2014
 * Time: 17:44
 */
$departements = [
    "01"=>"Ain", "02"=>"Aisne", "03"=>"Allier", "04"=>"Alpes-de-Haute-Provence",
    "05"=>"Hautes-Alpes", "06"=>"Alpes-Maritimes", "07"=>"Ardèche", "08"=>"Ardennes",
    "09"=>"Ariège", "10"=>"Aube", "11"=>"Aude", "12"=>"Aveyron", "13"=>"Bouches-du-Rhône",
    "14"=>"Calvados", "15"=>"Cantal", "16"=>"Charente", "17"=>"Charente-Maritime", "18"=>"Cher",
    "19"=>"Corrèze", "2A" => "Corse-du-Sud", "2B" => "Haute-Corse", "21"=>"Côte-d'Or",
    "22"=>"Côtes-d'Armor", "23"=>"Creuse", "24"=>"Dordogne", "25"=>"Doubs", "26"=>"Drôme",
    "27"=>"Eure", "28"=>"Eure-et-Loir", "29"=>"Finistère", "30"=>"Gard", "31"=>"Haute-Garonne",
    "32"=>"Gers", "33"=>"Gironde", "34"=>"Hérault", "35"=>"Ille-et-Vilaine", "36"=>"Indre",
    "37"=>"Indre-et-Loire", "38"=>"Isère", "39"=>"Jura", "40"=>"Landes", "41"=>"Loir-et-Cher",
    "42"=>"Loire", "43"=>"Haute-Loire", "44"=>"Loire-Atlantique", "45"=>"Loiret", "46"=>"Lot",
    "47"=>"Lot-et-Garonne", "48"=>"Lozère", "49"=>"Maine-et-Loire", "50"=>"Manche", "51"=>"Marne",
    "52"=>"Haute-Marne", "53"=>"Mayenne", "54"=>"Meurthe-et-Moselle", "55"=>"Meuse", "56"=>"Morbihan",
    "57"=>"Moselle", "58"=>"Nièvre", "59"=>"Nord", "60"=>"Oise", "61"=>"Orne", "62"=>"Pas-de-Calais",
    "63"=>"Puy-de-Dôme", "64"=>"Pyrénées-Atlantiques", "65"=>"Hautes-Pyrénées", "66"=>"Pyrénées-Orientales",
    "67"=>"Bas-Rhin", "68"=>"Haut-Rhin", "69"=>"Rhône", "70"=>"Haute-Saône", "71"=>"Saône-et-Loire",
    "72"=>"Sarthe", "73"=>"Savoie", "74"=>"Haute-Savoie", "75"=>"Paris", "76"=>"Seine-Maritime",
    "77"=>"Seine-et-Marne", "78"=>"Yvelines", "79"=>"Deux-Sèvres", "80"=>"Somme", "81"=>"Tarn",
    "82"=>"Tarn-et-Garonne", "83"=>"Var", "84"=>"Vaucluse", "85"=>"Vendée", "86"=>"Vienne",
    "87"=>"Haute-Vienne", "88"=>"Vosges", "89"=>"Yonne", "90"=>"Territoire de Belfort",
    "91"=>"Essonne", "92"=>"Hauts-de-Seine", "93"=>"Seine-Saint-Denis", "94"=>"Val-de-Marne", "95"=>"Val-d'Oise",
    "971"=>"Guadeloupe","972"=>"Martinique","973"=>"Guyanne","974"=>"Réunion","976"=>"Mayotte",
    "100" => "Etranger",
];
$pays = [
    "Allemagne",
    "Belgique",
    "Espagne",
    "Italie",
    "Pays Bas",
    "Royaume Uni",
    "Autre",
];
$datas_mois=[
    "janvier","février","mars","avril","mai","juin","juillet","août","septembre","octobre","novembre","décembre"
];
$datas_mois_short=[
    "jan","fev","mar","avr","mai","jui","juil","aou","sep","oct","nov","dec"
];
$profession = ["agriculteur exploitant", "artisan, commercant, chef d'entreprise", "cadre supérieur, profession intellectuelle supérieure, professeur", "cadre moyen, profession intermédiaire", "employé", "ouvrier", "retaité", "autres inactifs (au foyer, chômeur, étudiant)" ];

$datas_trancheAge = [
    ["num"=>1, "name"=>"moins de 25 ans"],
    ["num"=>2, "name"=>"25 à 34 ans"],
    ["num"=>3, "name"=>"35 à 44 ans"],
    ["num"=>4, "name"=>"45 à 54 ans"],
    ["num"=>5, "name"=>"55 à 64 ans"],
    ["num"=>6, "name"=>"65 ans et plus"],
];

$datas_professions = [
  ["num"=>1,"name"=>"agriculteur exploitant"],
  ["num"=>2,"name"=>"artisan, commercant, chef d'entreprise"],
  ["num"=>3,"name"=>"cadre supérieur, profession intellectuelle supérieure, professeur"],
  ["num"=>4,"name"=>"cadre moyen, profession intermédiaire"],
  ["num"=>5,"name"=>"employé"],
  ["num"=>6,"name"=>"ouvrier"],
  ["num"=>7,"name"=>"retaité"],
  ["num"=>8,"name"=>"autres inactifs (au foyer, chômeur, étudiant)"],
];

$datas_satisfaction = [
    ["num"=>1,"name"=>"très satisfait"],
    ["num"=>2,"name"=>"satisfait"],
    ["num"=>3,"name"=>"peu satisfait"],
    ["num"=>4,"name"=>"pas du tout satisfait"],
];

$datas_satisfaction_bis = [
    "très satisfait","satisfait","peu satisfait","pas du tout satisfait",
];

$datas_intentions = ["certainement","problement","problement pas","certainement pas"];

$datas_services = [
    "les chambres",
    "la restauration",
    "le bar",
    "l'accueil",
    "l'environnement",
    "le rapport qualité/prix"
];

$datas_services_bis = [
    "globalement",
    "les chambres",
    "la restauration",
    "le bar",
    "l'accueil",
    "l'environnement",
    "le rapport qualité/prix"
];


$datas_services_bis_shorts = [
    "globalement",
    "chambres",
    "restauration",
    "bar",
    "accueil",
    "environnement",
    "rapport"
];
$datas_resto = [
    "l'amabilité du personnel",
    "la qualité du service",
    "la diversité des plats proposés",
    "la qualité des plats",
    "les vins",
    "les prix",
];

$datas_resto_shorts = [
    "resto_amabilite",
    "resto_service",
    "resto_diversite",
    "resto_plats",
    "resto_vins",
    "resto_prix",
];





$datas_perception_prix = [
    "trop cher","approprié","pas très cher"
];

$depsCentre = ["18","28","36","37","41","45"];
$depsParis = ["75","77","78","91","92","93","94","95"];
$depsLimit = ["03","23","49","58","72","86","87","89"];


$region_paris = [
    "75"=>"Paris",
    "77"=>"Seine et Marne",
    "78"=>"Yvelines",
    "91"=>"Essonne",
    "92"=>"Hauts-de-Seine",
    "93"=>"Seine-Saint-Denis",
    "94"=>"Val-de-Marne",
    "95"=>"Val-d'Oise",
];

$region_centre = [
    "18"=>"Cher",
    "28"=>"Eure-et-Loir",
    "36"=>"Indre",
    "37"=>"Indre-et-Loire",
    "41"=>"Loir-et-Cher",
    "45"=>"Loiret"
];



$deptParisNums = array_keys($region_paris);

$connaissance_types_small = [
  "un article","une affiche","le prospectus de l'hôtel","le prospectus du ZooParc","le bouche à oreille","votre C.E.","lors d'un séminaire","internet","un guide touristique","à la télé","autre",
];

$connaissance_types = [
    "un article dans la presse","une affiche","le prospectus de l'hôtel","le prospectus du ZooParc de Beauval","le bouche à oreille (amis, relations...)","votre comité d'entreprise","lors d'un séminaire","internet","un guide touristique","une émission de TV","autre",
];

$datas_tps_trajet = ["moins d'une heure","de 1 à 2 heures","plus de 2 heures"];


$datas_nbr_personnes = ["1","2","3","4","5 et plus","aucun"];

$datas_type_chambre = [
    "Familiale","Club","Junior Suite","Chambre pour personnes à mobilité réduite",
];

$datas_nbr_nuits = [
    "1 nuit","2 nuits","3 nuits","4 nuits et plus"
];

$datas_wifi = [
    "Oui, sans difficulté","J'ai cherché à me connecter mais j'ai eu des difficultés","Non, je n'ai pas cherché à me connecter",
];

$questions = [
    "Comment avez-vous connu l'Hôtel Les Jardins de Beauval ? Etait-ce par...",
    "Par quel autre moyen ?",
    "Merci de noter le numéro de votre département d'habitation (2 chiffres) ou votre pays de provenance si étranger:",
    "Pays étrangers",
    "Combien de temps a duré votre trajet jusqu'à l'Hôtel Les Jardins de Beauval ?",
    "Quel type de chambre avez-vous occupé pendant votre séjour à l'hôtel ?",
    "Merci d'indiquer votre date d'arrivée à l'hôtel",
    "Combien de nuits y avez-vous dormi ?",
    "Combien de personnes étiez-vous ? Adultes et enfants de 11 ans et plus",
    "Combien de personnes étiez-vous ? Enfants de moins de 11 ans",
    "Globalement, en ce qui concerne votre séjour à l'Hôtel Les Jardins de Beauval, diriez-vous que vous êtes :",
    "Au regard de la qualité des chambres et de l'environement de l'hôtel, avez-vous trouvé le prix :",
    "les chambres (confort, propreté, atmosphère)",
    "la restauration (qualité, diversité, prix, amabilité du personnel)",
    "le bar (ambiance, diversité, prix, amabilité du personnel)",
    "l'accueil du personnel en général (amabilité, rapidité, réactivité)",
    "l'environnement (décoration, jardin, atmosphère du lieu)",
    "le rapport qualité/prix",
    "l'amabilité du personnel",
    "la qualité du service",
    "la diversité des plats proposés",
    "la qualité des plats",
    "les vins (qualité et choix)",
    "les prix",
    "Si vous avez utilisé le SPA de l'hôtel, diriez-vous que vous êtes :",
    "Pendant votre séjour, avez-vous utilisé la connexion Internet wifi de l'hôtel ?",
    "Avez-vous visité le ZooParc de Beauval pendant votre séjour ?",
    "Reviendriez-vous à l'Hôtel Les Jardins de Beauval si vous en aviez l'occasion ?",
    "Et recommanderiez-vous l'hôtel à des proches ?",
    "Vous pouvez noter ici vos commentaires, remarques et suggestions par rapport à l'Hôtel Les Jardins de Beauval (chambres, restauration, bar, accueil...)",
    "Vous êtes :",
    "Dans quelle tranche d'âge vous situez-vous ?",
    "Quelle est votre profession ?",
    "Aimeriez-vous recevoir une ou deux fois par an des informations de l'hôtel (nouveautés, offres promotionnelles...) ?",
    "Civilité",
    "Nom :",
    "Prénom :",
    "Email :",
];





















