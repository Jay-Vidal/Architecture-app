<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Afficher les drones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;

            border-radius: 8px;

        }

        h1 {
            color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        th {

        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
        }

        .btn-secondary {
            background-color: #6c757d;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center my-4">Liste des drones</h1>
    <?php
        $host = "10.170.10.67";
        $user = "droneuser";
        $password = "esn";
        $dbname = "dronedb";

        $connexion = mysqli_connect($host, $user, $password, $dbname);

        $sql = "SELECT Drones.*, Positions.latitude, Positions.longitude, Positions.altitude FROM Drones LEFT JOIN Positions ON Drones.id = Positions.drone_id";

        $result = mysqli_query($connexion, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table class='table table-striped table-bordered'>";
            echo "<tr><th>Nom du drone</th><th>Description</th><th>Date de création</th><th>Latitude</th><th>Longitude</th><th>Altitude</th></tr>";

            while ($drone = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($drone["nom"]) . "</td>";
                echo "<td>" . htmlspecialchars($drone["description"]) . "</td>";
                echo "<td>" . htmlspecialchars($drone["date_creation"]) . "</td>";

                if (!is_null($drone["latitude"])) {
                    echo "<td>" . htmlspecialchars($drone["latitude"]) . "</td>";
                } else {
                    echo "<td>-</td>";
                }

                if (!is_null($drone["longitude"])) {
                    echo "<td>" . htmlspecialchars($drone["longitude"]) . "</td>";
                } else {
                    echo "<td>-</td>";
                }

                if (!is_null($drone["altitude"])) {
                    echo "<td>" . htmlspecialchars($drone["altitude"]) . "</td>";
                } else {
                    echo "<td>-</td>";
                }



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
    </div>
</body>
</html>