<?php
 
namespace App\Service;

/**
 * XSS
 */
class Level2
{
    public function verify() {
        // controller si on est coté 
        if(isset($_SESSION['level-1'])) {
            if(isset($_SESSION["level-2"]) || (new HelperController)->secretIsCorrect($_COOKIE["jwt"]??'', 'afe9c5eb1a4454851')) {
                if(!isset($_SESSION["level-2"])) {
                    // Pour valider le vol de cookie en ethical il faut avoir envoyé 
                    // l'injection avec le UserAgent, on a mémorisé l'info dans $_SESSION['save_state_ethical_xss']
                    if($_SESSION['save_state_ethical_xss'] === true) {
                        unset($_SESSION['save_state_ethical_xss']); // on a plus besoin de conserver
                        (new LevelBonusWhiteHat)->verifyIsExpert(2);
                    }                    
                    $_SESSION["level-2"] = true;
                }
                return true;
            }
        }
        return false;
    }
}