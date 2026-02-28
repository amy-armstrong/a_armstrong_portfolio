<?php

function getConfig()
{
    return [
        'username' => 'root',
        'password' => '', // 'root'
        'host' => 'localhost',
        'database' => 'portfolio',
        'port' => '3306' // OSX: 8889
    ];
}

function getConnection()
{
    $config = getConfig();
    $username = $config['username'];
    $password = $config['password'];
    $host = $config['host'];
    $database = $config['database'];

    // $dsn = 'mysql:host=localhost;dbname=portfolio;';
    $dsn = 'mysql:host=' . $host . ';dbname=' . $database . ';';
    $connection = new PDO($dsn, $username, $password);

    return $connection;
}

// function query(string $query)
// {
//     $connection = getConnection();
// $statement = $connection->prepare('SELECT * FROM projects;');
// $statement->execute();
// }