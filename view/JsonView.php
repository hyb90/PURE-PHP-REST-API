<?php
class JsonView
{
    public static function render($data,$code)
    {
        http_response_code($code);
        die(json_encode(['result'=>$data]));
    }
}