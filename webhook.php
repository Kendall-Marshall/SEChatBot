<?php
    function processMessage($update) {            
            if($update["result"]["action"] == "sayHello" ){
                $paper = $update["result"]["parameters"]["paperName1"];
                
                
                sendMessage(array(
                    "source" => $update["result"]["source"],
                    "speech" => "Hello from webhook HEroku" . $paper,
                    "displayText" => "Hello from webhook Heroku"  . $paper,
                    "contextOut" => array()
                ));
            }
        }
        
        function sendMessage($parameters) {
            echo json_encode($parameters);
        }
        
        $update_response = file_get_contents("php://input");
        $update = json_decode($update_response, true);
        if (isset($update["result"]["action"])) {
            processMessage($update);
        }
?>