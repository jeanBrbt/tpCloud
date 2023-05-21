<?php

try {
    $serverName = "cloudcomputingjean.database.windows.net";
    $database = "CloudComputing";
    $uid = "!!!!!!!!@lacatholille.fr"; // Remplacez "votre_uid" par le nom d'utilisateur approprié
    $pwd = "!!!!!!!!!!!!!!!!"; // Remplacez "votre_mot_de_passe" par le mot de passe approprié
      $bdd = new PDO("sqlsrv:server=$serverName;Database=$database;Authentication=ActiveDirectoryPassword", $uid, $pwd);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

} catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}
if( $bdd ) {
     echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    // Requête d'insertion des données
    $insertQuery = "INSERT INTO dbo.table_nom_prenom (id,nom, prenom) VALUES (1,:nom, :prenom)";
    $insertStatement = $bdd->prepare($insertQuery);
    $insertStatement->execute(array(':nom' => $nom, ':prenom' => $prenom));
}

$query = "SELECT nom, prenom FROM dbo.table_nom_prenom";
$result = $bdd->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        /* Style du tableau */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Style du formulaire */
        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"] {
            width: 200px;
            padding: 5px;
            border: 1px solid #ddd;
        }

        input[type="submit"] {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
</head>
<body>
    <table>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
        </tr>
        <?php

       while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>".$row['nom']."</td>";
            echo "<td>".$row['prenom']."</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <form method="POST">
        <label>
            Nom:
            <input type="text" name="nom">
        </label>
        <br>
        <label>
            Prénom:
            <input type="text" name="prenom">
        </label>
        <br>
        <input type="submit" value="Enregistrer">
    </form>
</body>
</html>