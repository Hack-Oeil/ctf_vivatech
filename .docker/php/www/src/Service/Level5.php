<?php
 
namespace App\Service;

/**
 * inject CMD (allumer lumiere)
 */
class Level5
{
    public function verify() {
        // controller si on est coté 
        if(isset($_SESSION['level-4']) && isset($_SESSION["user"])) {
            if(isset($_SESSION["level-5"]) || 
                (isset($_SESSION['LIGHT_ON_API']) && $_SESSION['LIGHT_ON_API'] === true)
            ) {
                if(!isset($_SESSION["level-5"])) { 
                    if(isset($_SESSION['LIGHT_ON_API_ETHIQUE']) && $_SESSION['LIGHT_ON_API_ETHIQUE'] === true
                    ) {
                        (new LevelBonusWhiteHat)->verifyIsExpert(5);
                    }
                    $_SESSION["level-5"] = true;
                }
                unset($_SESSION['LIGHT_ON_API']); // on a plus besoin de conserver
                return true;
            }
        }
        return false;
    }
}