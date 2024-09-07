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
        <button id="indignation-button">Clique aqui</button>
        <div class="thermometer">
            Toques hoje: <span id="daily-touches">0</span><br>
            Toques na semana: <span id="weekly-touches">0</span><br>
            Toques no mês: <span id="monthly-touches">0</span>
        </div>
    </div>

    <script>
        // Aqui podemos adicionar a lógica para incrementar os toques e atualizá-los visualmente
        document.getElementById('indignation-button').addEventListener('click', function() {
            // Lógica para enviar o toque para o servidor e atualizar os contadores
            alert('Toque registrado!');
        });
    </script>
</body>
</html>
