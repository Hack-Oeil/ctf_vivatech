<?php
 
namespace App\Service;

class LevelBonusJob 
{
    public function verify() {
        if(isset($_SESSION['FLAG_JOB']) && $_SESSION['FLAG_JOB'] === true) {
            return true;
        }
        return false;
    }
}

