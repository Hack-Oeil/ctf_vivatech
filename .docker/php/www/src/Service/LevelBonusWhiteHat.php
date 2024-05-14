<?php
 
namespace App\Service;

class LevelBonusWhiteHat 
{
    public function verify() {
        if(isset($_SESSION['white_hat']) || $_SERVER['HTTP_USER_AGENT'] === 'EthicalTester/1.0') {
            $_SESSION['white_hat'] = true;
            return true;
        }
        return false;
    }

    // Flasg Complémentaire si tout les challenege
    public function verifyIsExpert(?int $level = null) {

        if($level !== null && $_SERVER['HTTP_USER_AGENT'] === 'EthicalTester/1.0') {
            if(!isset($_SESSION['EXPERT'])) $_SESSION['EXPERT'] = 0;
            $_SESSION['EXPERT']++;
            $_SESSION['EXPERT_LEVEL'][$level] = true;
        }
    }
}