<?php
 
namespace App\Service;

class ControlLevel 
{
    public function getResult() {
        $helper = new HelperController();
        $level = 0;
        $bonus = 0;
        $flags = [];

        // Vérification Level 0 : formulaire
        if((new Level0)->verify()) {
            $flags["Formulaire"] = $helper->flag("FLAG_LEVEL_0");
        }
        // Vérification Level 1 : spoofing d'IP
        if((new Level1)->verify()) {
            $flags["IP Spoofing"] = $helper->flag("FLAG_LEVEL_1");
            $level++;
        }
        // Vérification Level 2 : Injection XSS + Vol de session
        if((new Level2)->verify()) {
            $flags["XSS Stored"] = $helper->flag("FLAG_LEVEL_2");
            $level++;
        }
        // Vérification Level 3 : injection SQL
        if((new Level3)->verify()) {
            $flags["Injection SQL"] = $helper->flag("FLAG_LEVEL_3");
            $level++;
        }
        // Vérification Level 4 : récupération de documentation api
        if((new Level4)->verify()) {
            $flags["API KEY Domotique"] = $helper->flag("FLAG_LEVEL_4");
            $level++;
        }
        // Vérification Level 5 : récupération d'une clé API
        if((new Level5)->verify()) {
            $flags["Injection SSRF"] = $helper->flag("FLAG_LEVEL_5");
            $level++;
        }


        //--------------------------------------------------------------------
        //          LES FLAGS BONUS
        //--------------------------------------------------------------------
        // Vérification Bonus robots.txt
        if((new LevelBonusWhiteHat)->verify()) {
            $bonus++;
            $flags["BONUS_WHITE_HAT"] = $helper->flag("FLAG_BONUS_WHITE_HAT");
        }

         // Vérification Bonus robots.txt
         if((new LevelBonusCurius)->verify()) {
            $bonus++;
            $flags["BONUS_CURIEUX"] = $helper->flag("FLAG_BONUS_CURIEUX");
        }

        if((new LevelBonusJob)->verify()) {
            $bonus++;
            $flags["BONUS_JOB"] = $helper->flag("FLAG_BONUS_JOB");
        }
        
        //--------------------------------------------------------------------
        //          LE FLAG FINAL
        //--------------------------------------------------------------------
        // Vérification Level 6 : allumer la lumiere
        if((new Level6)->verify()) {
            $flags["Final"] = $helper->flag("FLAG_LEVEL_6");
            $bonus++; // On considére comme un Bonus
            $level++;
        }
        
        $type = 'warning';
        $enableMailing = false;
        // 1ere possibilité activation Web Mail (FLAG BONUS CURIEUX activé et pas le flag BONUS JOB)
        if(isset($flags["BONUS_CURIEUX"]) && !isset($flags["BONUS_JOB"])) {
            $enableMailing = true;
        }


        // Permet de gérer le debug sur le mode expert (pour ne pas dépasser)
        if($_SESSION['EXPERT'] > (sizeof($flags)-$bonus)) { $_SESSION['EXPERT'] = (sizeof($flags)-$bonus); }
        if(isset($flags["BONUS_WHITE_HAT"]) && $_SESSION['EXPERT'] === (sizeof($flags)-$bonus)) {
            $type = 'success';
            if($_SESSION['EXPERT'] == 6) {
                $enableMailing = true;
            }            
        } elseif(isset($flags["BONUS_WHITE_HAT"])) {
            $type = 'info';
        }
        
        $messageExpert = "";
        if($_SESSION['EXPERT'] !== 6 && (sizeof($flags)-$bonus) === 6) {
            $messageExpert = "Vous ne pouvez pas obtenir le flag final, car vous n'avez pas respecté les engagements d'un véritable hacker éthique.";
        }

        return [
            'flags'             => $flags,
            'level'             => $level,
            'bonus'             => $bonus,
            'type'              => $type,
            'mailing'           => $enableMailing,
            'message_expert'    => $messageExpert
        ];
    }
}