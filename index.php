<?php

include "./test.php";
include "./math.php";

// $test = new Test;


// print_r($test->assertEquals("add", [10, 20], 30, "int"));
// print_r($test->assertEquals("subtract", [10, 20], -10));
// print_r($test->assertEquals("multiply", [10, 20], 200));
// print_r($test->assertEquals("divide", [10, 20], 5));


$data = [
    "/uasin-gishu" => [
        "moi",
        "uoe",
    ],
    "/nakuru" => [
        "egerton",
    ],
    "/nairobi" => [
        "ku",
    ]
];

echo json_encode($data[$_SERVER['REQUEST_URI']]);