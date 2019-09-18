<?php
$dbhost = '127.0.0.1';
$dbname = 'currency';
$dbuser = 'root';
$dbpassw = 'root';

$db_connection = null;
$db_statement = null;

function dbConnect()
{
    global $dbhost, $dbname, $dbuser, $dbpassw, $db_connection;

    try {
        $db_connection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassw);

    } catch(PDOException $e) {
        return false;
    }

    return true;
}

function dbQuery($sql, $params = [])
{
    global $db_connection, $db_statement;

    $db_statement = $db_connection->prepare($sql);
    $db_statement->execute($params);
}

function dbGetAll()
{
    global $db_statement;

    return $db_statement->fetchAll(PDO::FETCH_ASSOC);
}

function dbGet()
{
    global $db_statement;

    return $db_statement->fetch(PDO::FETCH_ASSOC);
}