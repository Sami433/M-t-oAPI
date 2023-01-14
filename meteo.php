<?php

// On vérifie si la requête est une requête GET et si la variable "city" est définie
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["city"])) {
    // On utilise un service de météo externe pour obtenir les données
    $weather_data = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=" . $_GET["city"] . "&APPID=e296ef7b323ab71f27831cad382d25e1&units=metric");

    // On decode les données JSON reçues
    $weather_data = json_decode($weather_data);

    // On retourne les données sous forme de JSON
    header("Content-type: application/json");
    echo json_encode($weather_data);
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>Météo</title>
  <link rel="icon" type="image/png" href="assets/icons/neige.png"/>
  <link rel="stylesheet" href="meteo.css">
  <style type="text/css">

@font-face{

  font-family:"SnowtopCaps";
  src: url('SnowtopCaps.otf');


} 

  </style> 
</head>
<body>
<img src="assets/icons/neige.png" alt="logo">
  <h1>Météo</h1>
  <form method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>" id="weather-form">
      <input type="text" id="city" placeholder="Entrez une ville" id="searchInput"><br>
      <input type="submit" value="Envoi">
    </form>
<div id="weather-data" style="display: none;"></div>
<div class="center-table">
<table id="weather-table" style="display: none;">
    <tr>
        <th>Pays</th>
        <th>Température</th>
        <th>Humidité</th>
        <th>Pression atmosphérique</th>
        <th>Température max</th>
        <th>Température min</th>
    </tr>
    <tr>
        <td id="country"></td>
        <td id="temperature"></td>
        <td id="humidity"></td>
        <td id="pressure"></td>
        <td id="temp_max"></td>
        <td id="temp_min"></td>


</table>
</div>
<script>
    let weatherForm = document.getElementById("weather-form");
    weatherForm.addEventListener("submit", function(event) {
        event.preventDefault();
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "<?php echo $_SERVER['PHP_SELF'];
?>?city=" + document.getElementById("city").value, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                let data = JSON.parse(xhr.responseText);
                let weatherTable = document.getElementById("weather-table");
                weatherTable.style.display = "block"; // On affiche le tableau
                document.getElementById("city").innerHTML = data.name;
                document.getElementById("country").innerHTML = data.sys.country;
                document.getElementById("temperature").innerHTML = data.main.temp + "°C";
                document.getElementById("humidity").innerHTML = data.main.humidity + "%";
                document.getElementById("pressure").innerHTML = data.main.pressure + "hPa";
                document.getElementById("temp_max").innerHTML = data.main.temp_max + "°C";
                document.getElementById("temp_min").innerHTML = data.main.temp_min + "°C";
            }
        };
        xhr.send();
    });
</script>
</body>
</html> 