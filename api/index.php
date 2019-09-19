<?php

@include_once('functions.php');



if (!isset($_GET['cmd'])) {
    errorResponse('You did not use this API the right way', 400);
}

$data = [];

switch (strtolower($_GET['cmd'])) {
    case 'value':
        if (isset($_GET['cur']))
            $data = getValueOfCurrency($_GET['cur']);
        break;

    case 'calc':
        if (isset($_GET['cur']) && isset($_GET['amount']))
            $data = getCalculatedValueInEuros($_GET['cur'], $_GET['amount']);
        break;

    case 'calcval':
        if (isset($_GET['cur']) && isset($_GET['amount']) && isset($_GET['tocur']))
            $data = getCalculatedValue($_GET['cur'], $_GET['amount'], $_GET['tocur']);
        break;

    default:
        errorResponse('Command unknown', 404);
}

sendResponse($data);
