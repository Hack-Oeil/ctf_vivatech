<?php
try {
    if(strpos($_SERVER["REQUEST_URI"], '/api/') === 0) {
        $tab = explode("/", $_SERVER["REQUEST_URI"]);
        if($tab[2] === $_ENV['API_KEY_DOMOTIQUE']) {
            if($tab[3] == 'light') {
                if(sizeof($tab) == 5 && !empty($tab[4])) {
                    if($_SERVER['REQUEST_METHOD'] === 'PUT') {
                        $light = (int) $tab[4] ?? 0;
                        include __DIR__.'/api/light.php';
                    } elseif($_SERVER['REQUEST_METHOD'] === 'GET') { 
                        include __DIR__.'/api/light.php';
                    }
                    else {
                        include __DIR__.'/api/error_405.php';
                    }
                }
            }
            elseif(sizeof($tab) == 4 && $tab[3] == 'lights') {
                if($_SERVER['REQUEST_METHOD'] === 'GET') {
                    include __DIR__.'/api/lights.php';
                } else {
                    include __DIR__.'/api/error_405.php';
                }
            }
            else {
                include __DIR__.'/api/error_404.php';
            }
        }
    }
    elseif(strpos($_SERVER["REQUEST_URI"], '/docs') === 0) {
        include __DIR__.'/views/docs.phtml';
    }
    else {
        include __DIR__.'/views/home.phtml';
    }
} catch(Throwable $e) {
    http_response_code(500);
    header('Content-Type: application/json');
    $response["error"] ="Le serveur ne répond pas";
    echo json_encode($response);
    exit();
}