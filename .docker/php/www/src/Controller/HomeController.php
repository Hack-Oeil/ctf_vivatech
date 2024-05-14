<?php
 
namespace App\Controller;

use App\Entity\User;

use App\Service\Level0;
use Yoop\AbstractController;
use App\Service\ControlLevel;

class HomeController extends AbstractController
{
    public function print() 
    {
        if(!isset($_SESSION['game_started'])) return $this->startGame();   

        return $this->render('web/home', [
            'app' => (new ControlLevel)->getResult()
        ]);
    }

    public function startGame() 
    {
        if(isset($_SESSION['game_started']) || (new Level0)->verify()) {
            $this->redirectToRoute('/');
        }
        return $this->render('web/start', [
            'app' => (new ControlLevel)->getResult()
        ]);
    }
}
