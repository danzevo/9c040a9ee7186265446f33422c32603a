<?php

function response($status = true, $code = 200, $data = null, $message=null) {
    $items = [
        'status' => $status,
        'code' => $code,
        'data' => $data,
        'message' => $message,
    ];

    header('Content-type:application/json');
    echo json_encode($items);
}