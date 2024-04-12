<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$user = "dronedb";
$password = "dronedb";
$dbname = "dronedb";

$connexion = mysqli_connect($host, $user, $password, $dbname);

if (!$connexion) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = file_get_contents('php://input');
    $drone = json_decode($data, true);

    if (!$drone) {
        die("Données JSON invalides.");
    }

    $nomDrone = isset($drone["nom_drone"]) ? $drone["nom_drone"] : null;
    $description = isset($drone["description"]) ? $drone["description"] : null;
    $latitude = isset($drone["latitude"]) ? $drone["latitude"] : null;
    $longitude = isset($drone["longitude"]) ? $drone["longitude"] : null;
    $altitude = isset($drone["altitude"]) ? $drone["altitude"] : null;

    $sqlDrones = "INSERT INTO Drones (nom, description) VALUES (?, ?)";
    $stmtDrones = mysqli_prepare($connexion, $sqlDrones); 

    if ($stmtDrones) {
        mysqli_stmt_bind_param($stmtDrones, "ss", $nomDrone, $description);
        
        if (mysqli_stmt_execute($stmtDrones)) {
            $droneId = mysqli_insert_id($connexion);

            $sqlPositions = "INSERT INTO Positions (drone_id, latitude, longitude, altitude) VALUES (?, ?, ?, ?)";
            $stmtPositions = mysqli_prepare($connexion, $sqlPositions);

            if ($stmtPositions) {
                mysqli_stmt_bind_param($stmtPositions, "iddd", $droneId, $latitude, $longitude, $altitude);
                
                if (mysqli_stmt_execute($stmtPositions)) {
                    echo json_encode(["message" => "Drone ajouté avec succès !"]);
                } else {
                    echo json_encode(["message" => "Échec de l'ajout du drone : " . mysqli_error($connexion)]);
                }

                mysqli_stmt_close($stmtPositions);
            } else {
                echo json_encode(["message" => "Échec de la préparation de la requête : " . mysqli_error($connexion)]);
            }
        } else {
            echo json_encode(["message" => "Échec de l'ajout du drone : " . mysqli_error($connexion)]);
        }

        mysqli_stmt_close($stmtDrones);
    } else {
        echo json_encode(["message" => "Échec de la préparation de la requête : " . mysqli_error($connexion)]);
    }
} else {
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un drone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script>
    document.getElementById('ajouterDroneForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var droneData = {
            "nom_drone": document.getElementById('nom_drone').value,
            "description": document.getElementById('description').value,
            "latitude": parseFloat(document.getElementById('latitude').value),
            "longitude": parseFloat(document.getElementById('longitude').value),
            "altitude": parseFloat(document.getElementById('altitude').value)
        };

        fetch('ajouter_drones.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(droneData),
        })
        .then(response => response.json())
        .then(data => {
            console.log('Réponse du serveur :', data);
        })
        .catch((error) => {
            console.error('Erreur lors de la requête :', error);
        });
    });
</script>
</body>
</html>
<?php
}
?>
