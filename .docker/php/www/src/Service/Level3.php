<?php
 
namespace App\Service;


/**
 * SQL
 */
class Level3
{
    public function verify() {          
        // controller si on est coté 
        if(isset($_SESSION['level-2'])) {
            if(isset($_SESSION["level-3"]) || isset($_SESSION["user"])) {
                if(!isset($_SESSION["level-3"])) {
                    (new LevelBonusWhiteHat)->verifyIsExpert(3);
                    $_SESSION["level-3"] = true;
                }
                return true;
            }
        }
        return false;
    }
}