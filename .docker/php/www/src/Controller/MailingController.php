<?php
 
namespace App\Controller;

use Yoop\AbstractController;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\ControlLevel;

class MailingController extends AbstractController
{
   
    public function print() 
    {
        $vars = (new ControlLevel)->getResult();
        if($vars['mailing'] !== true) {
            $this->redirectToRoute('/');
        }

        return $this->render('web/mailing',[
            'app' => $vars
        ]);
    }

    public function send() 
    {
        $vars = (new ControlLevel)->getResult();
        if($vars['mailing'] !== true) {
            $this->redirectToRoute('/');
        }
        if(sizeof($_POST) && !empty($_POST['from']) && !empty($_POST['for']) && 
            !empty($_POST['subject']) && !empty($_POST['message'])) {
            // Controle des champs
            if(is_string($_POST['from']) && filter_var($_POST['from'], FILTER_VALIDATE_EMAIL)
                && is_string($_POST['from']) && filter_var($_POST['from'], FILTER_VALIDATE_EMAIL)
                && is_string($_POST['subject']) && is_string($_POST['message'])
            ) {
                if($_POST['for'] == 'contact@aliboron.net') {
                    if(isset($vars["flags"]) && is_array($vars["flags"])) {
                        $mailEthicValid = true;
                        foreach($vars["flags"] as $key => $value) {
                            // On se moque du BONUS_CURIEUX et BONUS_JOB
                            if($key !== "BONUS_CURIEUX" && $key !== "BONUS_JOB") {
                                // Controle que tout les flags ont été envoyé
                                if(stripos($_POST['message'], $value) === false) {
                                    $mailEthicValid = false;
                                }
                            }                
                        }
                        // si on a recu tout les flags
                        if($mailEthicValid) {
                            $success = "Bravo, voici le Flag final : ".$this->getFlag("FLAG_FINAL");
                            $_SESSION['FLAG_FINAL'] = true;
                        } else {
                            $success = "Merci pour votre retour, mais il manque des infos non ?";
                        }
                    } 
                }
                elseif($_POST['for'] == 'jobs@aliboron.net') {
                    $mailJobValid = false;
                    $keywords = [
                        'dresseur','licorne','explorateur','galaxie', 'câlins','calins', 'panda', 'architecte',
                        'châteaux', 'chateau', 'sable', 'chocolatier', 'cosmique'
                    ];
                    foreach($keywords as $value) {                    
                        // Controle que tout les flags ont été envoyé
                        if(stripos($_POST['subject'].$_POST['message'], $value) === false) {
                            $mailJobValid = true;
                        }
                    }
                    if($mailJobValid) {
                        $success = "Vous êtes un vrai petit farceur, vous savez très bien qu'on ne peut pas vous offrir cet emploi, mais voici un nouveau Flag !";
                        $success .= $this->getFlag("FLAG_JOB");
                        $_SESSION['FLAG_JOB'] = true;
                    } else {
                        $success = "Désolé nous n'avons aucune offre d'emploi correspondant !";
                    }
                }
                else {
                    $success = "On a fait au mieux pour envoyer votre message, mais c'est sans garantie";
                }
            } 
            else {
                $error = "Des données sont incorrectes, merci de corriger";
            }
        } else {
            $error = "Formulaire incomplet, tout les champs sont obligatoires";
        }
        
        return $this->render('web/mailing',[            
            'app'       => (new ControlLevel)->getResult(),
            'error'     => $error,
            'success'   => $success
        ]);
    }
}