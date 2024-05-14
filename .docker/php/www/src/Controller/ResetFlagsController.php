<?php
 
namespace App\Controller;

use Yoop\AbstractController;
use App\Service\ControlLevel;

class ResetFlagsController extends AbstractController
{
    public function init() 
    {
       session_destroy();
       session_start();
       setCookie('jwt', $this->jwt, time()-1); // on supprime aussi le cookie
       // on delete tout ce qui peut être enregistré pour l'utilisateur
       session_regenerate_id(true);
       
       $this->redirectToRoute('/');
    }

    public function changeCurrentCtf() {
        $control = (new ControlLevel)->getResult();
        $wantLevel = (int) $_GET['level']??0;
      
        if($control['level'] >= $wantLevel) {
            for($i = $control['level']; $i >= $wantLevel; $i--) {                
                if(isset($_SESSION["level-".$i])) {

                    // On supprime le jwt                    
                    if($i <= 2) setCookie('jwt', $this->jwt, time()-1);
                    if($i <= 3) unset($_SESSION["user"]);
                   
                    $_SESSION["level-".$i];
                    unset($_SESSION["level-".$i]);

                    // Si le mode expert avait été validé
                    if($_SESSION['EXPERT_LEVEL'][$level]) {
                        unset($_SESSION['EXPERT_LEVEL'][$level]);
                        $_SESSION['EXPERT']--;
                    }
                } elseif($i == 0) {
                    unset($_SESSION['game_started']);
                } 
            }
        }
        $this->redirectToRoute('/');
    }
}
