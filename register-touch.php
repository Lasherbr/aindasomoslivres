<?php
// Conexão com o banco de dados
$host = 'localhost';
$dbname = 'aindasomoslivres';
$user = 'root';  // Substituir pelo usuário correto do MySQL
$pass = '';      // Substituir pela senha correta do MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

// Função para calcular a cidade mais próxima com base na latitude e longitude
function getClosestCity($latitude, $longitude, $pdo) {
    $sql = "SELECT id, city_name, latitude, longitude,
            (6371 * acos(cos(radians(:latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians(:longitude)) + sin(radians(:latitude)) * sin(radians(latitude)))) AS distance
            FROM cities
            ORDER BY distance ASC
            LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['latitude' => $latitude, 'longitude' => $longitude]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Função para registrar o toque
function registerTouch($city_id, $user_id = null, $pdo) {
    $sql = "INSERT INTO clicks (city_id, user_id, clicked_at) VALUES (:city_id, :user_id, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['city_id' => $city_id, 'user_id' => $user_id]);
}

// Captura a latitude e longitude do POST ou cidade selecionada manualmente
$latitude = isset($_POST['latitude']) ? $_POST['latitude'] : null;
$longitude = isset($_POST['longitude']) ? $_POST['longitude'] : null;
$city_id = isset($_POST['city_id']) ? $_POST['city_id'] : null;
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;  // Opcional se estiver logado

if ($latitude && $longitude) {
    // Busca a cidade mais próxima
    $city = getClosestCity($latitude, $longitude, $pdo);
    $city_id = $city['id'];
}

if ($city_id) {
    // Registra o toque no banco de dados
    registerTouch($city_id, $user_id, $pdo);
    echo json_encode(['status' => 'success', 'message' => 'Toque registrado com sucesso!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Localização ou cidade não encontrada.']);
}
?>
