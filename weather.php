<?php

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["city"])) {
    $weather_data = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=" . $_GET["city"] . "&APPID=e296ef7b323ab71f27831cad382d25e1&units=metric");
    $weather_data = json_decode($weather_data);
    header("Content-type: application/json");
    echo json_encode($weather_data);
    exit();
}
?>