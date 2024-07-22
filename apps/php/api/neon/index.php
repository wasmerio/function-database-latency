<?php

$DB_HOST = $_ENV["NEON_DB_HOST"];
$DB_USER = $_ENV["NEON_DB_USER"];
$DB_PASS = $_ENV["NEON_DB_PASS"];
$DB_NAME = $_ENV["NEON_DB_NAME"];
$DB_PORT = NULL;

header('Access-Control-Allow-Origin: *');
header('Content-Type: text/json');


$start = floor(microtime(true) * 1000);

$conn_string = "host=$DB_HOST dbname=$DB_NAME user=$DB_USER password=$DB_PASS sslmode=require";
$dbconn = pg_connect($conn_string);

if (!$dbconn) {
    echo json_encode(["error" => "Connection failed"]);
    exit();
}

$count = isset($_GET["count"]) ? $_GET["count"] : 1;
for ($i = 0; $i < $count; $i++) {
    $query = "SELECT emp_no, first_name, last_name FROM employees LIMIT 10";

    $result = pg_query($dbconn, $query);
    $data = [];
    while ($row = pg_fetch_assoc($result)) {
        $data[] = $row;
    }
}


$end = floor(microtime(true) * 1000);

$response =  [
    "data" => $data,
    "queryDuration" => $end -  $start,
    "invocationIsCold" => false,
    "invocationRegion" => null
];

echo json_encode($response, JSON_PRETTY_PRINT);
