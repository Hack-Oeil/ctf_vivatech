<?php

http_response_code(404);
header('Content-Type: application/json');
echo json_encode(["error" => "Not Found", "message" => "404 Not Found - Ressource non trouvée"]);