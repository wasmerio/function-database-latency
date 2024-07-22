<?php

$DB_HOST = $_ENV["TIDB_DB_HOST"];
$DB_USER = $_ENV["TIDB_DB_USER"];
$DB_PASS = $_ENV["TIDB_DB_PASS"];
$DB_NAME = $_ENV["TIDB_DB_NAME"];
$DB_PORT = $_ENV["TIDB_DB_PORT"];

header('Access-Control-Allow-Origin: *');
header('Content-Type: text/json');


$start = floor(microtime(true) * 1000);

$mysqli = new mysqli();

if (!$mysqli->real_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT, NULL, MYSQLI_CLIENT_SSL)) {
    echo json_encode(["error" => "Connection failed"]);
    exit();
}

$count = isset($_GET["count"]) ? $_GET["count"] : 1;
for ($i = 0; $i < $count; $i++) {
    $query = "SELECT emp_no, first_name, last_name FROM employees LIMIT 10";

    $result = $mysqli->query($query);
    $data = [];
    while ($row =  $result->fetch_assoc()) {
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
