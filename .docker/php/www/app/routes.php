<?php

return function(\FastRoute\RouteCollector $router) {
    // Page pour reinitialiser la "partie"
    $router->get('/reset', 'App\Controller\ResetFlagsController::init');
    $router->get('/change_level', 'App\Controller\ResetFlagsController::changeCurrentCtf');

    // Bonus
    $router->get('/.well-known/security.txt', 'App\Controller\BonusController::whiteHat');
    $router->get('/hall-of-fame.html', 'App\Controller\BonusController::HallOfFame');
    $router->get('/security-policy.html', 'App\Controller\BonusController::securityPolicy');
    $router->get('/security-jobs.html', 'App\Controller\BonusController::securityJob');

    // Mailing    
    $router->get('/web-mailing', 'App\Controller\MailingController::print');
    $router->post('/web-mailing', 'App\Controller\MailingController::send');

    // Page d'accueil
    $router->get('/', 'App\Controller\HomeController::print');
    $router->post('/', 'App\Controller\HomeController::startGame');
 
    // Ajout d'une note
    $router->get('/note', 'App\Controller\NoteController::print');
    $router->post('/note', 'App\Controller\NoteController::post');
    $router->get('/jwt_bot_787fc35b8797e9c47e654afe', 'App\Controller\NoteController::jwt');

    // coté admin
    $router->get('/admin', 'App\Controller\AdminController::print');
    $router->post('/admin', 'App\Controller\AdminController::post');

    $router->get('/server_status', 'App\Controller\ServerStatusController::ping');
    
};
