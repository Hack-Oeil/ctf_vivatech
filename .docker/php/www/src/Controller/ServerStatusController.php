<?php
 
namespace App\Controller;

use Yoop\AbstractController;
use App\Service\ControlLevel;

class ServerStatusController extends AbstractController
{
    private $jwt = 'eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiQWxpYm9yb24ifQ._qpW2Cw_fUnzTdqaMWLZlU1CNZKLBtHrCeGxL6alisBRmV98oO5MUIrApY3S4qqT-ar3oYC75UVQD3Gc78S2Wg';
        
    public function ping() 
    {
        if(!isset($_COOKIE['jwt']) || $_COOKIE['jwt'] !== $this->jwt || !isset($_SESSION['game_started'])) {
            $this->redirectToRoute('/');
        }
        if(!isset($_GET['verbose']) || $_GET['verbose'] === "false") {
            header("Content-Type: image/png");
            if(isset($_GET['server'])) {      
                // besoin d'un seul appel pour voir si serveur OK
                exec('ping -c 1 '.$_GET['server'], $output, $return_value);
                // Vérifie si le ping a réussi
                if ($return_value === 0) {
                    echo file_get_contents(dirname(__DIR__).'/Resources/server_on.png');
                    exit();
                } 
            } 
            echo file_get_contents(dirname(__DIR__).'/Resources/server_off.png');    
            exit();    
        } else {
            header("Content-Type: text/plain");
            if(isset($_GET['server'])) {
                exec('ping -c 4 '.$_GET['server'], $output, $return_value);
            } else {
                $output = ['ping: usage error: Destination address required'];
            }
            
            $result = [];
            foreach($output as $line) {
                $cheat = $this->antiCheat($line);
                if($cheat) break;

                if(strpos($line, 'Page: home, User-Agent: EthicalTester/1.0')) { $_SESSION['HOME_API_ETHIQUE'] = true;  }
                if(strpos($line, 'Page: docs, User-Agent: EthicalTester/1.0')) { $_SESSION['DOC_API_ETHIQUE'] = true;  }
                // si on reçoit la cle API c'est qu'on est dans la documentation
                if(strpos($line, $_ENV['API_KEY_DOMOTIQUE'])) {
                    $_SESSION['FLAG_DOC_API'] = true;
                } 
                elseif(strpos($line, "success")!==false && strpos($line, "lights")!==false 
                    && strpos($line, "state")!==false  && strpos($line, "on")!==false && strpos($line, "true")!==false) 
                {
                    if(strpos($line, 'EthicalTester')!==false) { $_SESSION['LIGHT_ON_API_ETHIQUE'] = true;  }
                    $_SESSION['LIGHT_ON_API'] = true;
                }
                array_push($result, $line);
            }

            if($cheat === false) {
                echo join("\n", $result);
            } else {
                echo "<strong>Anti-triche :<strong><br />
                    L'objectif de ce challenge est d'exploiter l'API domotique.<br /><br />
                    Les commandes permettant de lister / lire le serveur local ont été désactivées 
                    afin d'éviter toute tentative de triche.<br /><br />
                    Il est inutile de continuer à explorer ce serveur : concentrez vos efforts sur 
                    l'exploitation d'une SSRF pour communiquer avec l'API du serveur domotique.";
            }            
            exit();
        }
    }


    public function antiCheat($line) {
        $keywords = [
            // 
            'anticheat.txt', 'Yoop', 'layout.html.twig'
        ];
        foreach($keywords as $keyword) {
            if(strpos($line, $keyword) !== false) return true;
        }
        

        return false;
    }
    
}
