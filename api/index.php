<?php

@include_once('functions.php');

$response_data = [];

if(!isset($_GET['cmd'])) {
    // @TODO: Fout afhandeling
}

switch(strtolower($_GET['cmd'])) {
    case 'value':
        if(isset($_GET['cur']))
            $response_data = getCurrencyValue($_GET['cur']);
        else
            errorResponse('Second parameter for this call not given.');
        break;
    
    case 'calc':
        if(isset($_GET['cur']) && isset($_GET['amount']))
            $response_data = calcValueOfCurrency($_GET['cur'], $_GET['amount']);
        else
            errorResponse('Second and/or third parameter for this call not given.');

    case 'calcval':
        if(isset($_GET['cur']) && isset($_GET['amount']) && isset($_GET['tocur']))
            $response_data = calcValueToCurrency($_GET['cur'], $_GET['amount'], $_GET['tocur']);
        else
            errorResponse('Missing parameters');
}

sendResponse($response_data);
