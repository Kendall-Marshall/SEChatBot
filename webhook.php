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

            if($update["result"]["action"] == "DBLink" ){

                $paper = $update["result"]["parameters"]["paperName1"];
                if(empty($paper)){
                    $paper = $update["result"]["parameters"]["paperName2"];
                    if(empty($paper)){
                        $paper = $update["result"]["parameters"]["paperName3"];
                    }
                }
                
                $query = "SELECT * FROM papers WHERE paperName LIKE '%$paper%'";
                $result = $db->query($query);

                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    
                    $pCode = $row["papercode"];
                    $pName = $row["papername"];
                    $pPre = $row["prereq"];
                    
                }
                $result->closeCursor();
                if($pPre == "NONE" || $pPre == " NONE"){
                    sendMessage(array(
                        "source" => $update["result"]["source"],
                        "speech" => $pName . " (" . $pCode .") Has no Pre-Requisite's",
                        "displayText" => $pName . " (" . $pCode .") Has no Pre-Requisite's",
                        "contextOut" => array()
                    ));
                }else{
                    sendMessage(array(
                        "source" => $update["result"]["source"],
                        "speech" => "The Pre-Requisite's for " . $pName . " (" . $pCode .") are: ". $pPre,
                        "displayText" => "The Pre-Requisite's for " . $pName . " (" . $pCode .") are: ". $pPre,
                        "contextOut" => array()
                    ));
                }
                
            }

            if($update["result"]["action"] == "DBtest" ){

                $paper = $update["result"]["parameters"]["paperName1"];
                if(empty($paper)){
                    $paper = $update["result"]["parameters"]["paperName2"];
                    if(empty($paper)){
                        $paper = $update["result"]["parameters"]["paperName3"];
                    }
                }
                
                $query = "SELECT * FROM papers WHERE prereq LIKE '%$paper%'";
                $result = $db->query($query);
                if(pg_num_rows($result) === 0){
                    sendMessage(array(
                        "source" => $update["result"]["source"],
                        "speech" => $paper . " is not a requirement for any papers.",
                        "displayText" => $paper . " is not a requirement for any papers.",
                        "contextOut" => array()
                    ));
                }
                else{
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    
                        $pCode = $row["papercode"];
                        $pName = $row["papername"];
                        $pPre = $row["prereq"];
                        
                    }
                    $result->closeCursor();
                    
                        sendMessage(array(
                            "source" => $update["result"]["source"],
                            "speech" => $paper . " is a Requirement for: " . $pName,
                            "displayText" => $paper . " is a Requirement for: " . $pName,
                            "contextOut" => array()
                        ));
                    
                }  
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