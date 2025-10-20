<?php
$client = $_GET['client'] ?? ($_COOKIE['client_id'] ?? 'clientb');
$garageId = intval($_GET['garageid'] ?? 0);

$garagesData = json_decode(file_get_contents(__DIR__ . '/../../../../data/garages.json'), true);

$garage = null;
foreach($garagesData as $g){
    if($g['id'] === $garageId){
        $garage = $g;
        break;
    }
}

if(!$garage){
    echo "<p style='color:red;'>Garage introuvable</p>";
    exit;
}

echo "<h2>Détails du garage : {$garage['title']}</h2>";
echo "<ul>";
echo "<li>Nom : {$garage['title']}</li>";
echo "<li>Adresse : {$garage['address']}</li>";
echo "<li>Client : {$garage['customer']}</li>";
echo "</ul>";

echo "<button id='backToList'>Retour à la liste</button>";
?>
<script>
$('#backToList').on('click', function(){
    loadDynamicContent(); // Recharge la liste des garages
});
</script>
