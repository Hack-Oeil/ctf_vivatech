<?php

http_response_code(405);
header('Content-Type: application/json');
echo json_encode(["error" => "Method Not Allowed", "message" => "405 Method Not Allowed - Méthode non autorisée"]);