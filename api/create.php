<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../model/Todo.php';
    include_once '../view/JsonView.php';

    $database = new Database();
    $json= new JsonView();
    $db = $database->getConnection();

    $item = new Todo($db);

    $data = json_decode(file_get_contents("php://input"));

    if(empty($data->title)||empty($data->description)){$json->render('Please provide title and description',400);}
    $item->title = $data->title;
    $item->description = $data->description;
    $item->done = $data->done;
    $item->createdAt = date('Y-m-d H:i:s');
    
    if($item->createTodo()){
        $json->render('Todo created successfully.',200);
    } else{
        $json->render('Todo could not be created.',500);
    }
?>