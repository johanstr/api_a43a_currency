<?php
@include_once('db.php');

function errorResponse($error_msg)
{

}

function sendResponse($data)
{
    header('HTTP/1.1 200 Ok');
    header('Content_type: application/json');

    echo json_encode($data);
    exit(0);
}

function getCurrencyValue($currency_abbr)
{
    if(dbConnect()) {
        $sql = "SELECT * FROM currency WHERE abbr = :abbr";
        $params = [ ':abbr' => $currency_abbr ];

        dbQuery($sql, $params);
        return dbGet();
    }

    errorResponse('Connection to database failed');
}