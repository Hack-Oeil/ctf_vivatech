<?php
 
namespace App\Controller;

use Yoop\AbstractController;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\ControlLevel;

class AdminController extends AbstractController
{
    private $jwt = 'eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiQWxpYm9yb24ifQ._qpW2Cw_fUnzTdqaMWLZlU1CNZKLBtHrCeGxL6alisBRmV98oO5MUIrApY3S4qqT-ar3oYC75UVQD3Gc78S2Wg';
        
    public function print() 
    {
        if(!isset($_COOKIE['jwt']) || $_COOKIE['jwt'] !== $this->jwt || !isset($_SESSION['game_started'])) {
            $this->redirectToRoute('/');
        }

        if($this->getUser() && $this->getUser()->getAdmin()) {
            return $this->render('web/dashboard',[
                'app'               => (new ControlLevel)->getResult(),
                'server_web'        => $_ENV['SERVER_WEB'] ?? '172.30.10.100',
                'server_sql'        => $_ENV['SERVER_SQL'] ?? '172.30.10.101',
                'server_domotique'  => $_ENV['SERVER_DOMOTIQUE'] ?? '172.30.10.102',
            ]);
        } else {
            return $this->render('web/admin',[
                'app' => (new ControlLevel)->getResult()
            ]);
        }
    }


    public function post() 
    {
        if(!isset($_COOKIE['jwt']) || $_COOKIE['jwt'] !== $this->jwt || !isset($_SESSION['game_started'])) {
            $this->redirectToRoute('/');
        }

        // todo control champs obligatoires
        if(!empty($_POST["username"]) && !empty($_POST["password"])) {
            $repo = new UserRepository();
            //$user = $repo->query('SELECT * FROM user WHERE username="'.$_POST["username"].'" AND password="'.SHA1($_POST["password"]).'"');
            $user = $repo->query("SELECT * FROM user WHERE username='".$_POST["username"]."' AND password='".SHA1($_POST["password"])."'");
            if ($user) {
                if($user->getAdmin()) {
                    $this->flash()->set("Vous êtes maintenant connecté");
                    $this->connectUser($user);
                    $this->redirectToRoute('/admin');
                } else {
                    $error = "Ce compte n'a pas les droits de connexion à l'administration";
                }
            } else {
                $error = "Erreur d'identification";
            }
        } else {
            $error = "Erreur d'identification";
        }
        return $this->render('web/admin',[
            'app' => (new ControlLevel)->getResult(),
            'error' => $error
        ]);

    }
}
