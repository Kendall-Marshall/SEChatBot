<?php
    //echo "hello";
    function processMessage($update) {
            //$pre = setupDB($paper);
            if($update["result"]["action"] == "sayHello" ){
                $paper = $update["result"]["parameters"]["paperName1"];
                
                
                sendMessage(array(
                    "source" => $update["result"]["source"],
                    "speech" => "Hello from webhook " . $paper,
                    "displayText" => "Hello from webhook "  . $paper,
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