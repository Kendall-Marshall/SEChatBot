<?php
    function processMessage($update) { 
            $dsn = "pgsql:"
            . "host=ec2-23-23-248-192.compute-1.amazonaws.com;"
            . "dbname=d7l6p49ppkecvu;"
            . "user=ggxtnsrwvguhht;"
            . "port=5432;"
            . "sslmode=require;"
            . "password=9553b589643fe647133277e9a8cf1bd74a6e2cac8ecbc377a0d92a53a3fcd6d7";
        
            $db = new PDO($dsn);           
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