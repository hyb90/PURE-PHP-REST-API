<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../config/database.php';
    include_once '../model/Todo.php';
    include_once '../view/JsonView.php';

    $database = new Database();
    $json= new JsonView();
    $db = $database->getConnection();

    $items = new Todo($db);

    $stmt = $items->getTodos();
    $itemCount = $stmt->rowCount();



    if($itemCount > 0){
        
        $Arr = array();
        $Arr["body"] = array();
        $Arr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "title" => $title,
                "description" => $description,
                "done" => $done,
                "createdAt" => $createdAt
            );

            array_push($Arr["body"], $e);
        }
        $json->render($Arr,200);
    }

    else{
        $json->render('no record found',404);
    }
?>