<?php
 
namespace App\Service;


/**
 * inject CMD (get api doc)
 */
class Level4
{
    public function verify() {
        // controller si on est coté 
        if(isset($_SESSION['level-3']) && isset($_SESSION["user"])) {            
            if(isset($_SESSION["level-4"]) || 
                (isset($_SESSION['FLAG_DOC_API']) && $_SESSION['FLAG_DOC_API'] === true)
            ) {
                if(!isset($_SESSION["level-4"])) {  
                    if(isset($_SESSION['HOME_API_ETHIQUE']) && $_SESSION['HOME_API_ETHIQUE'] === true &&
                        isset($_SESSION['DOC_API_ETHIQUE']) && $_SESSION['DOC_API_ETHIQUE'] === true
                    ) {
                        (new LevelBonusWhiteHat)->verifyIsExpert(4);
                    }
                    $_SESSION["level-4"] = true;
                }
                unset($_SESSION['FLAG_DOC_API']); // on a plus besoin de conserver
                return true;
            }
        }
        return false;
    }
}