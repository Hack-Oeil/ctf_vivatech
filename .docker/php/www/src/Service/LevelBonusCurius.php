<?php
 
namespace App\Service;

class LevelBonusCurius 
{
    public function verify() {
        if($_SESSION['CURIUS']  || (isset($_SESSION['FLAG_CURIUS']) && 
            is_array($_SESSION['FLAG_CURIUS']) &&  
            sizeof($_SESSION['FLAG_CURIUS']) >=4)
        ) {
            $_SESSION['CURIUS'] = true;
            return true;
        }
        return false;
    }
}

