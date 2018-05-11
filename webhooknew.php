<?php

    $method = $_SERVER['REQUEST_METHOD'];

    if($method == 'POST'){
        $requestBody = file_get_contents('php://input');
        $json = json_decode($requestBody);

        $text = $json->result->metadata->intentName;

        switch ($text) {
            case 'Webhook test':
                $speech = "This question is too personal";
                break;    
            default:
                $speech = "Sorry, I didnt get that.";
                break;
        }

        $response = new \stdClass();
        $response->speech = $speech;
        $response->displayText = $speech;
        $response->source = "webhook";
        echo json_encode($response);
    }
    else
    {
        echo "Method not allowed";
    }

?>