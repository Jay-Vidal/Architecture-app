    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Liste des drones</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h1 class="text-center my-4">Liste des drones</h1>
            <?php
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL)
            
            $host = "localhost"; 
            $user = "dronedb";
            $password = "dronedb";
            $dbname = "dronedb";

            $connexion = mysqli_connect($host, $user, $password, $dbname);

            if (!$connexion) {
                die("Échec de la connexion : " . mysqli_connect_error());
            }

            $sql = "SELECT Drones.*, Positions.latitude, Positions.longitude, Positions.altitude FROM Drones LEFT JOIN Positions ON Drones.id = Positions.drone_id";

            $result = mysqli_query($connexion, $sql);

            if (mysqli_num_rows($result) > 0) {

                echo "<table class='table table-striped table-bordered'>";
                echo "<tr><th>Nom du drone</th><th>Description</th><th>Date de création</th><th>Latitude</th><th>Longitude</th><th>Altitude</th><th>Action</th></tr>";

                while ($drone = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($drone["nom"]) . "</td>";
                    echo "<td>" . htmlspecialchars($drone["description"]) . "</td>";
                    echo "<td>" . htmlspecialchars($drone["date_creation"]) . "</td>";

                    echo "<td>" . htmlspecialchars($drone["latitude"] ?? "-") . "</td>";
                    echo "<td>" . htmlspecialchars($drone["longitude"] ?? "-") . "</td>";
                    echo "<td>" . htmlspecialchars($drone["altitude"] ?? "-") . "</td>";

                    echo "<td><a href='#' class='btn btn-danger'>Supprimer</a></td>";

                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "Aucun drone trouvé dans la base de données.";
            }

            mysqli_close($connexion);
            ?>
            <br>
            <br>
            <button type="button" class="btn btn-secondary mt-3 d-block mx-auto" onclick="window.location.href='drone.php';">Retour</button>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    </body>
    </html>
