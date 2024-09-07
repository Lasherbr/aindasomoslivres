<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ainda Somos Livres</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f9;
            margin: 0;
        }
        .container {
            text-align: center;
        }
        #indignation-button {
            width: 150px;
            height: 150px;
            background-color: #ff6f61;
            border-radius: 50%;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }
        .thermometer {
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <button id="indignation-button">Bora Manifestar</button>
        <div class="thermometer">
            Toques hoje: <span id="daily-touches">0</span><br>
            Toques na semana: <span id="weekly-touches">0</span><br>
            Toques no mês: <span id="monthly-touches">0</span>
        </div>
    </div>

    <script>
        document.getElementById('indignation-button').addEventListener('click', function() {
            // Verifica se o usuário já votou hoje através do cookie
            if (document.cookie.split(';').some((item) => item.trim().startsWith('voted_today='))) {
                alert('Você já se manifestou hoje. Tente novamente amanhã!');
            } else {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        // Envia a localização para o backend
                        const data = {
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude
                        };
                        sendTouch(data);
                    }, function() {
                        alert('Por favor, selecione a cidade manualmente.');
                    });
                } else {
                    alert('Geolocalização não é suportada pelo seu navegador.');
                }
            }
        });

        function sendTouch(data) {
            fetch('register_touch.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Define um cookie para impedir novos toques no mesmo dia
                    document.cookie = "voted_today=1; max-age=86400; path=/"; // Expira em 24 horas
                    alert(data.message);
                    // Atualizar termômetro visual
                } else {
                    alert(data.message);
                }
            });
        }
    </script>
</body>
</html>
