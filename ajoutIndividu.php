<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Gestion des Individus</title>
    <link href="gestionIndviduVehicule.css" rel="stylesheet" />

    <?php
    if (isset($_POST['ajouter'])) {
        $civilite = $_POST['civilite'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $mail = $_POST['mail'];

        include('BaseDeDonnee.php');

        $verif = "SELECT COUNT(*) FROM personne WHERE nom = :nom AND prenom = :prenom";
        $verification = $connexionALaBdD->prepare($verif);
        $verification->bindParam(':nom', $nom);
        $verification->bindParam(':prenom', $prenom);
        $verification->execute();
        $rowCount = $verification->fetchColumn();

        if ($rowCount > 0) {
            echo "<div class='error'>
                L'individu existe déjà. 
              </div>";
        } else {
            $insertion = "INSERT INTO personne (civilite, nom, prenom, mail) VALUES (:civilite, :nom, :prenom, :mail)";
            $requete = $connexionALaBdD->prepare($insertion);
            $requete->bindParam(':civilite', $civilite);
            $requete->bindParam(':nom', $nom);
            $requete->bindParam(':prenom', $prenom);
            $requete->bindParam(':mail', $mail);

            if ($requete->execute()) {
                echo "<div class='success'>
                    L'individu a été ajouté avec succès. 
                  </div>";
            } else {
                $errorInfo = $requete->errorInfo();
                echo "<div class='error'>
                    Erreur lors de l'ajout de l'individu : " . $errorInfo[2] . "
                  </div>";
            }
        }
    }

    if (isset($_GET['delete'])) {
        $idPersonne = $_GET['delete'];
        include('BaseDeDonnee.php');


        $supprimer = "DELETE FROM personne WHERE idPersonne = :idPersonne";
        $requetesupprimer = $connexionALaBdD->prepare($supprimer);
        $requetesupprimer->bindParam(':idPersonne', $idPersonne);

        if ($requetesupprimer->execute()) {
            echo "<div class='success' >";
            echo "L'individu a été supprimé avec succès.";
            echo "</div>";
        } else {
            echo "<div class='error' >";
            echo "Erreur lors de la suppression de l'individu.";
            echo "</div>";

        }
    }
    ?>
</head>

<body>

    <center> <br>
        <img src="logo.png" alt="LOGO" height="150px" width="300px">
        <br><br>
        <a class="lien-styliseNav" href="gestionVehicule.html">Accueil</a>
        <a class="lien-styliseNav" href="prendreUnVehiculeEtape1.php">Prendre un véhicule</a>
        <a class="lien-styliseNav" href="rendreUnVehiculeEtape1.php">Rendre un véhicule</a>
        <a class="lien-styliseNav" href="ajoutIndividu.php">Gestion des Individus</a>
        <a class="lien-styliseNav" href="ajoutVehicue.php">Gestion des Véhicules</a><br><br><br>

        <h3>Ajouter un Individu</h3>
    </center>
    <br>

    <form method="POST" action="ajoutIndividu.php" class="txtcentre">
        <div>
            <input type="radio" name="civilite" value="Monsieur" id="monsieur">
            <label for="monsieur">Monsieur</label>

            <input type="radio" name="civilite" value="Madame" id="madame">
            <label for="madame">Madame</label>

            <input type="radio" name="civilite" value="Autre" id="autre">
            <label for="autre">Autre</label>
        </div>

        <br>
        <input type="text" name="nom" placeholder="Nom" required><br><br>
        <input type="text" name="prenom" placeholder="Prénom" required><br><br>
        <input type="email" name="mail" placeholder="Mail" required><br>
        <br>
        <button type="submit" name="ajouter">
            Ajouter
        </button>
    </form>

    <br>
    <hr><br>
    <center>
        <h2>Liste des Individus</h2>

        <table class="txtcentre">
            <tr>
                <th>ID</th>
                <th>Civilité</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Mail</th>
                <th>Action</th>
            </tr>

            <?php
            include('BaseDeDonnee.php');
            $rqt = "SELECT * FROM personne";
            $resultat = $connexionALaBdD->query($rqt);
            while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr >";
                echo "<td>" . $row['idPersonne'] . "</td>";
                echo "<td>" . $row['civilite'] . "</td>";
                echo "<td>" . $row['nom'] . "</td>";
                echo "<td>" . $row['prenom'] . "</td>";
                echo "<td>" . $row['mail'] . "</td>";
                echo "<td><a href='ajoutIndividu.php?delete=" . $row['idPersonne'] . "' onclick='return confirmDelete()' class='deleteBtn'>Supprimer</a></td>";
                echo "</tr>";

            }
            ?>
        </table>
    </center>
    <script>
        function confirmDelete(idPersonne) {
            if (confirm("Contifmer la suppression ?")) {
                window.location.href = "ajoutIndividu.php?delete=" + idPersonne;
            }
        }
    </script>
</body>

</html>