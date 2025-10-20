<?php
$client = $_GET['client'] ?? ($_COOKIE['client_id'] ?? 'clientb');

$garagesData = json_decode(file_get_contents(__DIR__ . '/../../../../data/garages.json'), true);

$garages = array_filter($garagesData, fn($g) => $g['customer'] === $client);

echo "<h2>Liste des garages pour <strong>$client</strong></h2>";
echo "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse:collapse;width:80%;'>";
echo "<thead><tr><th>Nom</th><th>Adresse</th></tr></thead><tbody>";

foreach($garages as $garage){
    echo "<tr class='garage-row' data-garageid='{$garage['id']}'>";
    echo "<td>{$garage['title']}</td>";
    echo "<td>{$garage['address']}</td>";
    echo "</tr>";
}

echo "</tbody></table>";
?>
<script>
$(document).on('click', '.garage-row', function() {
    var garageId = $(this).data('garageid');
    var client = getCookie('client_id') || 'clientb';
    var url = `/assessment/customs/shared/modules/garages/edit.php?client=${client}&garageid=${garageId}`;

    $.ajax({
        url: url,
        method: 'GET',
        success: function(data) {
            $('.dynamic-div').html(data);
        },
        error: function() {
            $('.dynamic-div').html('<p style="color:red;">Erreur lors du chargement de la vue détaillée du garage.</p>');
        }
    });
});
</script>
