<?php
$client = $_GET['client'] ?? ($_COOKIE['client_id'] ?? 'clienta');
$carId = intval($_GET['carid'] ?? 0);

$carsData = json_decode(file_get_contents(__DIR__ . '/../../../../data/cars.json'), true);
$garagesData = json_decode(file_get_contents(__DIR__ . '/../../../../data/garages.json'), true);

$car = null;
foreach ($carsData as $c) {
    if ($c['id'] === $carId) {
        $car = $c;
        break;
    }
}

if (!$car) {
    echo "<p style='color:red;'>Voiture introuvable</p>";
    exit;
}

$garageName = '';
foreach ($garagesData as $g) {
    if ($g['id'] === $car['garageId']) {
        $garageName = $g['title'];
        break;
    }
}

function formatYear($timestamp) { return date('Y-m-d', $timestamp); }

echo "<h2>Détails de la voiture : {$car['modelName']}</h2>";
echo "<ul>";
echo "<li>Nom : {$car['modelName']}</li>";
echo "<li>Marque : {$car['brand']}</li>";
echo "<li>Année : " . formatYear($car['year']) . "</li>";
echo "<li>Puissance : {$car['power']} ch</li>";
echo "<li>Garage : {$garageName}</li>";
echo "<li>Couleur : <span style='display:inline-block;width:20px;height:20px;background-color:{$car['colorHex']};'></span> {$car['colorHex']}</li>";
echo "<li>Client : {$car['customer']}</li>";
echo "</ul>";

echo "<button id='backToList'>Retour à la liste</button>";
?>

<script>
$('#backToList').on('click', function(){
    loadDynamicContent();
});
</script>