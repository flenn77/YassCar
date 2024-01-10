<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Formulaire de Retour de Véhicule</title>
    <link href="rendreVehicule.css" rel="stylesheet" />

</head>

<body>
    <br>
    <div class="header">
        <h1 id="titre">Rendre Un Véhicule</h1>
        <nav class="navigation">
            <a class="lien-styliseNav" href="gestionVehicule.html">Accueil</a>
            <a class="lien-styliseNav" href="prendreUnVehiculeEtape1.php">Prendre un véhicule</a>
            <a class="lien-styliseNav" href="rendreUnVehiculeEtape1.php">Rendre un véhicule</a>
            <a class="lien-styliseNav" href="ajoutIndividu.php">Gestion des Individus</a>
            <a class="lien-styliseNav" href="ajoutVehicue.php">Gestion des Véhicules</a><br><br><br>
        </nav>
    </div>
    <?php
    include 'BaseDeDonnee.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idDuTrajet = $_POST['idTrajet'];
        $kmRetour = $_POST['kilometrageRetour'];
        $dateDeRetour = $_POST['dateArrivee'];
        $heureDeRetour = $_POST['heureArrivee'];

        $requeteKilometrage = "SELECT kilometrageDepart FROM trajet WHERE idTrajet = ?";
        $stmtKilometrage = $connexionALaBdD->prepare($requeteKilometrage);
        $stmtKilometrage->execute([$idDuTrajet]);
        if ($detailsTrajet = $stmtKilometrage->fetch()) {
            $kmDepart = $detailsTrajet['kilometrageDepart'];

            if ($kmRetour > $kmDepart) {
                $miseAJour = "UPDATE trajet SET kilometrageRetour = ?, dateArrivee = ?, heureArrivee = ? WHERE idTrajet = ?";
                $stmtMaj = $connexionALaBdD->prepare($miseAJour);
                if ($stmtMaj->execute([$kmRetour, $dateDeRetour, $heureDeRetour, $idDuTrajet])) {
                    echo "<div class='reussi'>Le véhicule a été retourné avec succès.</div>";
                    echo "<br><a href='gestionVehicule.html' class='home'>Accueil</a>";
                } else {
                    echo "<div class='error-message'>Erreur lors de l'enregistrement.</div>";
                    echo "<br><a href='gestionVehicule.html' class='home'>Accueil</a>";
                }
            } else {
                echo "<div class='error-message'>Le kilométrage de retour doit être supérieur au kilométrage de départ.</div>";
                echo "<br><a href='javascript:history.back()' class='back'>Retour</a><br>";
                echo "<br><a href='gestionVehicule.html' class='home'>Accueil</a>";
            }
        } else {
            echo "<div class='error-message'>Erreur lors de la récupération du kilométrage de départ.</div>";

            echo "<br><a href='gestionVehicule.html' class='home'>Accueil</a>";
        }


    } else {
        $idDuTrajet = isset($_GET['idTrajet']) ? intval($_GET['idTrajet']) : 0;
        $sqlImmatriculation = "SELECT immatriculation FROM vehicule WHERE idVehicule = (SELECT idVehicule FROM trajet WHERE idTrajet = :idTrajet)";
        $stmtImmatriculation = $connexionALaBdD->prepare($sqlImmatriculation);
        $stmtImmatriculation->execute([':idTrajet' => $idDuTrajet]);
        $resultImmatriculation = $stmtImmatriculation->fetch();

        $requeteKmDepart = "SELECT kilometrageDepart FROM trajet WHERE idTrajet = :idTrajet";
        $stmtKm = $connexionALaBdD->prepare($requeteKmDepart);
        $stmtKm->execute([':idTrajet' => $idDuTrajet]);
        $trajet = $stmtKm->fetch();
        $kilometrageDepart = $trajet['kilometrageDepart'];
        ?>


        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?idTrajet=<?php echo $idDuTrajet; ?>"
            method="post">
            <input type="hidden" name="idTrajet" value="<?php echo $idDuTrajet; ?>">
            <?php
            if (empty($resultImmatriculation['immatriculation'])) {
                echo '<input type="hidden" name="kilometrageRetour" value="1">';
            } else {
                echo '<label for="kilometrageRetour">Kilométrage de retour:</label>';
                echo '<input type="number" name="kilometrageRetour" id="kilometrageRetour" required><br><br>';
            }
            ?>

            <input type="date" name="dateArrivee" id="dateArrivee" placeholder="Date d'arrivée" required><br><br>
            <input type="time" name="heureArrivee" id="heureArrivee" placeholder="Heure d'arrivée" required><br><br>
            <input type="submit" value="Rendre le Véhicule">
            <center>
                <br><br>
                <a class="back" href="rendreUnVehiculeEtape1.php">Précédent</a>
                <a class="home" href="gestionVehicule.html">Accueil</a>
            </center>
        </form>


        <?php
    }
    ?>