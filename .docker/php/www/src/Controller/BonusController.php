<?php
 
namespace App\Controller;

use Yoop\AbstractController;


class BonusController extends AbstractController
{
    public function whiteHat() 
    {
        if(!isset($_SESSION['FLAG_CURIUS'])) { $_SESSION['FLAG_CURIUS'] = []; }
        $_SESSION['FLAG_CURIUS']['security.txt'] = true;

        header("Content-Type: text/plain");

        //return $whiteHat; [HTTP_HOST] => localhost:84 
        return $this->render('security/security', [
            'protocol'      => $_SERVER['REQUEST_SCHEME'],
            'httpServer'    => (!empty($_SERVER['HTTP_X_FORWARDED_HOST']) && !empty($_SERVER['HTTP_X_FORWARDED_PREFIX_PROXY']) ? $_SERVER['HTTP_X_FORWARDED_HOST'].$_SERVER['HTTP_X_FORWARDED_PREFIX_PROXY'] : $_SERVER['HTTP_HOST'])
        ]);
    }

    public function HallOfFame() {
        if(!isset($_SESSION['FLAG_CURIUS'])) { $_SESSION['FLAG_CURIUS'] = []; }
        $_SESSION['FLAG_CURIUS']['hall-of-fame.html'] = true;

        return $this->render('security/hall-of-fame');
    }

    public function securityPolicy() {
        if(!isset($_SESSION['FLAG_CURIUS'])) { $_SESSION['FLAG_CURIUS'] = []; }
        $_SESSION['FLAG_CURIUS']['security-policy.html'] = true;
        return $this->render('security/security-policy');        
    }

    public function securityJob() {
        if(!isset($_SESSION['FLAG_CURIUS'])) { $_SESSION['FLAG_CURIUS'] = []; }
        $_SESSION['FLAG_CURIUS']['security-jobs.html'] = true;
        return $this->render('security/security-jobs'); 
    }
}