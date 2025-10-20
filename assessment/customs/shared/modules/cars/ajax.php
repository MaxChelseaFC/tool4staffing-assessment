<?php
$client = $_GET['client'] ?? ($_COOKIE['client_id'] ?? 'clienta');

$carsPath = __DIR__ . '/../../../../data/cars.json';
$garagesPath = __DIR__ . '/../../../../data/garages.json';

$carsData = json_decode(file_get_contents($carsPath), true);
$garagesData = json_decode(file_get_contents($garagesPath), true);

$cars = array_filter($carsData, fn($car) => $car['customer'] === $client);

$garagesById = [];
foreach ($garagesData as $g) {
    $garagesById[$g['id']] = $g['title'];
}

function formatYear($timestamp) {
    return date('Y', $timestamp);
}

echo "<h2>Liste des voitures pour <strong>$client</strong></h2>";
echo "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse:collapse;width:80%;'>";
echo "<thead><tr>";

switch ($client) {
    case 'clienta':
        echo "<th>Nom</th><th>Marque</th><th>Année</th><th>Puissance (ch)</th>";
        break;
    case 'clientb':
        echo "<th>Nom</th><th>Marque</th><th>Garage</th>";
        break;
    default:
        echo "<th>Nom</th><th>Marque</th><th>Couleur</th>";
        break;
}
echo "</tr></thead><tbody>";

foreach ($cars as $car) {
    $rowStyle = '';

    if ($client === 'clienta') {
        $carDate = new DateTime("@{$car['year']}");
        $today = new DateTime();
        $interval = $today->diff($carDate);
        $carAge = $interval->y;
    
        if ($carAge > 10) {
            $rowStyle = 'background-color:#FFCCCC;'; // rouge clair > 10 ans
        } elseif ($carAge < 2) {
            $rowStyle = 'background-color:#CCFFCC;'; // vert clair < 2 ans
        }
    }

    echo "<tr class='car-row' data-carid='{$car['id']}' style='{$rowStyle}'>";
    if ($client === 'clienta') {
        echo "<td>{$car['modelName']}</td>";
        echo "<td>{$car['brand']}</td>";
        echo "<td>" . formatYear($car['year']) . "</td>";
        echo "<td>{$car['power']}</td>";
    } elseif ($client === 'clientb') {
        $garageName = $garagesById[$car['garageId']] ?? 'N/A';
        echo "<td>" . strtolower($car['modelName']) . "</td>";
        echo "<td>{$car['brand']}</td>";
        echo "<td>{$garageName}</td>";
    } else {
        echo "<td>{$car['modelName']}</td>";
        echo "<td>{$car['brand']}</td>";
        echo "<td style='background-color:{$car['colorHex']}; color:#fff; text-align:center;'>{$car['colorHex']}</td>";
    }
    echo "</tr>";
}

echo "</tbody></table>";
?>