<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Mon premier formulaire</title>

<link href="prendreVehicule.css" rel="stylesheet" />


</head>

<body>
<br>
<a class="lien-styliseNav" href="gestionVehicule.html">Accueil</a>
        <a class="lien-styliseNav" href="prendreUnVehiculeEtape1.php">Prendre un véhicule</a>
        <a class="lien-styliseNav" href="rendreUnVehiculeEtape1.php">Rendre un véhicule</a>
        <a class="lien-styliseNav" href="ajoutIndividu.php">Gestion des Individus</a>
        <a class="lien-styliseNav" href="ajoutVehicue.php">Gestion des Véhicules</a><br><br><br>

    <br><br>
<div class="personne">
    <p>
    <?php
include 'BaseDeDonnee.php';

// Récupération des identifiants de la personne et du véhicule depuis l'URL
$identifiantPersonne = isset($_GET['idPersonne']) ? intval($_GET['idPersonne']) : 0;
$identifiantVehicule = isset($_GET['idVehicule']) ? intval($_GET['idVehicule']) : 0;
$formulaireTraite = false; // Variable pour indiquer si le traitement du formulaire est effectué

// Traitement lors de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $natureTrajet = empty($_POST['nature']) ? '' : $_POST['nature'];
    $dateDeDepart = empty($_POST['dateDepart']) ? '' : $_POST['dateDepart'];
    $heureDeDepart = empty($_POST['heureDepart']) ? '' : $_POST['heureDepart'];
    $lieuDeDepart = empty($_POST['lieuDepart']) ? '' : $_POST['lieuDepart'];
    $destinationTrajet = empty($_POST['destination']) ? '' : $_POST['destination'];
    $kilometrageAuDepart = 0;

    // Insertion des données dans la base de données
    $requeteInsertion = "INSERT INTO trajet (nature, dateDepart, heureDepart, lieuDepart, destination, kilometrageDepart ,dateArrivee, heureArrivee, idPersonne, idVehicule) 
      VALUES (:nature, :dateDepart, :heureDepart, :lieuDepart, :destination, :kilometrageDepart,:dateArrivee,:heureArrivee, :idPersonne, :idVehicule)";

    $preparationInsertion = $connexionALaBdD->prepare($requeteInsertion);

    if ($preparationInsertion->execute([
        ':nature' => $natureTrajet,
        ':dateDepart' => $dateDeDepart,
        ':heureDepart' => $heureDeDepart,
        ':lieuDepart' => $lieuDeDepart,
        ':destination' => $destinationTrajet,
        ':kilometrageDepart' => $_POST['kilometrageDepart'],
        ':dateArrivee' => $_POST['dateArrivee'],
        ':heureArrivee' => $_POST['heureArrivee'],
        ':idPersonne' => $identifiantPersonne,
        ':idVehicule' => $identifiantVehicule
    ])) {
        echo "<br><br><div class='success-container'><br><br>";
        echo "<h1 class='success-message'>Félicitation !</h1>";
        echo "<br><br></div><br><br>";
        echo "<a href='gestionVehicule.html' class='lien-styliseBack'>Retour à l'accueil</a>";
        $formulaireTraite = true; 
    } else {
        echo "<p class='error-message'>Erreur lors de l'enregistrement: " . htmlspecialchars($preparationInsertion->errorInfo()[2]) . "</p>";
    }

    $preparationInsertion->closeCursor();
}


  if (!$formulaireTraite):
    ?>
    </p>

    <form action="prendreUnVehiculeEtape3-v1.php?idPersonne=<?php echo $identifiantPersonne; ?>&idVehicule=<?php echo $identifiantVehicule; ?>" method="post" onsubmit="return testerSaisie();" name="enregistrerDonnees" class="personne">
    <input type="text" id="nature" name="nature" placeholder="Nature du trajet" required><br><br>

    <input type="date" id="dateDepart" name="dateDepart" placeholder="Date de départ" required><br><br>

    <input type="time" id="heureDepart" name="heureDepart" placeholder="Heure de départ" required><br><br>

    <input type="text" id="lieuDepart" name="lieuDepart" placeholder="Lieu de départ" required><br><br>

    <input type="text" id="destination" name="destination" placeholder="Destination" required><br><br>

    <?php
    $verifierImmatriculation = "SELECT immatriculation FROM vehicule WHERE idVehicule = :identifiantVehicule";
    $stmtImmatriculation = $connexionALaBdD->prepare($verifierImmatriculation);
    $stmtImmatriculation->execute([':identifiantVehicule' => $identifiantVehicule]);
    $ResuktatdesImmatriculation = $stmtImmatriculation->fetch();

    if (empty($ResuktatdesImmatriculation['immatriculation'])) {
        echo '<input type="hidden" name="kilometrageDepart" value="0">';
    } else {
        echo '<label for="kilometrageDepart">Kilométrage de départ:</label>';
        echo '<input type="number" id="kilometrageDepart" name="kilometrageDepart" required><br><br>';

    }
    ?>
    
    <input type="hidden" name="dateArrivee"value="0000-00-00">
    <input type="hidden" name="heureArrivee"value="0000:00:00">
     
    <input type="submit" value="Enregistrer le trajet"><br><br>

    <a class="lien-styliseBack" href="prendreUnVehiculeEtape2.php?idPersonne=<?php echo $identifiantPersonne; ?>">Précédent</a>
</form>

    <?php endif; ?>
</div>
<script type="text/javascript">
function testerSaisie() {
    // Vous pouvez ajouter ici les validations JavaScript si nécessaire
    // Par exemple, vérifier si le kilométrage de départ est inférieur au kilométrage de retour
    var Depart = document.forms["enregistrerDonnees"]["kilometrageDepart"].value;
    var Retour = document.forms["enregistrerDonnees"]["kilometrageRetour"].value;

    if (parseInt(Depart, 10) > parseInt(kRetour, 10)) {
        alert("Le kilométrage de départ doit être inférieur au kilométrage de retour.");
        return false;
    }
    return true;
}
</script>

</body>
</html>