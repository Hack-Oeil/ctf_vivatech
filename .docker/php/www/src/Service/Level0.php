<?php
 
namespace App\Service;

/**
 * Démarrage du challenge en cliquant sur le bouton soumettre
 */
class Level0 
{
    public function verify() {
        if(sizeof($_POST)>0 || isset($_SESSION['game_started'])) { 
            if(!isset($_SESSION['game_started'])) {
                (new LevelBonusWhiteHat)->verifyIsExpert(0);
                $_SESSION['game_started'] = true; 
            }
            return true;
        }
        // Si on arrive ici on supprime le cookie c'est que la session a été réinitialisé
        // mais par pour le bot ^^
        if($_SERVER["REMOTE_ADDR"] !== $_ENV['BOT_IP']) {
            setCookie('jwt', $this->jwt, time()-1);
        }
        return false;
    }
}
