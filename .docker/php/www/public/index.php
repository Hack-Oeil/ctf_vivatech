<?php
// configuration
if(!file_exists(dirname(__DIR__)."/shared/.env"))  { header("location:/b1897811c0c207.php"); exit(); } 

// On securise le cookie de session (PHPSESSID)
session_set_cookie_params(60*60, null, null, false, true);

require '../vendor/autoload.php';

$kernel = new Yoop\Kernel();

$csp = $kernel->contentSecurityPolicy();
if ($csp !== null) {
    $csp->addStyleSrc(["'unsafe-inline'", "'sha256-Jc7XaRBVYMy6h6FvjL32miHrOGOxYV+OP4swZ/9Gysw='", "https://fonts.googleapis.com", "https://use.fontawesome.com"]);
    $csp->addFontSrc(["https://fonts.gstatic.com", "https://use.fontawesome.com"]);
    $csp->addScriptSrc(["https://use.fontawesome.com", "https://cdn.jsdelivr.net", "https://code.jquery.com", "https://stackpath.bootstrapcdn.com"]);
    $csp->addConnectSrc(["https://cdn.jsdelivr.net"]);
}

(new Yoop\Database\Wait)->tryMySQL();

$router = $kernel->getRouter();
$router->load('/app/routes.php');
$router->run($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
