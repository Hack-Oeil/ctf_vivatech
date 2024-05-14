<?php
 
namespace App\Service;

/**
 * Déclaration via webmail
 */
class Level6
{
    public function verify() {
        if(isset($_SESSION["level-5"]) && isset($_SESSION['FLAG_FINAL'])) {
            if(!isset($_SESSION["level-6"]) ) { 
                $_SESSION["level-6"] = true;
            }
            // si n'existe pas encore on force le ethical car c'est le flag final 
            return true;
        }
        return false;
    }
}