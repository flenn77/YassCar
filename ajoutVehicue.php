<?php

if (isset($_POST['ajouter'])) {
    $immatriculation = $_POST['immatriculation'];
    $marque = $_POST['marque'];
    $type = $_POST['type'];

    include('BaseDeDonnee.php');

    $verif = "SELECT COUNT(*) FROM vehicule WHERE immatriculation = :immatriculation";
    $verification = $connexionALaBdD->prepare($verif);
    $verification->bindParam(':immatriculation', $immatriculation);
    $verification->execute();
    $rowCount = $verification->fetchColumn();

    if ($rowCount > 0) {
        echo "<div class='error'>
                L'immatriculation existe déjà. 
              </div>";
    } else {
        $insertion = "INSERT INTO vehicule (immatriculation, marque, type) VALUES (:immatriculation, :marque, :type)";
        $requete = $connexionALaBdD->prepare($insertion);
        $requete->bindParam(':immatriculation', $immatriculation);
        $requete->bindParam(':marque', $marque);
        $requete->bindParam(':type', $type);

        if ($requete->execute()) {
            echo "<div class='success'>
                    Le véhicule a été ajouté avec succès. 
                  </div>";
        } else {
            $errorInfo = $requete->errorInfo();
            echo "<div class='error'>
                    Erreur lors de l'ajout du véhicule : " . $errorInfo[2] . "
                  </div>";
        }
    }
}



if (isset($_GET['delete'])) {
    $idVehicule = $_GET['delete'];
    include('BaseDeDonnee.php');

    $sqlCheckTrajets = "SELECT COUNT(*) FROM trajet WHERE idVehicule = :idVehicule";
    $stmtCheckTrajets = $connexionALaBdD->prepare($sqlCheckTrajets);
    $stmtCheckTrajets->bindParam(':idVehicule', $idVehicule);
    $stmtCheckTrajets->execute();
    $rowCount = $stmtCheckTrajets->fetchColumn();

    if ($rowCount > 0) {
        echo "<div class='error'> ";
        echo "e véhicule car il est déjà utilisé dans un trajet.";
        echo "</div>";

    } else {
        $sqlDeleteVehicule = "DELETE FROM vehicule WHERE idVehicule = :idVehicule";
        $stmtDeleteVehicule = $connexionALaBdD->prepare($sqlDeleteVehicule);
        $stmtDeleteVehicule->bindParam(':idVehicule', $idVehicule);

        if ($stmtDeleteVehicule->execute()) {
            echo "<div class='success' >";
            echo "Le véhicule a été supprimé avec succès.";
            echo "</div>";
        } else {
            echo "Erreur lors de la suppression du véhicule.";
        }
    }
}


?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Prise en charge d'un véhicule</title>
    <link href="gestionIndviduVehicule.css" rel="stylesheet" />
</head>

<body>



    <center> <br>
        <img src="logo.png" alt="LOGO" height="150px" width="300px">


        <br> <br>
        <a class="lien-styliseNav" href="gestionVehicule.html">Accueil</a>
        <a class="lien-styliseNav" href="prendreUnVehiculeEtape1.php">Prendre un véhicule</a>
        <a class="lien-styliseNav" href="rendreUnVehiculeEtape1.php">Rendre un véhicule</a>
        <a class="lien-styliseNav" href="ajoutIndividu.php">Gestion des Individus</a>
        <a class="lien-styliseNav" href="ajoutVehicue.php">Gestion des Véhicules</a><br><br><br>

        <h3> Ajouter un véhicule</h3>
    </center>
    <br>

    <form method="POST" action="ajoutVehicue.php" class="txtcentre">
        <input type="text" name="immatriculation" placeholder="Immatriculation"><br><br>
        <input type="text" name="marque" placeholder="Marque" required><br><br>
        <input type="text" name="type" placeholder="type" required><br><br>
        <button type="submit" name="ajouter">
            Ajouter
        </button>

    </form>
    <br>
    <hr><br>
    <center>
        <h2>Liste des véhicules</h2>
    
    <table class="txtcentre">
        <tr>
            <th>ID</th>
            <th>Immatriculation</th>
            <th>Marque</th>
            <th>Type</th>
            <th>Action</th>
        </tr>
        <?php
        include('BaseDeDonnee.php');

        $rqt = "SELECT * FROM vehicule";
        $rst = $connexionALaBdD->query($rqt);

        while ($row = $rst->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr >";
            echo "<td>" . $row['idVehicule'] . "</td>";
            echo "<td>" . $row['immatriculation'] . "</td>";
            echo "<td>" . $row['marque'] . "</td>";
            echo "<td>" . $row['type'] . "</td>";
            echo "<td><a href='ajoutVehicue.php?delete=" . $row['idVehicule'] . "' onclick='return confirmDelete()' class='deleteBtn'>Supprimer</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</center>

    <script>

        function confirmDelete(idVehicule) {
            if (confirm("supprimer ce véhicule ?")) {
                window.location.href = "ajoutVehicue.php?delete=" + idVehicule;
            }
        }
    </script>


</body>


</html>