<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tool4cars</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <label for="clientSelect">Choisir un client :</label>
    <select id="clientSelect">
        <option value="clienta">Client A</option>
        <option value="clientb">Client B</option>
        <option value="clientc">Client C</option>
    </select>

    <label for="moduleSelect">Choisir un module :</label>
    <select id="moduleSelect">
        <option value="cars">Cars</option>
        <option value="garages">Garages</option>
    </select>
  
    <div class="dynamic-div" data-module="cars" data-script="ajax"></div>

    
    <script>
        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days*24*60*60*1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "")  + expires + "; path=/";
        }

        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
            }
            return null;
        }
        function loadDynamicContent() {
            var client = getCookie('client_id') || 'clienta';
            var module = $('#moduleSelect').val() || 'cars';
            var script = 'ajax';

            if(module === 'garages' && client !== 'clientb') {
                $('.dynamic-div').html('<p style="color:red;">Module non disponible pour ce client.</p>');
                return;
            }

            var url = `/assessment/customs/shared/modules/${module}/${script}.php?client=${client}`;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    $('.dynamic-div').html(data);
                },
                error: function() {
                    $('.dynamic-div').html('<p style="color:red;">Erreur lors du chargement du contenu.</p>');
                }
            });
        }

        $(document).ready(function() {
            if (!getCookie('client_id')) {
                setCookie('client_id', 'clienta', 7);
            }

            loadDynamicContent();

            $('#clientSelect').on('change', function() {
                var client = $(this).val();
                setCookie('client_id', client, 7);

                if(client !== 'clientb'){
                    $('#moduleSelect option[value="garages"]').hide();
                    $('#moduleSelect').val('cars');
                } else {
                    $('#moduleSelect option[value="garages"]').show();
                }

                loadDynamicContent();
            });

            $('#moduleSelect').on('change', function() {
                loadDynamicContent();
            });
        });

        $(document).on('click', '.car-row', function() {
            var carId = $(this).data('carid');
            var client = getCookie('client_id') || 'clienta';
            
            var url = `/assessment/customs/shared/modules/cars/edit.php?client=${client}&carid=${carId}`;

            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    $('.dynamic-div').html(data);
                },
                error: function() {
                    $('.dynamic-div').html('<p style="color:red;">Erreur lors du chargement de la vue détaillée.</p>');
                }
            });
        });
    </script>
</body>
</html>
