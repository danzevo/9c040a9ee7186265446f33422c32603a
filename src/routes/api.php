<?php

require_once "../app/SendEmailController.php";

$sendEmail = new SendEmailController();
$request_method = $_SERVER['REQUEST_METHOD'];

switch($request_method) {
    case "GET":
        if(!empty($_GET['id'])) {
            $id = intval($_GET['id']);
            $sendEmail->show($id);
        } else {
            $sendEmail->index();
        }
        break;
    case "POST":
        if(!empty($_GET['id'])) {
            $id = intval($_GET['id']);
            $sendEmail->update($id);
        } else {
            $sendEmail->store();
        }
        break;
    case "DELETE":
        $id = intval($_GET['id']);
        $sendEmail->destroy($id);
        break;
    default: 
        //invalid request method
        header("HTTP/1.0 405 Method not allowed");
        break;
    break;
}