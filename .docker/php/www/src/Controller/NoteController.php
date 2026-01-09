<?php
 
namespace App\Controller;

use App\Entity\Note;

use Yoop\AbstractController;
use App\Service\ControlLevel;
use App\Repository\NoteRepository;


class NoteController extends AbstractController
{
    private $jwt = 'eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiYWRtaW5BbGlib3JvblNlY3JldCJ9._qpW2Cw_fUnzTdqaMWLZlU1CNZKLBtHrCeGxL6alisBRmV98oO5MUIrApY3S4qqT-ar3oYC75UVQD3Gc78S2Wg';
        
    public function print() 
    {
        if(!isset($_COOKIE['jwt']) || $_COOKIE['jwt'] !== $this->jwt) {
            return $this->render('errors/forbidden', ['idPage' => 'forbidden']);
        } else {
            
            // vérifier si jwt est egale à: 
            $repo = new NoteRepository();
            // effectuer cette requete uniquement si c'est le BOT !
            //file_put_contents(__DIR__.'/test.txt', $_SERVER["REMOTE_ADDR"], FILE_APPEND);
            if($_SERVER["REMOTE_ADDR"] === $_ENV['BOT_IP']) {
                
                $notes = [$repo->query('SELECT * FROM `note` WHERE `read`=0')];
                if(isset($notes[0]) && !empty($notes[0]->getMessage())) {
                    $pdo = $repo->getPDO();
                    // On protége après la lecture du BOT
                    $query = $pdo->prepare('UPDATE `note` SET `message`=?, `read`=?  WHERE `read`=0');
                    try {
                        $pdo->beginTransaction();                
                        $query->execute(['Note traitée : <s>'.htmlspecialchars($notes[0]->getMessage()).'</s>', true]);
                        $pdo->commit();
                    } catch (Exception $e){
                        $this->flash()->set("L'enregistrement de la note a échoué", 'note_error');
                        $pdo->rollback();
                        throw $e;
                    }
                }
            } else {
                $notes = $repo->query('SELECT * FROM `note` ORDER BY `id`');
            }

            return $this->render('web/note', [
                'notes' => $notes,
                'app' => (new ControlLevel)->getResult()
            ]);
        }
    }

    public function post() 
    {        
        if(sizeof($_POST) && !empty($_POST['message']) && is_string($_POST['message'])) {
            $repo = new NoteRepository();
            $pdo = $repo->getPDO();
            $query = $pdo->prepare('INSERT INTO `note` (`message`) VALUES(?)');
            try {
                $pdo->beginTransaction();                
                $query->execute([$_POST['message']]);
                $pdo->commit();
                // appel du Bot simulant l'admin
                $this->callBot();
                if($_SERVER['HTTP_USER_AGENT'] === 'EthicalTester/1.0') {
                    $_SESSION['save_state_ethical_xss'] = true;
                } else {
                    $_SESSION['save_state_ethical_xss'] = false;
                }
                $this->flash()->set('La note a été enregistrée', 'note_success');
            } catch (Exception $e) {
                $this->flash()->set("L'enregistrement de la note a échoué", 'note_error');
                $pdo->rollback();
                throw $e;
            }
        }
        
        $this->redirectToRoute('/#note');
    }

    private function callBot() {
        $client = new \WebSocket\Client("ws://botserver:8282");
        $client->text(json_encode([
            "host" => 'http://web_apache',
            "actions" => [
                [
                    "url" => 'http://web_apache/jwt_bot_787fc35b8797e9c47e654afe'
                ],
                [ "sleep" => 1000 ],
                [
                    "url" => 'http://web_apache/note'
                ],
                [ "sleep" => 2000 ]
            ],
        ]));
    }


    /**
     * création du JWT pour le bot
     */  
    public function jwt() 
    {
        // Seul le bot pourra se connecter de cette façon
        if($_SERVER["REMOTE_ADDR"] === $_ENV['BOT_IP']) {
            setCookie('jwt', $this->jwt, time()+60*60*24);
        }
    }
}
