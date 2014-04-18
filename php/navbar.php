<?php
/**
 * Created by PhpStorm.
 * User: Nicolas Canfrere
 * Date: 16/04/2014
 * Time: 13:10
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

<div class="navbar navbar-hotel navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/index.php">Les Jardins de Beauval - Enquêtes Clientèle</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li <?php if(isset($page) && $page == "enregistement"){ echo 'class="active"'; } ?>>
                    <a href="/enregistement.php">Enregistrer</a>
                </li>
                <li <?php if(isset($page) && $page == "faq"){ echo 'class="active"'; } ?>>
                    <a href="/faq.php">FAQ</a>
                </li>
                <?php if($isConnected): ?>
                <li>
                    <a href="/survey/index.php">Statistiques</a>
                </li>
                <?php endif; ?>
            </ul>
            <?php if($isConnected): ?>
                <a class="btn btn-hotel-inverse navbar-btn navbar-right" href="/logout.php">Déconnexion</a>
            <?php else: ?>
                <a class="btn btn-hotel-inverse navbar-btn navbar-right" href="/login.php">Connexion</a>
            <?php endif; ?>

        </div><!--/.navbar-collapse -->
    </div>
</div>
