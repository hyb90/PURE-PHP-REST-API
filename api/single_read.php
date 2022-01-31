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

    $item = new Todo($db);

    $item->id = isset($_GET['id']) ? $_GET['id'] : die();
  
    $item->getSingleTodo();

    if($item->title != null){
        // create array
        $arr = array(
            "id" =>  $item->id,
            "title" => $item->title,
            "description" => $item->description,
            "done" => $item->done,
            "createdAt" => $item->createdAt
        );
      
        $json->render($arr,200);
    }
      
    else{
        $json->render("Todo not found.",404);
    }
?>