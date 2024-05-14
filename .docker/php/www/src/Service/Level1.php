<?php
 
namespace App\Service;

/**
 * Ip Spoofing
 */
class Level1 
{
    public function verify() {
        $ipClient = $this->getClientIP();
        // controller si on est coté 
        if(isset($_SESSION['game_started'])) {
            if(isset($_SESSION["level-1"]) || $ipClient === $_ENV['IP_VALID_1'] || $ipClient === $_ENV['IP_VALID_2']) {
                if(!isset($_SESSION["level-1"])) {
                    (new LevelBonusWhiteHat)->verifyIsExpert(1);
                    $_SESSION["level-1"] = true;
                }
                return true;
            }
        }
        return false;
    }

    private function getClientIP() 
    {
        // Ajouter True-Client-IP, and X-Real-IP
        // et Forwarded: for=
        $ip = null;
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_TRUE_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_TRUE_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_REAL_IP'])) {
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        } elseif (!empty($_SERVER['HTTP_FORWARDED']) && preg_match('/for=(\S+)/', $_SERVER['HTTP_FORWARDED'], $matches)) {
            $ip = $matches[1];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        
        if(filter_var($ip, FILTER_VALIDATE_IP)) {
            return $ip;
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
}
