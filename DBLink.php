<?php
    $dsn = "pgsql:"
    . "host=ec2-23-23-248-192.compute-1.amazonaws.com;"
    . "dbname=d7l6p49ppkecvu;"
    . "user=ggxtnsrwvguhht;"
    . "port=5432;"
    . "sslmode=require;"
    . "password=9553b589643fe647133277e9a8cf1bd74a6e2cac8ecbc377a0d92a53a3fcd6d7";

    $db = new PDO($dsn);
?>

<html>
 <head>
  <title>Employees</title>
 </head>
 <body>
  <table>
   <thead>
    <tr>
     <th>CODE</th>
     <th>NAem</th>
     <th>Pre</th>
    </tr>
   </thead>
   <tbody>
<?php
    $query = "SELECT * FROM papers";
    $result = $db->query($query);
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row["papercode"] . "</td>";
        echo "<td>" . $row["papername"] . "</td>";
        echo "<td>" . $row["prereq"] . "</td>";
        echo "</tr>";
    }
    $result->closeCursor();

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
   </tbody>
  </table>
 </body>
</html>