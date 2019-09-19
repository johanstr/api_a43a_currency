<?php

@include_once('db.php');

$status_messages = [
    200 => 'Ok',
    201 => 'Created',
    202 => 'Accepted',
    400 => 'Bad request',
    401 => 'Unauthorized',
    402 => 'Payment required',
    403 => 'Forbidden',
    404 => 'Not found',
    500 => 'Internal Server Error',
    501 => 'Not implemented',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable'
];

$content_types = [
    'json' => 'application/json',
    'xml' => 'application/xml',
    'zip' => 'application/zip',
    'html' => 'text/html',
    'pdf' => 'application/pdf',
    'css' => 'text/css',
    'csv' => 'text/csv',
    'txt' => 'text/plain',
    'png' => 'image/png',
    'jpg' => 'image/jpeg',
    'gif' => 'image/gif'
];

function responseHeader($code, $content_type = 'json')
{
    global $status_messages, $content_types;

    header("HTTP/1.1 $code {$status_messages[$code]}");
    header("Content-Type: {$content_types[$content_type]}");
}

function errorResponse($msg, $code)
{
    responseHeader($code, 'json');

    echo json_encode([
        'status' => $code,
        'error_message' => $msg
    ]);

    exit(0);
}

function sendResponse($data)
{
    responseHeader(200, 'json');

    echo json_encode($data);
    exit(0);
}

function getValueOfCurrency($cur)
{
    $currency = strtoupper($cur);

    if (dbConnect()) {
        $sql = "SELECT * FROM currency WHERE abbr = :abbr";
        $params = [':abbr' => $currency];
        dbQuery($sql, $params);

        // @TODO: Error response voor het geval de valuta code niet gevonden is

        return dbGet();
    }

    errorResponse('Connection to database impossible', 500);
}

function getCalculatedValueInEuros($cur, $amount)
{
    $sql = "SELECT * FROM currency WHERE abbr = :abbr";
    $params = [':abbr' => strtoupper($cur)];

    if (dbConnect()) {
        dbQuery($sql, $params);
        $currency = dbGet();

        $response_data = [
            'abbr' => strtoupper($cur),
            'amount' => $amount,
            'value' => $currency['value'],
            'euro_value' => sprintf("%6.2f", round($amount * $currency['value'], 2))
            // 'euro_value' => round($amount * $currency['value'], 2)
        ];

        return $response_data;
    }

    errorResponse('Cannot connect to the database', 500);
}

function getCalculatedValue($cur, $amount, $tocur)
{ 
    
}
