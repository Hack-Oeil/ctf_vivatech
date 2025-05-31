<?php

function light(string $url, string $method ='GET', bool $on = true)
{   
    $defaults = [
        CURLOPT_HEADER => 0,
        CURLOPT_URL => $url,
        CURLOPT_FRESH_CONNECT => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FORBID_REUSE => 1,
        CURLOPT_TIMEOUT => 4,
    ];

    if($method == 'PUT') {
        $defaults[CURLOPT_POST] = 1;
        $defaults[CURLOPT_CUSTOMREQUEST] = "PUT";
        $defaults[CURLOPT_POSTFIELDS] = '{"on": '.($on?'true':'false').'}';
    }

    $ch = curl_init();
    curl_setopt_array($ch,$defaults);
    if( ! $result = curl_exec($ch)) {
      
        trigger_error(curl_error($ch));
    }
    curl_close($ch);
  
    return $result;
}

$response = [];
if($_SERVER['HTTP_USER_AGENT'] === 'EthicalTester/1.0') {
    $response["ethique"] = 'EthicalTester/1.0';
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') { 
   http_response_code(200);
   header('Content-Type: application/json');
   $data = json_decode(light($_ENV['URL_API_HUE'].'/lights/'. $light), true);
   echo json_encode($data['state']);
   exit();
}
elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = file_get_contents('php://input');
    $on = false;    
    //if($light >=1 && $light <=4) {
        if ($data !== null && $data=='{on:true}' || $data =='{on:false}') {  
            // allumer / éteindre
            if($data=='{on:true}') $on = true;
            // si probleme avec Philips Hue on simule
            if($_ENV['WITH_BULBS'] != true || empty($_ENV['URL_API_HUE'])) {
                http_response_code(200);
                header('Content-Type: application/json');
                $response["success"] = ["/lights/$light/state" => ["on" => ($on?"true":"false")]];
                echo json_encode($response);
                exit();
            } else {
                // http://<IP_PONT>/api/<api_key>/
                if(!empty($_ENV['URL_API_HUE']) && !empty($light)) {
                    $data = json_decode(light($_ENV['URL_API_HUE']."/lights/$light/state", 'PUT', $on), true);
                    if(isset($data[0]['success'])) {
                        http_response_code(200);
                        header('Content-Type: application/json');            
                        $response["success"] = $data[0]['success'];
                    } else {
                        if(!isset($data[0]) || !isset($data[0]["error"])) {
                            http_response_code(500);
                            header('Content-Type: application/json');
                            $response["error"] = "Le serveur ne répond pas";
                        } else {
                            http_response_code(404);
                            header('Content-Type: application/json');
                            $response["error"] = $data[0]["error"];
                        }
                    }
                    echo json_encode($response);
                    exit();
                }            
            }
        }
    //}
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(["error" => "Bad Request", "message" => "400 Bad Request"]);
}

